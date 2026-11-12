(() => {
    const workspace = document.querySelector('[data-jobsheet-workspace]');
    if (!workspace) return;

    const edition = workspace.dataset.edition;
    const module = workspace.dataset.module;
    const key = 'jobsheet-draft:v1:' + edition + ':' + module;
    const tables = Array.from(document.querySelectorAll('[data-observation-table]'));
    const questions = Array.from(document.querySelectorAll('[data-discussion-answer]'));
    const identity = workspace.querySelector('[data-student-label]');
    const savedStatus = workspace.querySelector('[data-draft-status]');
    const progress = workspace.querySelector('[data-work-progress]');
    const progressDetails = workspace.querySelector('[data-work-progress-detail]');
    const loadFile = workspace.querySelector('[data-import-file]');
    const report = document.querySelector('[data-print-report]');
    const maxFileBytes = 256 * 1024;
    let dirty = false;

    const mark = (message) => {
        savedStatus.textContent = message;
    };

    const collect = () => ({
        schema_version: 1,
        edition,
        module,
        saved_at: new Date().toISOString(),
        student_label: identity.value.trim().slice(0, 100),
        tables: tables.map((table) => ({
            id: table.dataset.tableId,
            rows: Array.from(table.querySelectorAll('tbody tr')).map((row) => {
                const inputs = {};
                row.querySelectorAll('[data-input-col]').forEach((input) => {
                    inputs[input.dataset.inputCol] = input.value;
                });
                return inputs;
            }),
        })),
        discussion: questions.map((textarea) => textarea.value),
    });

    const calculateProgress = () => {
        let filled = 0;
        let total = 0;

        tables.forEach((table) => {
            table.querySelectorAll('tbody tr').forEach((row) => {
                const inputs = Array.from(row.querySelectorAll('[data-input-col]'));
                total += inputs.length;
                filled += inputs.filter((input) => input.value.trim() !== '').length;
            });
        });
        total += questions.length;
        filled += questions.filter((textarea) => textarea.value.trim() !== '').length;
        progress.max = Math.max(total, 1);
        progress.value = filled;
        progressDetails.textContent =
            filled + ' dari ' + total +
            ' kolom pengamatan/jawaban terisi. Bukan nilai atau penilaian kompetensi.';
    };

    const validate = (draft) => {
        if (!draft || draft.schema_version !== 1 ||
            draft.edition !== edition || draft.module !== module ||
            !Array.isArray(draft.tables) ||
            !Array.isArray(draft.discussion) ||
            draft.tables.length !== tables.length ||
            draft.discussion.length !== questions.length ||
            typeof draft.student_label !== 'string' ||
            draft.student_label.length > 100) {
            return false;
        }

        for (let index = 0; index < tables.length; index += 1) {
            const incoming = draft.tables[index];
            const rows = Array.from(tables[index].querySelectorAll('tbody tr'));

            if (!incoming || incoming.id !== tables[index].dataset.tableId ||
                !Array.isArray(incoming.rows) || incoming.rows.length !== rows.length) {
                return false;
            }

            for (let rowIndex = 0; rowIndex < rows.length; rowIndex += 1) {
                const inputRow = incoming.rows[rowIndex];
                if (!inputRow || typeof inputRow !== 'object' ||
                    Array.isArray(inputRow)) {
                    return false;
                }

                for (const input of rows[rowIndex].querySelectorAll('[data-input-col]')) {
                    const value = inputRow[input.dataset.inputCol];
                    if (typeof value !== 'string' || value.length > 32 ||
                        (value !== '' && (!Number.isFinite(Number(value)) ||
                        !/^-?\d+(?:\.\d+)?$/.test(value)))) {
                        return false;
                    }
                }
            }
        }

        return draft.discussion.every((answer) => {
            return typeof answer === 'string' && answer.length <= 2000;
        });
    };

    const restore = (draft) => {
        if (!validate(draft)) {
            mark('Berkas tidak cocok dengan jobsheet ini atau formatnya tidak valid.');
            return;
        }

        identity.value = draft.student_label;
        tables.forEach((table, index) => {
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach((row, rowIndex) => {
                row.querySelectorAll('[data-input-col]').forEach((input) => {
                    input.value =
                        draft.tables[index].rows[rowIndex][input.dataset.inputCol];
                });
            });
            table.dispatchEvent(new Event('input', { bubbles: true }));
        });
        questions.forEach((textarea, index) => {
            textarea.value = draft.discussion[index];
        });
        dirty = false;
        calculateProgress();
        mark('Draf dimuat. Periksa kembali nilai sebelum membuat laporan.');
    };

    const download = (filename, data, type) => {
        const url = URL.createObjectURL(new Blob([data], { type }));
        const anchor = document.createElement('a');
        anchor.href = url;
        anchor.download = filename;
        document.body.append(anchor);
        anchor.click();
        anchor.remove();
        URL.revokeObjectURL(url);
    };

    const filePrefix = edition + '-' + module;
    const save = workspace.querySelector('[data-save-draft]');
    save.addEventListener('click', () => {
        try {
            localStorage.setItem(key, JSON.stringify(collect()));
            dirty = false;
            mark('Draf tersimpan di browser/perangkat ini saja. Tidak dikirim ke server.');
        } catch {
            mark('Penyimpanan browser tidak tersedia. Gunakan ekspor JSON.');
        }
    });

    workspace.querySelector('[data-load-draft]').addEventListener('click', () => {
        try {
            const raw = localStorage.getItem(key);
            if (!raw) {
                mark('Belum ada draf lokal untuk modul ini.');
                return;
            }
            if (dirty && !window.confirm('Ganti isian sekarang dengan draf tersimpan?')) return;
            restore(JSON.parse(raw));
        } catch {
            mark('Draf tersimpan tidak dapat dibaca.');
        }
    });

    workspace.querySelector('[data-delete-draft]').addEventListener('click', () => {
        if (!window.confirm('Hapus draf tersimpan pada browser ini?')) return;
        try {
            localStorage.removeItem(key);
            mark('Draf browser dihapus. Isian pada halaman tidak berubah.');
        } catch {
            mark('Penyimpanan browser tidak dapat diakses.');
        }
    });

    workspace.querySelector('[data-export-json]').addEventListener('click', () => {
        download(
            filePrefix + '-draf.json',
            JSON.stringify(collect(), null, 2),
            'application/json;charset=utf-8',
        );
        mark('Berkas JSON diunduh. Simpan di tempat yang aman.');
    });

    workspace.querySelector('[data-import-json]').addEventListener('click', () => {
        loadFile.click();
    });

    loadFile.addEventListener('change', async () => {
        const file = loadFile.files?.[0];
        loadFile.value = '';
        if (!file) return;
        if (file.size > maxFileBytes || !file.name.toLowerCase().endsWith('.json')) {
            mark('Hanya file JSON draf maksimal 256 KB yang didukung.');
            return;
        }
        try {
            const draft = JSON.parse(await file.text());
            if (dirty && !window.confirm('Timpa isian sekarang dengan berkas ini?')) return;
            restore(draft);
        } catch {
            mark('Berkas gagal dibaca. Isian lama tidak diubah.');
        }
    });

    const element = (tag, text) => {
        const node = document.createElement(tag);
        if (text !== undefined) node.textContent = text;
        return node;
    };

    workspace.querySelector('[data-print-worksheet]').addEventListener(
        'click',
        () => {
            report.replaceChildren();
            report.append(
                element('h1', 'Laporan Pengamatan Praktikum'),
                element('p', 'Modul: ' + module + ' · Edisi: ' + edition),
                element('p', 'Identitas (opsional): ' + (identity.value.trim() || '—')),
                element(
                    'p',
                    'Hasil teori berbeda dari pengukuran. Data kosong tidak boleh dianggap sebagai hasil eksperimen.',
                ),
            );

            tables.forEach((table) => {
                const heading = table.querySelector('h3');
                report.append(element('h2', heading?.textContent || 'Tabel Pengamatan'));
                const printTable = element('table');
                const head = element('thead');
                const headRow = element('tr');
                table.querySelectorAll('thead th').forEach((header) => {
                    headRow.append(element('th', header.textContent.trim()));
                });
                head.append(headRow);
                printTable.append(head);

                const body = element('tbody');
                table.querySelectorAll('tbody tr').forEach((row) => {
                    const tr = element('tr');
                    row.querySelectorAll('td').forEach((cell) => {
                        const input = cell.querySelector('input');
                        const result = cell.querySelector('[data-result-col]');
                        const text = input
                            ? input.value || '—'
                            : result?.textContent || cell.textContent.trim();
                        tr.append(element('td', text));
                    });
                    body.append(tr);
                });
                printTable.append(body);
                report.append(printTable);
            });

            questions.forEach((textarea, index) => {
                const item = textarea.closest('.jobsheet-discussion-item');
                report.append(
                    element('h2', 'Diskusi ' + (index + 1)),
                    element('p', item?.querySelector('label')?.textContent || ''),
                    element('p', textarea.value.trim() || '(belum diisi)'),
                );
            });

            report.append(
                element(
                    'p',
                    'Referensi: Panduan Praktikum Instrumentasi dan Elektronika Medis 2019. Diagram rangkaian dan prosedur keselamatan harus dicek pada dokumen asli.',
                ),
            );
            window.print();
        },
    );

    workspace.addEventListener('input', () => {
        dirty = true;
        calculateProgress();
        mark('Ada perubahan yang belum disimpan. Simpan draf atau ekspor JSON.');
    });
    document.querySelectorAll('[data-observation-table]').forEach((table) => {
        table.addEventListener('input', () => {
            dirty = true;
            calculateProgress();
            mark('Ada perubahan yang belum disimpan. Simpan draf atau ekspor JSON.');
        });
    });
    document.querySelectorAll('[data-discussion-answer]').forEach((textarea) => {
        textarea.addEventListener('input', () => {
            dirty = true;
            calculateProgress();
            mark('Ada perubahan yang belum disimpan. Simpan draf atau ekspor JSON.');
        });
    });

    calculateProgress();
    try {
        if (localStorage.getItem(key)) {
            mark('Tersedia draf di browser ini. Pilih "Muat draf" untuk menggunakannya.');
        }
    } catch {
        mark('Penyimpanan lokal browser tidak tersedia. Gunakan ekspor JSON.');
    }
})();
