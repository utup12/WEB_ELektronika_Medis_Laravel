(() => {
    const formatter = new Intl.NumberFormat('id-ID', {
        maximumFractionDigits: 4,
    });

    const readNumber = (row, key) => {
        const cell = row.querySelector('[data-col="' + key + '"]');

        if (!cell) {
            return null;
        }

        const input = cell.querySelector('input');
        const raw = input ? input.value : cell.dataset.raw;

        if (raw === undefined || raw === '') {
            return null;
        }

        const number = Number(raw);
        return Number.isFinite(number) ? number : null;
    };

    const showResult = (row, key, number) => {
        const cell = row.querySelector('[data-result-col="' + key + '"]');

        if (!cell) {
            return;
        }

        cell.textContent =
            number === null || !Number.isFinite(number)
                ? '—'
                : formatter.format(number);
    };

    const calculateRow = (row, kind) => {
        if (kind === 'ad620') {
            const resistance = readNumber(row, 'rg');
            const vin1 = readNumber(row, 'vin1');
            const vin2 = readNumber(row, 'vin2');
            const measured = readNumber(row, 'vout_measured');
            const gain = resistance > 0 ? 1 + 49400 / resistance : null;
            const delta = vin1 !== null && vin2 !== null ? vin1 - vin2 : null;
            const predicted = gain !== null && delta !== null
                ? gain * delta
                : null;
            const observed = delta !== null && delta !== 0 &&
                measured !== null ? measured / delta : null;

            showResult(row, 'gain_calc', gain);
            showResult(row, 'vin_diff', delta);
            showResult(row, 'vout_calc', predicted);
            showResult(row, 'gain_measured', observed);
        }

        if (kind === 'lpf') {
            const vin = readNumber(row, 'vin');
            const vout = readNumber(row, 'vout');
            const ratio = vin !== null && vin > 0 &&
                vout !== null && vout >= 0 ? vout / vin : null;
            const decibels = ratio !== null && ratio > 0
                ? 20 * Math.log10(ratio)
                : null;

            showResult(row, 'ratio', ratio);
            showResult(row, 'gain_db', decibels);
        }
    };

    const download = (filename, content, type) => {
        const blob = new Blob([content], { type });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');

        link.href = url;
        link.download = filename;
        document.body.append(link);
        link.click();
        link.remove();
        URL.revokeObjectURL(url);
    };

    const csv = (text) => {
        let value = String(text ?? '');

        if (/^[=+@]/u.test(value) || /^-(?!\d)/u.test(value)) {
            value = "'" + value;
        }

        return '"' + value.replace(/"/g, '""') + '"';
    };

    document.querySelectorAll('[data-observation-table]').forEach((table) => {
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        const update = () => {
            rows.forEach((row) => {
                calculateRow(row, table.dataset.tableKind);
            });
        };

        table.querySelectorAll('input').forEach((input) => {
            input.addEventListener('input', update);
        });

        table.querySelector('[data-export-table]').addEventListener(
            'click',
            () => {
                const headings = Array.from(table.querySelectorAll('thead th'));
                const lines = [
                    headings.map((heading) => csv(heading.textContent)).join(';'),
                ];

                rows.forEach((row) => {
                    const cells = Array.from(row.querySelectorAll('td'));
                    const data = cells.map((cell) => {
                        const input = cell.querySelector('input');
                        const raw = cell.dataset.raw;
                        const value = input ? input.value :
                            raw || cell.textContent.trim();

                        return csv(value);
                    });

                    lines.push(data.join(';'));
                });

                download(
                    table.dataset.exportName + '.csv',
                    '\uFEFF' + lines.join('\r\n'),
                    'text/csv;charset=utf-8',
                );
                table.querySelector('[data-table-status]').textContent =
                    'CSV telah dibuat. Simpan file sebelum menutup halaman.';
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
                    'Seluruh isian tabel telah dikosongkan.';
            },
        );

        update();
    });

    document.querySelectorAll('[data-discussion]').forEach((discussion) => {
        discussion
            .querySelector('[data-export-discussion]')
            .addEventListener('click', () => {
                const title = discussion.dataset.discussionTitle;
                const lines = ['Diskusi: ' + title];

                discussion
                    .querySelectorAll('.jobsheet-discussion-item')
                    .forEach((item, index) => {
                        const label = item.querySelector('label');
                        const answer = item.querySelector('textarea').value;

                        lines.push(
                            '',
                            'Pertanyaan ' + (index + 1) + ': ' +
                                label.textContent,
                            'Jawaban: ' + (answer || '(belum diisi)'),
                        );
                    });

                download(
                    'jawaban-diskusi-jobsheet.txt',
                    lines.join('\n'),
                    'text/plain;charset=utf-8',
                );
            });
    });
})();
