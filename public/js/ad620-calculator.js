(() => {
    const root = document.querySelector('[data-ad620-calculator]');

    if (!root) {
        return;
    }

    const mode = root.querySelector('[name="ad620-mode"]');
    const value = root.querySelector('[name="ad620-value"]');
    const unit = root.querySelector('[name="ad620-unit"]');
    const inputLabel = root.querySelector('[data-input-label]');
    const output = root.querySelector('[data-calculator-output]');
    const explanation = root.querySelector('[data-calculator-explanation]');
    const formatter = new Intl.NumberFormat('id-ID', {
        maximumFractionDigits: 2,
    });

    const render = () => {
        const gainToResistor = mode.value === 'gain-to-resistor';

        inputLabel.textContent = gainToResistor
            ? 'Penguatan G (kali)'
            : 'Resistor RG';
        unit.hidden = gainToResistor;
        value.min = gainToResistor ? '1.01' : '0.01';
        value.max = '10000';

        const input = Number(value.value);
        const minimum = gainToResistor ? 1 : 0;

        if (
            value.value.trim() === '' ||
            !Number.isFinite(input) ||
            input <= minimum ||
            input > 10000
        ) {
            output.textContent = 'Masukkan nilai yang valid';
            explanation.textContent = gainToResistor
                ? 'Penguatan harus lebih besar dari 1 dan maksimal 10.000.'
                : 'RG harus lebih besar dari 0 dan maksimal 10.000 pada satuan yang dipilih.';
            return;
        }

        if (gainToResistor) {
            const resistor = 49400 / (input - 1);
            output.textContent = formatter.format(resistor) + ' Ω';
            explanation.textContent =
                'RG = 49.400 Ω / (' +
                formatter.format(input) +
                ' − 1). Nilai teoritis, bukan hasil pengukuran.';
        } else {
            const ohms = input * (unit.value === 'kohm' ? 1000 : 1);
            const gain = 1 + 49400 / ohms;
            output.textContent = formatter.format(gain) + ' kali';
            explanation.textContent =
                'G = 1 + 49.400 Ω / ' +
                formatter.format(ohms) +
                ' Ω. Nilai teoritis, bukan hasil pengukuran.';
        }
    };

    mode.addEventListener('change', () => {
        value.value = mode.value === 'gain-to-resistor' ? '100' : '1';
        render();
    });
    value.addEventListener('input', render);
    unit.addEventListener('change', render);
    render();
})();
