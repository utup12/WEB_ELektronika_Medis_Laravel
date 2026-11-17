(() => {
    const form = document.querySelector('[data-r2-upload-form]');
    if (!form) return;

    const r2Enabled = form.dataset.r2Enabled === '1';
    if (!r2Enabled) return;

    const presignUrl = form.dataset.presignUrl;
    const storeUrl = form.dataset.storeUrl;
    const fileInput = form.querySelector('input[type="file"][name="report"]');
    const moduleSelect = form.querySelector('select[name="module"]');
    const submitButton = form.querySelector('button[type="submit"]');
    const statusBox = document.querySelector('[data-r2-status]');
    const csrfToken =
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content') || '';

    const setStatus = (text, kind = 'info') => {
        if (!statusBox) return;
        statusBox.hidden = false;
        statusBox.className =
            kind === 'error'
                ? 'notice error'
                : kind === 'success'
                  ? 'notice success'
                  : 'notice';
        statusBox.textContent = text;
    };

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const moduleName = moduleSelect?.value?.trim() || '';
        const file = fileInput?.files?.[0];

        if (!moduleName) {
            setStatus('Pilih modul praktikum terlebih dahulu.', 'error');
            return;
        }

        if (!file) {
            setStatus('Pilih berkas PDF laporan terlebih dahulu.', 'error');
            return;
        }

        if (
            file.type !== 'application/pdf' &&
            !file.name.toLowerCase().endsWith('.pdf')
        ) {
            setStatus('Format berkas harus PDF (.pdf).', 'error');
            return;
        }

        const maxBytes = 10 * 1024 * 1024;
        if (file.size > maxBytes) {
            setStatus(
                'Ukuran berkas melebihi batas maksimum 10 MB.',
                'error',
            );
            return;
        }

        if (submitButton) submitButton.disabled = true;

        try {
            setStatus('Meminta izin unggah ke Cloudflare R2…');
            const presignRes = await fetch(presignUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    original_name: file.name,
                    content_type: 'application/pdf',
                    size: file.size,
                }),
            });

            if (!presignRes.ok) {
                const err = await presignRes.json().catch(() => ({}));
                throw new Error(
                    err.message ||
                        'Gagal membuat tautan unggah Cloudflare R2.',
                );
            }

            const { key, upload_url: uploadUrl } = await presignRes.json();

            setStatus('Mengunggah berkas PDF langsung ke Cloudflare R2…');
            const putRes = await fetch(uploadUrl, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/pdf' },
                body: file,
            });

            if (!putRes.ok) {
                throw new Error(
                    'Unggah langsung ke Cloudflare R2 ditolak. Periksa pengaturan CORS bucket R2.',
                );
            }

            setStatus('Mencatat data laporan ke database…');
            const storeRes = await fetch(storeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    module: moduleName,
                    r2_key: key,
                    original_name: file.name,
                }),
            });

            if (!storeRes.ok) {
                const err = await storeRes.json().catch(() => ({}));
                throw new Error(
                    err.message || 'Gagal menyimpan catatan laporan.',
                );
            }

            const result = await storeRes.json();
            setStatus(
                result.message || 'Laporan berhasil dikirim ke Cloudflare R2.',
                'success',
            );
            window.location.href = result.redirect || window.location.href;
        } catch (error) {
            setStatus(
                error instanceof Error
                    ? error.message
                    : 'Terjadi kesalahan saat mengunggah ke Cloudflare R2.',
                'error',
            );
        } finally {
            if (submitButton) submitButton.disabled = false;
        }
    });
})();
