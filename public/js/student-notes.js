(() => {
  const canvas = document.querySelector('[data-note-canvas]');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  const key = 'pem-paper-notes-v2';
  const label = document.querySelector('[data-note-label]');
  const hint = document.querySelector('[data-note-hint]');
  const sheet = document.querySelector('.paper-sheet');
  const pen = document.querySelector('[data-pen-size]');
  const eraser = document.querySelector('[data-eraser-size]');
  const textValue = document.querySelector('[data-note-text-value]');
  const history = Array.from({ length: 10 }, () => []);
  let page = 0, drawing = false, tool = 'pen';
  let data = JSON.parse(localStorage.getItem(key) || '{}');
  ctx.lineCap = 'round';
  ctx.lineJoin = 'round';

  const save = () => { data[page] = canvas.toDataURL(); localStorage.setItem(key, JSON.stringify(data)); };
  const snapshot = () => { history[page].push(canvas.toDataURL()); if (history[page].length > 25) history[page].shift(); };
  const position = event => { const rect = canvas.getBoundingClientRect(); return { x:(event.clientX - rect.left) * canvas.width / rect.width, y:(event.clientY - rect.top) * canvas.height / rect.height }; };
  const drawImage = source => { ctx.clearRect(0, 0, canvas.width, canvas.height); if (!source) return; const image = new Image(); image.onload = () => ctx.drawImage(image, 0, 0); image.src = source; };
  const load = (animate = true) => { drawImage(data[page]); label.textContent = `Halaman ${page + 1} / 10`; if (animate) { sheet.classList.remove('page-turn'); void sheet.offsetWidth; sheet.classList.add('page-turn'); } };

  canvas.addEventListener('pointerdown', event => {
    const point = position(event);
    if (tool === 'text') {
      const value = textValue.value.trim();
      if (!value) { hint.textContent = 'Ketik teks pada kolom di atas terlebih dahulu.'; textValue.focus(); return; }
      snapshot();
      ctx.globalCompositeOperation = 'source-over';
      ctx.fillStyle = '#163a5b';
      ctx.font = '600 28px Arial, sans-serif';
      ctx.fillText(value, point.x, point.y);
      textValue.value = '';
      save();
      hint.textContent = 'Teks ditambahkan. Klik kembali untuk menambah teks lain.';
      return;
    }
    snapshot(); drawing = true; canvas.setPointerCapture(event.pointerId); ctx.beginPath(); ctx.moveTo(point.x, point.y);
  });
  canvas.addEventListener('pointermove', event => {
    if (!drawing) return;
    const point = position(event);
    ctx.globalCompositeOperation = tool === 'eraser' ? 'destination-out' : 'source-over';
    ctx.strokeStyle = '#163a5b';
    ctx.lineWidth = tool === 'eraser' ? Number(eraser.value) : Number(pen.value);
    ctx.lineTo(point.x, point.y); ctx.stroke();
  });
  const finish = () => { if (!drawing) return; drawing = false; save(); };
  canvas.addEventListener('pointerup', finish); canvas.addEventListener('pointercancel', finish);

  document.querySelector('[data-note-pen]').onclick = () => { tool = 'pen'; hint.textContent = `Mode pena aktif (${pen.value}px).`; };
  document.querySelector('[data-note-eraser]').onclick = () => { tool = 'eraser'; hint.textContent = `Mode penghapus aktif (${eraser.value}px).`; };
  document.querySelector('[data-note-text]').onclick = () => { tool = 'text'; hint.textContent = 'Mode teks aktif: ketik teks di kolom, lalu klik kertas.'; textValue.focus(); };
  document.querySelector('[data-note-undo]').onclick = () => { const previous = history[page].pop(); if (!previous) { hint.textContent = 'Belum ada aksi yang dapat dibatalkan.'; return; } data[page] = previous; save(); drawImage(previous); hint.textContent = 'Aksi terakhir dibatalkan.'; };
  document.querySelector('[data-note-clear]').onclick = () => { if (confirm('Hapus seluruh isi halaman ini?')) { snapshot(); delete data[page]; localStorage.setItem(key, JSON.stringify(data)); load(false); } };
  document.querySelector('[data-note-prev]').onclick = () => { if (page > 0) { save(); page--; load(); } };
  document.querySelector('[data-note-next]').onclick = () => { if (page < 9) { save(); page++; load(); } };
  document.querySelector('[data-note-new]').onclick = () => { if (page < 9) { save(); page++; load(); } else alert('Maksimal 10 halaman catatan.'); };
  pen.oninput = () => { if (tool === 'pen') hint.textContent = `Ketebalan pena: ${pen.value}px.`; };
  eraser.oninput = () => { if (tool === 'eraser') hint.textContent = `Ketebalan penghapus: ${eraser.value}px.`; };
  load(false);
})();
