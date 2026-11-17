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
  const penBtn = document.querySelector('[data-note-pen]');
  const eraserBtn = document.querySelector('[data-note-eraser]');
  const textBtn = document.querySelector('[data-note-text]');
  const undoBtn = document.querySelector('[data-note-undo]');
  const redoBtn = document.querySelector('[data-note-redo]');
  const history = Array.from({ length: 10 }, () => []);
  const redoHistory = Array.from({ length: 10 }, () => []);
  let page = 0;
  let drawing = false;
  let tool = 'pen';
  let activeEditor = null;
  let data = JSON.parse(localStorage.getItem(key) || '{}');
  ctx.lineCap = 'round';
  ctx.lineJoin = 'round';

  const save = () => {
    data[page] = canvas.toDataURL();
    localStorage.setItem(key, JSON.stringify(data));
  };

  const snapshot = () => {
    history[page].push(canvas.toDataURL());
    if (history[page].length > 30) history[page].shift();
    redoHistory[page] = [];
  };

  const position = event => {
    const rect = canvas.getBoundingClientRect();
    return {
      x: ((event.clientX - rect.left) * canvas.width) / rect.width,
      y: ((event.clientY - rect.top) * canvas.height) / rect.height,
    };
  };

  const drawImage = source => {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    if (!source) return;
    const image = new Image();
    image.onload = () => ctx.drawImage(image, 0, 0);
    image.src = source;
  };

  const load = (animate = true) => {
    drawImage(data[page]);
    label.textContent = `Halaman ${page + 1} / 10`;
    if (animate) {
      sheet.classList.remove('page-turn');
      void sheet.offsetWidth;
      sheet.classList.add('page-turn');
    }
  };

  const setActiveTool = nextTool => {
    commitActiveEditor();
    tool = nextTool;
    canvas.dataset.tool = nextTool;
    penBtn.classList.toggle('is-active', nextTool === 'pen');
    eraserBtn.classList.toggle('is-active', nextTool === 'eraser');
    textBtn.classList.toggle('is-active', nextTool === 'text');
  };

  const commitActiveEditor = () => {
    if (!activeEditor) return;
    const { el, point } = activeEditor;
    activeEditor = null;
    const raw = el.value.replace(/\r/g, '');
    el.remove();
    if (!raw.trim()) return;

    snapshot();
    ctx.globalCompositeOperation = 'source-over';
    ctx.fillStyle = '#163a5b';
    ctx.font = '600 24px Manrope, Arial, sans-serif';
    ctx.textBaseline = 'top';
    const lineHeight = 35;
    raw.split('\n').forEach((line, idx) => {
      ctx.fillText(line, point.x, point.y + idx * lineHeight);
    });
    save();
    hint.textContent = 'Teks disimpan ke kertas.';
  };

  const openEditorAt = point => {
    commitActiveEditor();
    const editor = document.createElement('textarea');
    editor.className = 'paper-live-editor';
    editor.rows = 1;
    editor.placeholder = 'Ketik di sini...';
    const leftPct = Math.min(82, Math.max(2, (point.x / canvas.width) * 100));
    const topPct = Math.min(88, Math.max(2, (point.y / canvas.height) * 100));
    editor.style.left = `${leftPct}%`;
    editor.style.top = `${topPct}%`;

    const autoResize = () => {
      editor.style.height = 'auto';
      editor.style.height = `${Math.max(36, editor.scrollHeight)}px`;
    };

    editor.addEventListener('input', autoResize);
    editor.addEventListener('keydown', e => {
      if (e.key === 'Escape') {
        e.preventDefault();
        editor.blur();
      }
    });
    editor.addEventListener('blur', () => {
      setTimeout(() => commitActiveEditor(), 0);
    });

    sheet.appendChild(editor);
    activeEditor = { el: editor, point };
    requestAnimationFrame(() => {
      editor.focus();
      autoResize();
    });
    hint.textContent = 'Ketik langsung seperti di Word. Klik luar atau tekan Esc untuk menyimpan.';
  };

  canvas.addEventListener('pointerdown', event => {
    const point = position(event);
    if (tool === 'text') {
      event.preventDefault();
      openEditorAt(point);
      return;
    }
    commitActiveEditor();
    snapshot();
    drawing = true;
    canvas.setPointerCapture(event.pointerId);
    ctx.beginPath();
    ctx.moveTo(point.x, point.y);
  });

  canvas.addEventListener('pointermove', event => {
    if (!drawing) return;
    const point = position(event);
    ctx.globalCompositeOperation = tool === 'eraser' ? 'destination-out' : 'source-over';
    ctx.strokeStyle = '#163a5b';
    ctx.lineWidth = tool === 'eraser' ? Number(eraser.value) : Number(pen.value);
    ctx.lineTo(point.x, point.y);
    ctx.stroke();
  });

  const finish = () => {
    if (!drawing) return;
    drawing = false;
    save();
  };
  canvas.addEventListener('pointerup', finish);
  canvas.addEventListener('pointercancel', finish);

  const performUndo = () => {
    commitActiveEditor();
    const previous = history[page].pop();
    if (!previous) {
      hint.textContent = 'Belum ada aksi yang dapat dibatalkan.';
      return;
    }
    redoHistory[page].push(canvas.toDataURL());
    data[page] = previous;
    save();
    drawImage(previous);
    hint.textContent = 'Aksi terakhir dibatalkan (Undo).';
  };

  const performRedo = () => {
    commitActiveEditor();
    const next = redoHistory[page].pop();
    if (!next) {
      hint.textContent = 'Belum ada aksi yang dapat diulangi.';
      return;
    }
    history[page].push(canvas.toDataURL());
    data[page] = next;
    save();
    drawImage(next);
    hint.textContent = 'Aksi diulangi (Redo).';
  };

  penBtn.onclick = () => {
    setActiveTool('pen');
    hint.textContent = `Mode pena aktif (${pen.value}px).`;
  };

  eraserBtn.onclick = () => {
    setActiveTool('eraser');
    hint.textContent = `Mode penghapus aktif (${eraser.value}px).`;
  };

  textBtn.onclick = () => {
    setActiveTool('text');
    openEditorAt({ x: 84, y: 52 });
  };

  undoBtn.onclick = performUndo;
  redoBtn.onclick = performRedo;

  document.addEventListener('keydown', event => {
    if (activeEditor) return;
    if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'z') {
      event.preventDefault();
      if (event.shiftKey) {
        performRedo();
      } else {
        performUndo();
      }
    } else if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'y') {
      event.preventDefault();
      performRedo();
    }
  });

  document.querySelector('[data-note-clear]').onclick = () => {
    commitActiveEditor();
    if (confirm('Hapus seluruh isi halaman ini?')) {
      snapshot();
      delete data[page];
      localStorage.setItem(key, JSON.stringify(data));
      load(false);
    }
  };

  document.querySelector('[data-note-prev]').onclick = () => {
    if (page > 0) {
      commitActiveEditor();
      save();
      page--;
      load();
    }
  };

  document.querySelector('[data-note-next]').onclick = () => {
    if (page < 9) {
      commitActiveEditor();
      save();
      page++;
      load();
    }
  };

  document.querySelector('[data-note-new]').onclick = () => {
    if (page < 9) {
      commitActiveEditor();
      save();
      page++;
      load();
    } else {
      alert('Maksimal 10 halaman catatan.');
    }
  };

  pen.oninput = () => {
    if (tool === 'pen') hint.textContent = `Ketebalan pena: ${pen.value}px.`;
  };
  eraser.oninput = () => {
    if (tool === 'eraser') hint.textContent = `Ketebalan penghapus: ${eraser.value}px.`;
  };

  load(false);
})();
