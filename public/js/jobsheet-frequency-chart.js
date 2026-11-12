(() => {
    const ns = 'http://www.w3.org/2000/svg';
    const format = new Intl.NumberFormat('id-ID', {
        maximumFractionDigits: 2,
    });

    const make = (tag, attributes, text) => {
        const element = document.createElementNS(ns, tag);

        Object.entries(attributes).forEach(([key, value]) => {
            element.setAttribute(key, String(value));
        });

        if (text !== undefined) {
            element.textContent = text;
        }

        return element;
    };

    document.querySelectorAll('[data-frequency-chart]').forEach((panel) => {
        const tableId = panel.dataset.frequencyTable;
        const table = document.querySelector(
            '[data-observation-table][data-table-id="' + tableId + '"]',
        );

        if (!table) {
            return;
        }

        const svg = panel.querySelector('svg');
        const status = panel.querySelector('[data-frequency-status]');
        const save = panel.querySelector('[data-save-chart]');
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        const bounds = { left: 70, top: 25, right: 930, bottom: 315 };
        const tickFrequencies = [100, 200, 500, 1000, 2000, 5000, 10000];
        const tickDecibels = [-40, -30, -20, -10, 0, 10, 20];

        const valueOf = (row, key) => {
            const cell = row.querySelector('[data-col="' + key + '"]');

            if (!cell) {
                return null;
            }

            const input = cell.querySelector('input');
            const raw = input ? input.value.trim() : cell.dataset.raw;

            if (raw === undefined || raw === '') {
                return null;
            }

            const number = Number(raw);
            return Number.isFinite(number) ? number : null;
        };

        const points = () => {
            return rows.map((row) => {
                const frequency = valueOf(row, 'frequency');
                const vin = valueOf(row, 'vin');
                const vout = valueOf(row, 'vout');
                const measured =
                    vin !== null &&
                    vin > 0 &&
                    vout !== null &&
                    vout > 0
                        ? 20 * Math.log10(vout / vin)
                        : null;

                return {
                    frequency,
                    theory: valueOf(row, 'theoretical_db'),
                    measured,
                };
            });
        };

        const draw = () => {
            const data = points();
            const observations = data.filter(
                (item) => item.measured !== null && item.frequency > 0,
            );
            const values = data.flatMap((item) => {
                return [item.theory, item.measured].filter(
                    (number) => number !== null,
                );
            });
            const minimum = Math.min(-20, ...values) - 5;
            const maximum = Math.max(5, ...values) + 5;
            const lower = Math.floor(minimum / 10) * 10;
            const upper = Math.ceil(maximum / 10) * 10;
            const x = (frequency) => {
                return (
                    bounds.left +
                    ((Math.log10(frequency) - 2) / 2) *
                        (bounds.right - bounds.left)
                );
            };
            const y = (decibels) => {
                return (
                    bounds.bottom -
                    ((decibels - lower) / (upper - lower)) *
                        (bounds.bottom - bounds.top)
                );
            };

            svg.replaceChildren();
            svg.append(
                make(
                    'title',
                    {},
                    'Respons frekuensi: data teoritis jobsheet dibanding hasil pengukuran mahasiswa',
                ),
            );
            svg.append(
                make(
                    'desc',
                    {},
                    'Sumbu frekuensi logaritmik dalam hertz, sumbu penguatan dalam desibel. Kurva eksperimen muncul hanya ketika Vin dan Vout terisi dengan nilai positif.',
                ),
            );
            svg.append(
                make('rect', {
                    x: 0,
                    y: 0,
                    width: 960,
                    height: 360,
                    fill: '#ffffff',
                }),
            );

            for (let db = lower; db <= upper; db += 10) {
                const position = y(db);
                svg.append(
                    make('line', {
                        x1: bounds.left,
                        x2: bounds.right,
                        y1: position,
                        y2: position,
                        stroke: '#dce6ef',
                    }),
                );
                svg.append(
                    make(
                        'text',
                        {
                            x: bounds.left - 10,
                            y: position + 4,
                            'text-anchor': 'end',
                            fill: '#4b6178',
                            'font-size': 13,
                        },
                        String(db),
                    ),
                );
            }

            tickFrequencies.forEach((frequency) => {
                const position = x(frequency);
                svg.append(
                    make('line', {
                        x1: position,
                        x2: position,
                        y1: bounds.top,
                        y2: bounds.bottom,
                        stroke: '#e8eef5',
                    }),
                );
                svg.append(
                    make(
                        'text',
                        {
                            x: position,
                            y: bounds.bottom + 24,
                            'text-anchor': 'middle',
                            fill: '#4b6178',
                            'font-size': 13,
                        },
                        format.format(frequency),
                    ),
                );
            });

            const theories = data.filter(
                (item) => item.frequency > 0 && item.theory !== null,
            );

            if (theories.length > 1) {
                svg.append(
                    make('polyline', {
                        points: theories
                            .map((item) => {
                                return (
                                    x(item.frequency) + ',' + y(item.theory)
                                );
                            })
                            .join(' '),
                        fill: 'none',
                        stroke: '#2361a0',
                        'stroke-width': 3,
                        'stroke-linejoin': 'round',
                    }),
                );
            }

            theories.forEach((item) => {
                svg.append(
                    make('circle', {
                        cx: x(item.frequency),
                        cy: y(item.theory),
                        r: 3.5,
                        fill: '#2361a0',
                    }),
                );
            });

            // Do not invent intermediate measurements across empty table rows.
            for (let index = 1; index < data.length; index += 1) {
                const previous = data[index - 1];
                const current = data[index];

                if (previous.measured !== null && current.measured !== null) {
                    svg.append(
                        make('line', {
                            x1: x(previous.frequency),
                            y1: y(previous.measured),
                            x2: x(current.frequency),
                            y2: y(current.measured),
                            stroke: '#c15b2d',
                            'stroke-width': 2.5,
                        }),
                    );
                }
            }

            observations.forEach((item) => {
                svg.append(
                    make('circle', {
                        cx: x(item.frequency),
                        cy: y(item.measured),
                        r: 4.5,
                        fill: '#c15b2d',
                    }),
                );
            });

            svg.append(
                make(
                    'text',
                    {
                        x: 500,
                        y: 355,
                        'text-anchor': 'middle',
                        'font-size': 14,
                        fill: '#2b4158',
                    },
                    'Frekuensi (Hz) · skala logaritmik',
                ),
            );
            svg.append(
                make(
                    'text',
                    {
                        transform: 'translate(20 185) rotate(-90)',
                        'text-anchor': 'middle',
                        'font-size': 14,
                        fill: '#2b4158',
                    },
                    'Penguatan (dB)',
                ),
            );

            const theoryText =
                theories.length > 0
                    ? 'Garis biru: nilai teoritis sesuai tabel sumber. '
                    : 'Tabel sumber tidak memuat kurva dB teoritis. ';
            status.textContent =
                theoryText +
                'Titik jingga: ' +
                observations.length +
                ' dari ' +
                data.length +
                ' pengukuran lengkap. Data kosong tidak diimputasi.';
        };

        table.addEventListener('input', draw);
        table
            .querySelector('[data-reset-table]')
            .addEventListener('click', () => {
                // The table controller clears inputs synchronously on click.
                queueMicrotask(draw);
            });
        save.addEventListener('click', () => {
            const image = svg.cloneNode(true);
            image.setAttribute('xmlns', ns);
            const source = new XMLSerializer().serializeToString(image);
            const blob = new Blob([source], {
                type: 'image/svg+xml;charset=utf-8',
            });
            const url = URL.createObjectURL(blob);
            const anchor = document.createElement('a');

            anchor.href = url;
            anchor.download = tableId + '-respons-frekuensi.svg';
            document.body.append(anchor);
            anchor.click();
            anchor.remove();
            URL.revokeObjectURL(url);
        });
        draw();
    });
})();
