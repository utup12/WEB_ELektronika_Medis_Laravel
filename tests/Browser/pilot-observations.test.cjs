const { test } = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const path = require('node:path');

const html = fs.readFileSync(
    path.join(__dirname, '../../resources/views/pilot-heart-rate.blade.php'),
    'utf8',
);
const script = html.match(/<script>\s*([\s\S]*?)<\/script>/)[1];

function setup(storage = new Map()) {
    const elements = new Map();
    const element = (id) => {
        if (!elements.has(id))
            elements.set(id, {
                value: '',
                disabled: false,
                textContent: '',
                handlers: {},
                cells: [],
                addEventListener(type, fn) {
                    this.handlers[type] = fn;
                },
                replaceChildren() {
                    this.cells = [];
                },
                insertRow() {
                    const row = {
                        cells: [],
                        insertCell() {
                            const cell = {};
                            this.cells.push(cell);
                            return cell;
                        },
                    };
                    this.cells.push(row);
                    return row;
                },
                reportValidity() {
                    return true;
                },
                reset() {
                    for (const item of elements.values()) item.value = '';
                },
            });
        return elements.get(id);
    };
    const context = {
        document: { getElementById: element },
        localStorage: {
            getItem: (key) => storage.get(key) ?? null,
            setItem: (key, value) => storage.set(key, value),
            removeItem: (key) => storage.delete(key),
        },
        window: { confirm: () => true },
        Date,
        JSON,
    };
    vm.runInNewContext(script, context);
    const click = (id) => element(id).handlers.click();
    const submit = (
        condition = 'Istirahat',
        source = 'Simulasi',
        bpm = '72',
    ) => {
        for (const [id, value] of Object.entries({
            time: '2026-11-14T12:00',
            source,
            bpm,
            condition,
            notes: '',
            reflection: '',
        }))
            element('pilot-' + id).value = value;
        element('pilot-observation-form').handlers.submit({
            preventDefault() {},
        });
    };
    return { element, click, submit, storage, context };
}

void test('saved observations survive reload and retain simulated/physical provenance', () => {
    const first = setup();
    first.submit();
    first.submit('Sensor fisik uji', 'Sensor fisik', '81');
    first.click('pilot-save');
    const next = setup(first.storage);
    next.click('pilot-load');
    const rows = next.element('pilot-observations').cells;
    assert.equal(rows.length, 2);
    assert.equal(rows[0].cells[1].textContent, 'Simulasi');
    assert.equal(rows[1].cells[1].textContent, 'Sensor fisik');
    assert.equal(rows[1].cells[2].textContent, '81');
});

void test('invalid entries and corrupt drafts do not replace existing observations', () => {
    const app = setup();
    app.submit('   ');
    app.submit('Valid', 'Other');
    app.submit('Valid', 'Simulasi', '301');
    app.submit('Valid', 'Simulasi', '72.5');
    app.submit('Valid');
    assert.equal(app.element('pilot-observations').cells.length, 1);
    for (const raw of [
        '{bad',
        'null',
        '{"version":1,"rows":[["bad"]]}',
        '{"version":2,"rows":[]}',
    ]) {
        app.storage.set('pem-pilot-ppg:v1', raw);
        app.click('pilot-load');
        assert.equal(
            app.element('pilot-observations').cells[0].cells[3].textContent,
            'Valid',
        );
        assert.match(app.element('pilot-feedback').textContent, /tetap utuh/);
    }
});

void test('clear table and delete saved draft are independent', () => {
    const app = setup();
    app.submit();
    app.click('pilot-save');
    app.click('pilot-clear');
    assert.equal(app.element('pilot-download').disabled, true);
    assert.equal(app.storage.has('pem-pilot-ppg:v1'), true);
    app.click('pilot-load');
    app.click('pilot-delete-draft');
    assert.equal(app.storage.has('pem-pilot-ppg:v1'), false);
    assert.equal(
        app.element('pilot-observations').cells[0].cells[2].textContent,
        '72',
    );
});

void test('storage denial reports failure without losing in-memory data', () => {
    const app = setup();
    app.submit();
    app.context.localStorage.setItem = () => {
        throw new Error('Quota');
    };
    app.click('pilot-save');
    assert.match(app.element('pilot-feedback').textContent, /gagal disimpan/);
    assert.equal(
        app.element('pilot-observations').cells[0].cells[2].textContent,
        '72',
    );
});

void test('cancelled load preserves table and user text is rendered as text', () => {
    const app = setup();
    app.submit('Saved');
    app.click('pilot-save');
    app.click('pilot-clear');
    app.submit('<img src=x onerror=alert(1)>');
    app.context.window.confirm = () => false;
    app.click('pilot-load');
    assert.equal(
        app.element('pilot-observations').cells[0].cells[3].textContent,
        '<img src=x onerror=alert(1)>',
    );
});

void test('CSV exports escape formula prefixes, quotes and line breaks', async () => {
    const app = setup();
    let exported;
    app.context.Blob = Blob;
    app.context.URL = {
        createObjectURL: (blob) => {
            exported = blob;
            return 'blob:test';
        },
        revokeObjectURL() {},
    };
    app.context.setTimeout = (fn) => fn();
    app.context.document.body = { appendChild() {} };
    app.context.document.createElement = () => ({ click() {}, remove() {} });
    app.submit('=1+1');
    app.submit('comma, "quote"\nnext');
    app.click('pilot-download');
    const csv = await exported.text();
    assert.ok(csv.includes('"\'=1+1"'));
    assert.ok(csv.includes('"comma, ""quote""\nnext"'));
    assert.ok(csv.includes('"Waktu","Sumber","BPM"'));
});
