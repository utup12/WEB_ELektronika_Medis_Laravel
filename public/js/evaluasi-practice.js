(() => {
    const dataElement = document.getElementById('jobsheet-practice-data');
    const selectElement = document.getElementById('practice-module-select');
    const container = document.getElementById('practice-quiz-container');
    const titleElement = document.getElementById('practice-module-title');
    const groupElement = document.getElementById('practice-module-group');
    const metaElement = document.getElementById('practice-module-meta');
    const form = document.getElementById('practice-quiz-form');
    const resultBox = document.getElementById('practice-quiz-result');
    const resetButton = document.getElementById('practice-reset-btn');
    const nextButton = document.getElementById('practice-next-btn');

    if (
        !dataElement ||
        !selectElement ||
        !container ||
        !form ||
        !resultBox
    ) {
        return;
    }

    let modules = [];
    try {
        modules = JSON.parse(dataElement.textContent || '[]');
    } catch {
        modules = [];
    }

    if (!Array.isArray(modules) || modules.length === 0) {
        container.innerHTML =
            '<p class="notice error">Bank soal latihan belum tersedia.</p>';
        return;
    }

    let currentIndex = 0;

    const escapeHtml = (value) =>
        String(value)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#39;');

    const renderModule = (index) => {
        currentIndex = (index + modules.length) % modules.length;
        const mod = modules[currentIndex];
        selectElement.value = mod.slug;

        if (titleElement) {
            titleElement.textContent = `Jobsheet ${mod.number}: ${mod.title}`;
        }
        if (groupElement) {
            groupElement.textContent = `${mod.group} · 10 Soal Pilihan Ganda`;
        }
        if (metaElement) {
            metaElement.textContent =
                'Latihan mandiri — skor langsung muncul setelah selesai dan tidak masuk nilai resmi.';
        }

        const questionsHtml = mod.questions
            .map((item, qIdx) => {
                const optionsHtml = ['a', 'b', 'c', 'd']
                    .map((key) => {
                        const label = key.toUpperCase();
                        return `<label class="practice-option" data-option="${key}">
                            <input type="radio" name="q_${item.id}" value="${key}">
                            <span><strong>${label}.</strong> ${escapeHtml(item.options[key] || '')}</span>
                        </label>`;
                    })
                    .join('');

                return `<fieldset class="practice-question" data-question-id="${item.id}">
                    <legend>${qIdx + 1}. ${escapeHtml(item.question)}</legend>
                    <div class="practice-options">${optionsHtml}</div>
                    <div class="practice-feedback" data-feedback-for="${item.id}" hidden></div>
                </fieldset>`;
            })
            .join('');

        container.innerHTML = questionsHtml;
        resultBox.hidden = true;
        resultBox.innerHTML = '';

        if (nextButton) {
            const nextMod = modules[(currentIndex + 1) % modules.length];
            nextButton.textContent = `Lanjut ke Jobsheet ${nextMod.number}: ${nextMod.title} →`;
        }
    };

    selectElement.addEventListener('change', () => {
        const idx = modules.findIndex((m) => m.slug === selectElement.value);
        if (idx >= 0) {
            renderModule(idx);
        }
    });

    if (resetButton) {
        resetButton.addEventListener('click', () => {
            renderModule(currentIndex);
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', () => {
            renderModule((currentIndex + 1) % modules.length);
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const mod = modules[currentIndex];
        const total = mod.questions.length;
        const unanswered = [];
        let correctCount = 0;

        for (const item of mod.questions) {
            const selected = form.querySelector(
                `input[name="q_${item.id}"]:checked`,
            );
            if (!selected) {
                unanswered.push(item.id);
            }
        }

        if (unanswered.length > 0) {
            resultBox.hidden = false;
            resultBox.className = 'practice-result notice error';
            resultBox.innerHTML = `<strong>Masih ada ${unanswered.length} soal belum dijawab:</strong> nomor ${unanswered.join(', ')}. Lengkapi seluruh 10 soal untuk melihat skor latihan.`;
            resultBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            return;
        }

        for (const item of mod.questions) {
            const fieldset = form.querySelector(
                `fieldset[data-question-id="${item.id}"]`,
            );
            const selected = form.querySelector(
                `input[name="q_${item.id}"]:checked`,
            );
            const chosen = selected ? selected.value : '';
            const isCorrect = chosen === item.answer;

            if (isCorrect) {
                correctCount += 1;
            }

            if (fieldset) {
                fieldset.classList.remove('is-correct', 'is-wrong');
                fieldset.classList.add(isCorrect ? 'is-correct' : 'is-wrong');
            }

            const feedbackEl = form.querySelector(
                `[data-feedback-for="${item.id}"]`,
            );
            if (feedbackEl) {
                const answerLabel = item.answer.toUpperCase();
                const answerText = item.options[item.answer] || '';
                feedbackEl.hidden = false;
                feedbackEl.className = `practice-feedback ${isCorrect ? 'ok' : 'bad'}`;
                feedbackEl.innerHTML = isCorrect
                    ? `<strong>✓ Benar (${answerLabel}).</strong> ${escapeHtml(item.explanation)}`
                    : `<strong>✕ Kurang tepat.</strong> Jawaban benar: <strong>${answerLabel}. ${escapeHtml(answerText)}</strong> — ${escapeHtml(item.explanation)}`;
            }
        }

        const percent = Math.round((correctCount / total) * 100);
        const message =
            percent >= 80
                ? 'Pemahaman konsep sangat baik!'
                : percent >= 60
                  ? 'Cukup baik, pelajari kembali pembahasan soal yang masih keliru.'
                  : 'Perlu meninjau ulang rangkuman teori dan rumus pada jobsheet terkait.';

        resultBox.hidden = false;
        resultBox.className = 'practice-result is-ready';
        resultBox.innerHTML = `<div class="practice-score-row">
            <div>
                <span class="practice-score-label">Skor Latihan · ${escapeHtml(mod.title)}</span>
                <strong class="practice-score-value">${correctCount} / ${total} (${percent}%)</strong>
            </div>
            <p class="practice-score-note">${escapeHtml(message)} <em>Catatan: ini hanya untuk latihan mandiri dan tidak masuk nilai resmi.</em></p>
        </div>`;
        resultBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });

    const initialSlug = new URLSearchParams(window.location.search).get(
        'jobsheet',
    );
    const initialIdx = initialSlug
        ? modules.findIndex((m) => m.slug === initialSlug)
        : 0;
    renderModule(initialIdx >= 0 ? initialIdx : 0);
})();
