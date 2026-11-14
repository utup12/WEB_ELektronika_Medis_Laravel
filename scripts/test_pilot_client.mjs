import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { runInNewContext } from 'node:vm';

const template = readFileSync(new URL('../resources/views/pilot-heart-rate.blade.php', import.meta.url), 'utf8');
const inline = template.match(/<script>\s*([\s\S]*?)<\/script>/i)?.[1];
assert.ok(inline, 'Pilot inline JavaScript is present');

const elements = new Map();
const stored = new Map();
let exportedText = '';
let downloaded = false;

function element(id) {
    if (!elements.has(id)) {
        elements.set(id, {
            id,
            value: '',
            maxLength: -1,
            textContent: '',
            handlers: {},
            addEventListener(event, callback) {
                this.handlers[event] = callback;
            },
            trigger(event, payload = {}) {
                return this.handlers[event]?.({
                    preventDefault() {},
                    currentTarget: this,
                    ...payload,
                });
            },
            reset() {
                for (const [key, item] of elements) {
                    if (key.startsWith('pilot-') && key !== 'pilot-prelab-result') item.value = '';
                }
            },
        });
    }
    return elements.get(id);
}

const document = {
    getElementById: element,
    createElement: () => ({
        href: '',
        download: '',
        click() {
            downloaded = true;
        },
    }),
};
const storage = {
    getItem: (key) => stored.get(key) ?? null,
    setItem: (key, value) => stored.set(key, value),
    removeItem: (key) => stored.delete(key),
};
const mockURL = {
    createObjectURL(blob) {
        exportedText = blob.parts.join('');
        return 'blob:test';
    },
    revokeObjectURL() {},
};
class Blob {
    constructor(parts) {
        this.parts = parts;
    }
}
class FormData {
    constructor(form) {
        this.answers = form.answers ?? {};
    }
    get(name) {
        return this.answers[name] ?? null;
    }
}
runInNewContext(inline, {
    document,
    localStorage: storage,
    FormData,
    Blob,
    URL: mockURL,
    confirm: () => true,
    setTimeout: (fn) => fn(),
}, { timeout: 3000 });

const quiz = element('pilot-prelab');
quiz.answers = { source: 'simulation', bpm: '60', artifact: 'distort' };
quiz.trigger('submit');
assert.match(element('pilot-prelab-result').textContent, /Skor latihan: 3\/3/);

quiz.answers = { source: 'sensor', bpm: '120', artifact: 'distort' };
quiz.trigger('submit');
assert.match(element('pilot-prelab-result').textContent, /Skor latihan: 1\/3/);
assert.match(element('pilot-prelab-result').textContent, /Soal 1/);
assert.match(element('pilot-prelab-result').textContent, /Soal 2/);
quiz.trigger('reset');
assert.equal(element('pilot-prelab-result').textContent, '');

element('pilot-mode').value = 'Simulasi';
element('pilot-source-1').value = 'Simulasi';
element('pilot-bpm-1').value = '75';
element('pilot-note-1').value = 'Pengamatan uji mock tanpa sensor';
element('pilot-observation').value = 'Simulasi untuk latihan';
element('pilot-reflection-form').trigger('input');
assert.match(element('pilot-status').textContent, /belum disimpan/);

element('pilot-save').trigger('click');
const draft = JSON.parse(stored.get('pilot-heart-rate-reflection-v1'));
assert.equal(draft['pilot-bpm-1'], '75');
assert.equal(draft['pilot-source-1'], 'Simulasi');
assert.match(element('pilot-status').textContent, /tersimpan/);

element('pilot-export').trigger('click');
assert.ok(downloaded, 'TXT download was triggered');
assert.match(exportedText, /Nilai BPM pengamatan 1:/);
assert.match(exportedText, /75/);
assert.match(exportedText, /Pengamatan uji mock tanpa sensor/);

element('pilot-clear').trigger('click');
assert.equal(stored.size, 0);
assert.equal(element('pilot-bpm-1').value, '');
assert.match(element('pilot-status').textContent, /dibersihkan/);
console.log('PASS: pilot inline JS mock pre-lab, feedback, draft, export and clear');
