(() => {
    'use strict';
    const KEY = 'pem-student-profile:v1';
    const PHOTO_LIMIT = 2 * 1024 * 1024;
    const PLACEHOLDER = '👤';
    const panel = document.querySelector('[data-student-profile-form]');
    const safeRead = () => {
        try {
            const data = JSON.parse(localStorage.getItem(KEY) || 'null');
            if (!data || data.version !== 1 ||
                typeof data.name !== 'string' ||
                typeof data.nim !== 'string' ||
                !/^\d{6,20}$/.test(data.nim) ||
                data.name.length > 100) return null;
            return {
                name: data.name,
                nim: data.nim,
                photo: typeof data.photo === 'string' &&
                    /^data:image\/(?:webp|jpeg|png);base64,[a-zA-Z0-9+/=]+$/.test(data.photo) &&
                    data.photo.length < 700000 ? data.photo : '',
            };
        } catch {
            return null;
        }
    };
    const status = panel?.querySelector('[data-profile-status]');
    const setStatus = (message) => { if (status) status.textContent = message; };
    const avatar = (node, profile) => {
        if (!node) return;
        node.replaceChildren();
        if (profile?.photo) {
            const img = document.createElement('img');
            img.src = profile.photo;
            img.alt = 'Foto profil mahasiswa';
            img.decoding = 'async';
            node.append(img);
        } else {
            node.textContent = profile?.name?.trim()?.[0]?.toUpperCase() || PLACEHOLDER;
        }
    };
    const addHeader = () => {
        const bar = document.querySelector('.platform-bar');
        if (!bar || bar.querySelector('[data-student-profile-link]')) return;
        const link = document.createElement('a');
        link.className = 'student-profile-link';
        link.href = '/profil-mahasiswa';
        link.dataset.studentProfileLink = '';
        const photo = document.createElement('span');
        photo.className = 'student-profile-mini-avatar';
        photo.dataset.studentProfileAvatar = '';
        const label = document.createElement('span');
        label.dataset.studentProfileName = '';
        link.append(photo, label);
        bar.append(link);
    };
    const update = () => {
        const p = safeRead();
        document.querySelectorAll('[data-student-profile-avatar]').forEach((x) => avatar(x, p));
        document.querySelectorAll('[data-student-profile-name]').forEach((x) => {
            x.textContent = p?.name || 'Isi profil';
            x.title = p ? p.name + ' · ' + p.nim : 'Simpan profil mahasiswa pada browser ini';
        });
        if (panel) {
            const name = panel.querySelector('[name="student_name"]');
            const nim = panel.querySelector('[name="student_nim"]');
            const preview = panel.querySelector('[data-profile-preview]');
            if (name && !name.matches(':focus')) name.value = p?.name || '';
            if (nim && !nim.matches(':focus')) nim.value = p?.nim || '';
            avatar(preview, p);
        }
        const report = document.querySelector('#report-form');
        if (report && p) {
            const inputs = report.querySelectorAll('input[type="text"]');
            if (inputs[0] && !inputs[0].value) inputs[0].value = p.name;
            if (inputs[1] && !inputs[1].value) inputs[1].value = p.nim;
        }
    };
    addHeader();
    update();
    window.addEventListener('storage', (event) => {
        if (event.key === KEY || event.key === null) update();
    });

    if (!panel) return;
    const form = panel.querySelector('form');
    const name = form.querySelector('[name="student_name"]');
    const nim = form.querySelector('[name="student_nim"]');
    const fileInput = form.querySelector('[name="student_photo"]');
    let selectedPhoto = safeRead()?.photo || '';
    let imageBusy = false;
    const removePhotoButton = panel.querySelector('[data-remove-profile-photo]');
    fileInput.addEventListener('change', () => {
        const file = fileInput.files?.[0];
        fileInput.value = '';
        if (!file) return;
        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type) ||
            file.size > PHOTO_LIMIT) {
            setStatus('Pilih JPG, PNG, atau WebP maksimal 2 MB.');
            return;
        }
        imageBusy = true;
        setStatus('Memproses foto di browser…');
        const image = new Image();
        const url = URL.createObjectURL(file);
        image.onload = () => {
            try {
                const canvas = document.createElement('canvas');
                canvas.width = 224;
                canvas.height = 224;
                const ctx = canvas.getContext('2d');
                if (!ctx) throw Error('Canvas tidak tersedia');
                const side = Math.min(image.naturalWidth, image.naturalHeight);
                const sx = (image.naturalWidth - side) / 2;
                const sy = (image.naturalHeight - side) / 2;
                ctx.fillStyle = '#fff';
                ctx.fillRect(0, 0, 224, 224);
                ctx.drawImage(image, sx, sy, side, side, 0, 0, 224, 224);
                selectedPhoto = canvas.toDataURL('image/jpeg', 0.78);
                avatar(panel.querySelector('[data-profile-preview]'), {
                    photo: selectedPhoto,
                    name: name.value,
                });
                setStatus('Foto sudah diperkecil. Klik Simpan Profil untuk menyimpannya.');
            } catch {
                setStatus('Foto tidak dapat diproses. Coba gambar lain.');
            } finally {
                URL.revokeObjectURL(url);
                imageBusy = false;
            }
        };
        image.onerror = () => {
            URL.revokeObjectURL(url);
            imageBusy = false;
            setStatus('Berkas gambar tidak dapat dibaca.');
        };
        image.src = url;
    });
    removePhotoButton.addEventListener('click', () => {
        selectedPhoto = '';
        avatar(panel.querySelector('[data-profile-preview]'), {
            name: name.value,
        });
        setStatus('Foto akan dihapus ketika profil disimpan.');
    });
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const normalizedName = name.value.trim().replace(/\s+/g, ' ');
        const normalizedNim = nim.value.trim();
        if (imageBusy) {
            setStatus('Foto masih diproses. Ulangi setelah selesai.');
            return;
        }
        if (normalizedName.length < 2 || normalizedName.length > 100 ||
            !/^\d{6,20}$/.test(normalizedNim)) {
            setStatus('Nama harus 2–100 karakter; NIM harus 6–20 angka.');
            return;
        }
        try {
            localStorage.setItem(KEY, JSON.stringify({
                version: 1,
                name: normalizedName,
                nim: normalizedNim,
                photo: selectedPhoto,
            }));
            update();
            setStatus('Profil tersimpan pada browser ini. Tidak dikirim ke server.');
        } catch {
            setStatus('Penyimpanan browser penuh atau dinonaktifkan. Coba foto yang lebih kecil.');
        }
    });
    panel.querySelector('[data-remove-student-profile]').addEventListener('click', () => {
        if (!confirm('Hapus nama, NIM, dan foto profil dari browser ini?')) return;
        try {
            localStorage.removeItem(KEY);
            selectedPhoto = '';
            name.value = '';
            nim.value = '';
            update();
            setStatus('Profil lokal dihapus. Data pada server tidak berubah karena tidak pernah diunggah.');
        } catch {
            setStatus('Profil lokal tidak dapat dihapus. Periksa izin penyimpanan browser.');
        }
    });
})();