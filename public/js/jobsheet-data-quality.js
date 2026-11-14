(() => {
    const tables = document.querySelectorAll('[data-observation-table]');

    const read = (row, key) => {
        const cell = row.querySelector('[data-col="' + key + '"]');
        if (!cell) return null;
        const input = cell.querySelector('input');
        const raw = input ? input.value.trim() : cell.dataset.raw;
        if (raw === undefined || raw === '') return null;
        const value = Number(raw);
        return Number.isFinite(value) ? value : NaN;
    };

    tables.forEach((table) => {
        const status = table.querySelector('[data-quality-summary]');
        if (!status) return;

        const update = () => {
            let completed = 0;
            let empty = 0;
            let flagged = 0;
            let theoreticalLimit = 0;
            const kind = table.dataset.tableKind;

            table.querySelectorAll('tbody tr').forEach((row) => {
                const errors = [];
                const inputs = Array.from(row.querySelectorAll('input'));
                const hasAny = inputs.some((input) => input.value.trim() !== '');
                const hasAll = inputs.every((input) => input.value.trim() !== '');
                row.classList.remove('jobsheet-row-warning');
                row.removeAttribute('title');

                if (!hasAny) {
                    empty += 1;
                    return;
                }

                inputs.forEach((input) => {
                    const value = input.value.trim();
                    if (!value) return;
                    const number = Number(value);
                    if (!Number.isFinite(number) || !input.validity.valid) {
                        errors.push('Ada nilai numerik yang tidak valid');
                    }
                });

                if (kind === 'lpf') {
                    const vin = read(row, 'vin');
                    const vout = read(row, 'vout');
                    if (vin !== null && !(vin > 0)) {
                        errors.push('Vin harus lebih besar dari 0 untuk menghitung dB');
                    }
                    if (vout !== null && !(vout > 0)) {
                        errors.push('Vout harus lebih besar dari 0 agar nilai dB hingga dapat dihitung');
                    }
                }

                if (kind === 'ad620') {
                    const vin1 = read(row, 'vin1');
                    const vin2 = read(row, 'vin2');
                    const rg = read(row, 'rg');
                    if (vin1 !== null && vin2 !== null && rg > 0) {
                        const theoreticalOutput = (vin1 - vin2) *
                            (1 + 49400 / rg);
                        if (Math.abs(theoreticalOutput) >= 12) {
                            theoreticalLimit += 1;
                            errors.push(
                                'Output ideal mencapai/melebihi 12 V; catu ±12 V pada panduan tidak menjamin keluaran riil mampu mencapai nilai ini',
                            );
                        }
                        if (vin1 === vin2) {
                            errors.push('Vin diferensial nol: gain praktik tidak terdefinisi');
                        }
                    }
                }

                if (errors.length > 0) {
                    flagged += 1;
                    row.classList.add('jobsheet-row-warning');
                    row.title = errors.join('; ');
                } else if (hasAll) {
                    completed += 1;
                }
            });

            status.textContent =
                'Pemeriksaan otomatis: ' + completed + ' baris terisi dan tidak ditandai, ' +
                empty + ' baris kosong, ' + flagged + ' baris perlu ditinjau.' +
                (theoreticalLimit
                    ? ' ' + theoreticalLimit +
                        ' baris AD620 memiliki keluaran ideal yang mencapai/melebihi 12 V.'
                    : '') +
                ' Pemeriksaan ini hanya bantuan belajar dan bukan validasi pengukuran atau keamanan alat.';
        };

        table.addEventListener('input', update);
        update();
    });
})();
