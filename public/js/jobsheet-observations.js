(() => {
    const numberFormat = new Intl.NumberFormat('id-ID', {
        maximumFractionDigits: 4,
    });

    const readNumber = (row, key) => {
        const fixed = row.querySelector('[data-col="' + key + '"][data-raw]');

        if (fixed) {
            const value = Number(fixed.dataset.raw);
            return Number.isFinite(value) ? value : null;
        }

        const input = row.querySelector('[data-input-col="' + key + '"]');

        if (!input || input.value.trim() === '') {
            return null;
        }

        const value = Number(input.value);
        return Number.isFinite(value) ? value : null;
    };

    const setResult = (row, key, value) => {
        const target = row.querySelector('[data-result-col="' + key + '"]');

        if (target) {
            target.textContent =
                value === null || !Number.isFinite(value)
                    ? '—'
                    : numberFormat.format(value);
        }
    };

    const calculateRow = (row, kind) => {
        if (kind === 'ad620') {
            const resistor = readNumber(row, 'rg');
            const inputOne = readNumber(row, 'vin1');
            const inputTwo = readNumber(row, 'vin2');
            const measured = readNumber(row, 'vout_measured');
            const gain =
                resistor !== null && resistor > 0
                    ? 1 + 49400 / resistor
                    : null;
            const difference =
                inputOne !== null && inputTwo !== null
                    ? inputOne - inputTwo
                    : null;

            setResult(row, 'gain_calc', gain);
            setResult(row, 'vin_diff', difference);
            setResult(
                row,
                'vout_calc',
                difference !== null && gain !== null
                    ? difference * gain
                    : null,
            );
            setResult(
                row,
                'gain_measured',
                difference !== null &&
                    difference !== 0 &&
                    measured !== null
                    ? measured / difference
                    : null,
            );
        }

        if (kind === 'lpf') {
            const vin = readNumber(row, 'vin');
            const vout = readNumber(row, 'vout');
            const ratio =
                vin !== null && vin > 0 && vout !== null && vout >= 0
                    ? vout / vin
                    : null;

            setResult(row, 'ratio', ratio);
            setResult(
                row,
                'gain_db',
                ratio !== null && ratio > 0 ? 20 * Math.log10(ratio) : null,
            );
        }
    };

    const exportFile = (name, content, mime) => {
        const blob = new Blob([content], { type: mime });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');

        link.href = url;
        link.download = name;
        document.body.append(link);
        link.click();
        link.remove();
        URL.revokeObjectURL(url);
    };

    const csvCell = (value) => {
        const safe = String(value ?? '')
            .replace(/^[=+@-](?=[^\d])/u, "'$&")
            .replace(/"/g, '""');
        return '"' + safe + '"';
    };

    document.querySelectorAll('[data-observation-table]').forEach((table) => {
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        const kind = table.dataset.tableKind;

        const update = () => {
            rows.forEach((row) => calculateRow(row, kind));
        };

        table.querySelectorAll('input').forEach((input) => {
            input.addEventListener('input', update);
        });

        table.querySelector('[data-export-table]').addEventListener(
            'click',
            () => {
                const headers = Array.from(table.querySelectorAll('thead th'));
                const lines = [
                    headers.map((header) => csvCell(header.textContent)).join(';'),
                ];

                rows.forEach((row) => {
                    const cells = Array.from(row.querySelectorAll('td'));
                    const values = cells.map((cell) => {
                        const input = cell.querySelector('input');

                        if (input) {
                            return csvCell(input.value);
                        }

                        return csvCell(
                            cell.dataset.raw ??
                                cell.querySelector('[data-result-col]')
                                    ?.textContent ??
                                '',
                        );
                    });

                    lines.push(values.join(';'));
                });

                exportFile(
                    table.dataset.exportName + '.csv',
                    '\uFEFF' + lines.join('\r\n'),
                    'text/csv;charset=utf-8',
                );
                table.querySelector('[data-table-status]').textContent =
                    'CSV telah dibuat. Pastikan file tersimpan sebelum meninggalkan halaman.';
            },
        );

        table.querySelector('[data-reset-table]').addEventListener(
            'click',
            () => {
                if (!window.confirm('Hapus seluruh isian tabel ini?')) {
                    return;
                }

                table.querySelectorAll('input').forEach((input) => {
                    input.value = '';
                });
                update();
                table.querySelector('[data-table-status]').textContent =
                    'Isian tabel telah dikosongkan.';
            },
        );

        update();
    });

    document.querySelectorAll('[data-discussion]').forEach((discussion) => {
        discussion
            .querySelector('[data-export-discussion]')
            .addEventListener('click', () => {
                const lines = ['Diskusi: ' + discussion.dataset.discussionTitle];

                discussion
                    .querySelectorAll('.jobsheet-discussion-item')
                    .forEach((item, index) => {
                        const question = item.querySelector('label').textContent;
                        const answer = item.querySelector('textarea').value;

                        lines.push(
                            '',
                            'Pertanyaan ' + (index + 1) + ': ' + question,
                            'Jawaban: ' + (answer || '(belum diisi)'),
                        );
                    });

                exportFile(
                    'jawaban-diskusi-jobsheet.txt',
                    lines.join('\n'),
                    'text/plain;charset=utf-8',
                );
            });
    });
})();
