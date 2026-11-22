(() => {
    const root = document.querySelector('[data-attendance-calendar]');
    if (!root) return;
    document
        .querySelector('.calendar-layout form')
        ?.setAttribute('id', 'attendance-form');
    const title = root.querySelector('[data-cal-title]'),
        grid = root.querySelector('[data-cal-grid]'),
        start = document.querySelector('[data-cal-start]'),
        end = document.querySelector('[data-cal-end]'),
        note = root.querySelector('[data-cal-note]');
    let cursor = new Date();
    cursor.setDate(1);
    const p = (n) => String(n).padStart(2, '0'),
        iso = (d) =>
            `${d.getFullYear()}-${p(d.getMonth() + 1)}-${p(d.getDate())}`;
    const render = () => {
        grid.replaceChildren();
        title.textContent = cursor.toLocaleDateString('id-ID', {
            month: 'long',
            year: 'numeric',
        });
        let offset = cursor.getDay(),
            days = new Date(
                cursor.getFullYear(),
                cursor.getMonth() + 1,
                0,
            ).getDate();
        for (let i = 0; i < offset; i++)
            grid.append(document.createElement('span'));
        for (let d = 1; d <= days; d++) {
            let date = new Date(cursor.getFullYear(), cursor.getMonth(), d),
                b = document.createElement('button');
            b.type = 'button';
            b.textContent = d;
            b.className = 'calendar-day';
            b.onclick = () => {
                document
                    .querySelectorAll('.calendar-day.selected')
                    .forEach((x) => x.classList.remove('selected'));
                b.classList.add('selected');
                start.value = `${iso(date)}T08:00`;
                end.value = `${iso(date)}T10:00`;
                note.textContent = `${d} ${title.textContent} dipilih.`;
            };
            grid.append(b);
        }
    };
    root.querySelector('[data-cal-prev]').onclick = () => {
        cursor.setMonth(cursor.getMonth() - 1);
        render();
    };
    root.querySelector('[data-cal-next]').onclick = () => {
        cursor.setMonth(cursor.getMonth() + 1);
        render();
    };
    render();
})();
