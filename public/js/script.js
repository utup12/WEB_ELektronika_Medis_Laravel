const platformBar = document.querySelector('.platform-bar');

// Samakan header halaman turunan dengan header Beranda tanpa mengubah tata letak:
// Menu berlabel di kiri, informasi mata kuliah dan tombol tema di kanan.
const legacyToggle = platformBar?.querySelector('.menu-toggle');
if (legacyToggle) {
    const navigation = platformBar.querySelector('.main-nav');
    const courseBrand = platformBar.querySelector('.course-brand');
    const dropdown = document.createElement('details');
    dropdown.className = 'nav-dropdown';
    dropdown.innerHTML =
        '<summary><span class="menu-icon" aria-hidden="true"><i></i><i></i><i></i></span><span>Menu</span></summary>';
    if (navigation) dropdown.appendChild(navigation);
    legacyToggle.replaceWith(dropdown);

    const headerTools = document.createElement('div');
    headerTools.className = 'header-tools';
    if (courseBrand) headerTools.appendChild(courseBrand);
    platformBar.appendChild(headerTools);
}

const toggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('.main-nav');

// Tautan panduan tersedia konsisten pada menu setiap halaman.
if (nav && !nav.querySelector('a[href*="panduan-praktikum"]')) {
    const guideLink = document.createElement('a');
    guideLink.href = '/panduan-praktikum';
    guideLink.textContent = 'Panduan Praktikum';
    if (window.location.pathname.endsWith('/panduan-praktikum'))
        guideLink.classList.add('active');
    const practicalLink = nav.querySelector('a[href$="/praktikum"]');
    practicalLink?.insertAdjacentElement('afterend', guideLink);
}

const themeStylesheet = document.createElement('link');
themeStylesheet.rel = 'stylesheet';
// Versi pada URL mencegah browser memakai stylesheet tema lama setelah pembaruan.
themeStylesheet.href = new URL(
    '../css/theme.css?v=20261023-1',
    document.currentScript.src,
).href;
document.head.appendChild(themeStylesheet);

let themeToggle = platformBar?.querySelector('.theme-control');

if (platformBar && !themeToggle) {
    themeToggle = document.createElement('button');
    themeToggle.className = 'theme-control';
    themeToggle.type = 'button';
    const headerTools =
        platformBar.querySelector('.header-tools') || platformBar;
    headerTools.appendChild(themeToggle);
}

const applyTheme = (isDark) => {
    const theme = isDark ? 'dark' : 'light';

    document.documentElement.dataset.theme = theme;
    document.body.classList.toggle('dark-mode', isDark);

    if (themeToggle) {
        themeToggle.textContent = isDark ? '☀' : '◐';
        themeToggle.setAttribute(
            'aria-label',
            isDark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap',
        );
        themeToggle.title = isDark
            ? 'Aktifkan mode terang'
            : 'Aktifkan mode gelap';
    }
};

let initialDarkMode = false;
try {
    initialDarkMode = localStorage.getItem('pem-theme') === 'dark';
} catch {
    // Keep the default theme when browser storage is unavailable.
}
applyTheme(initialDarkMode);

themeToggle?.addEventListener('click', () => {
    const isDark = document.documentElement.dataset.theme !== 'dark';
    try {
        localStorage.setItem('pem-theme', isDark ? 'dark' : 'light');
    } catch {
        // The theme still changes for the current page.
    }
    applyTheme(isDark);
});

nav?.querySelectorAll('a.active').forEach((link) => {
    link.setAttribute('aria-current', 'page');
});

const trainerHeader = document.querySelector('.trainer-screen-top');
if (trainerHeader) {
    const trainerHeaderLabel = trainerHeader.querySelector('span:nth-child(2)');
    if (trainerHeaderLabel)
        trainerHeaderLabel.textContent = 'HEART RATE MONITOR · MODE SIMULASI';

    const heartbeatValue = document.querySelector('#heart-rate-value');
    const heartbeatStatus = document.querySelector('#heart-rate-status');
    const pulseWrap = document.querySelector('.heart-pulse-wrap');
    const trainerStatus = trainerHeader.querySelector('.trainer-status');
    const simulatorPanel = document.querySelector('.simulator-panel');

    if (heartbeatValue && heartbeatStatus && pulseWrap && simulatorPanel) {
        const baseHeartRate = 72;
        const minHeartRate = 30;
        const maxHeartRate = 240;
        let bluetoothDevice;
        let simulationInterval;

        const connectButton = document.createElement('button');
        connectButton.className = 'connect-button';
        connectButton.type = 'button';
        connectButton.textContent = 'Connect Bluetooth';
        connectButton.setAttribute(
            'aria-label',
            'Hubungkan sensor detak jantung melalui Bluetooth',
        );

        const connectMessage = document.createElement('p');
        connectMessage.className = 'connect-message';
        connectMessage.setAttribute('role', 'status');
        connectMessage.setAttribute('aria-live', 'polite');
        connectMessage.textContent =
            'Mode simulasi aktif. Hubungkan sensor BLE untuk membaca BPM nyata.';

        const connectRow = document.createElement('div');
        connectRow.className = 'trainer-connect-row';
        connectRow.append(connectButton);
        simulatorPanel.prepend(connectMessage);
        simulatorPanel.prepend(connectRow);

        const setHeartRate = (heartRate) => {
            const displayedRate = Math.round(heartRate);
            const animationRate = Math.min(
                Math.max(displayedRate, minHeartRate),
                maxHeartRate,
            );
            heartbeatValue.textContent = String(displayedRate);
            const beatDuration = 60000 / animationRate;
            pulseWrap.style.setProperty('--beat-duration', `${beatDuration}ms`);
        };

        const simulateHeartRate = () => {
            const variation =
                12 * Math.sin(Date.now() / 1800) +
                8 * Math.sin(Date.now() / 5200);
            const targetRate = baseHeartRate + variation;
            setHeartRate(targetRate);
        };

        const startSimulation = () => {
            window.clearInterval(simulationInterval);
            heartbeatStatus.textContent = 'SIM READY';
            if (trainerHeaderLabel)
                trainerHeaderLabel.textContent = 'HEART RATE MONITOR · MODE SIMULASI';
            if (trainerStatus) trainerStatus.textContent = 'SIMULASI';
            connectButton.textContent = 'Connect Bluetooth';
            simulateHeartRate();
            simulationInterval = window.setInterval(simulateHeartRate, 300);
        };

        const handleDisconnect = () => {
            bluetoothDevice = undefined;
            connectMessage.textContent =
                'Sensor terputus. Mode simulasi aktif kembali.';
            startSimulation();
        };

        connectButton.addEventListener('click', async () => {
            if (bluetoothDevice?.gatt?.connected) {
                bluetoothDevice.gatt.disconnect();
                return;
            }

            if (!navigator.bluetooth) {
                connectMessage.textContent =
                    'Browser ini tidak mendukung Web Bluetooth. Gunakan Chrome atau Edge melalui HTTPS atau localhost.';
                return;
            }

            connectButton.disabled = true;
            connectButton.textContent = 'Mencari sensor…';
            connectMessage.textContent =
                'Pilih smartwatch atau sensor yang mendukung BLE Heart Rate Service.';

            let selectedDevice;

            try {
                selectedDevice = await navigator.bluetooth.requestDevice({
                    acceptAllDevices: true,
                    optionalServices: ['heart_rate'],
                });

                const server = await selectedDevice.gatt.connect();
                const heartRateService =
                    await server.getPrimaryService('heart_rate');
                const measurement = await heartRateService.getCharacteristic(
                    'heart_rate_measurement',
                );

                await measurement.startNotifications();
                bluetoothDevice = selectedDevice;
                bluetoothDevice.addEventListener(
                    'gattserverdisconnected',
                    handleDisconnect,
                    { once: true },
                );
                measurement.addEventListener(
                    'characteristicvaluechanged',
                    (event) => {
                        const value = event.target.value;
                        if (!value || value.byteLength < 2) {
                            return;
                        }

                        const flags = value.getUint8(0);
                        const isSixteenBit = (flags & 0x01) !== 0;
                        if (isSixteenBit && value.byteLength < 3) {
                            connectMessage.textContent =
                                'Paket BLE tidak lengkap; menunggu pembacaan berikutnya.';
                            return;
                        }
                        const heartRate = isSixteenBit
                            ? value.getUint16(1, true)
                            : value.getUint8(1);

                        if (heartRate >= minHeartRate && heartRate <= maxHeartRate) {
                            setHeartRate(heartRate);
                            heartbeatStatus.textContent = 'BLE LIVE';
                            if (trainerStatus) trainerStatus.textContent = 'BLE DATA';
                            if (trainerHeaderLabel)
                                trainerHeaderLabel.textContent = 'HEART RATE MONITOR · MODE BLE';
                            connectMessage.textContent =
                                'Data BPM diterima melalui BLE Heart Rate Service. Belum tervalidasi untuk penggunaan klinis.';
                        } else {
                            connectMessage.textContent =
                                'Nilai BPM di luar rentang tampilan; data diabaikan.';
                        }
                    },
                );

                window.clearInterval(simulationInterval);
                heartbeatValue.textContent = '—';
                heartbeatStatus.textContent = 'BLE WAIT';
                if (trainerHeaderLabel)
                    trainerHeaderLabel.textContent = 'HEART RATE MONITOR · MENUNGGU BLE';
                if (trainerStatus) trainerStatus.textContent = 'MENUNGGU DATA';
                connectButton.textContent = 'Disconnect';
                connectMessage.textContent = `Terhubung ke ${selectedDevice.name || 'sensor'}. Menunggu data BPM…`;
            } catch (error) {
                const message =
                    error.name === 'NotFoundError'
                        ? 'Pemilihan sensor dibatalkan.'
                        : error.name === 'NetworkError'
                          ? 'Perangkat tidak menyediakan BLE Heart Rate Service (UUID 0x180D).'
                          : `Koneksi gagal: ${error.message}`;

                if (selectedDevice?.gatt?.connected) {
                    selectedDevice.gatt.disconnect();
                }
                bluetoothDevice = undefined;
                connectMessage.textContent = message;
                startSimulation();
            } finally {
                connectButton.disabled = false;
            }
        });

        startSimulation();
    }
}

if (window.location.pathname.endsWith('asisten-ai.html')) {
    const aiChatStylesheet = document.createElement('link');
    aiChatStylesheet.rel = 'stylesheet';
    aiChatStylesheet.href = 'ai-chat.css';
    document.head.appendChild(aiChatStylesheet);
    const aiMain = document.querySelector('main');
    if (aiMain) {
        aiMain.className = 'ai-chat-page';
        aiMain.innerHTML = `<section class="ai-chat-head"><div class="ai-chat-title"><span class="ai-avatar">AI</span><div><h1>Asisten Pembelajaran</h1><p>Praktik Elektronika Medis · PTE UNY</p></div></div><span class="ai-pending">Dalam pengembangan</span></section><section class="chat-stream"><div class="chat-welcome"><h2>Apa yang ingin Anda pelajari?</h2><p>Asisten ini direncanakan membantu pembelajaran instrumentasi dan elektronika medis.</p></div><article class="chat-message user"><div class="message-bubble"><p>Bagaimana fungsi pengkondisi sinyal pada sistem instrumentasi medis?</p></div><span class="message-avatar">M</span></article><article class="chat-message"><span class="message-avatar">AI</span><div class="message-bubble"><p>Pengkondisi sinyal digunakan untuk menyesuaikan sinyal dari sensor agar dapat diproses oleh sistem berikutnya, misalnya melalui penguatan, penyaringan noise, atau penyesuaian level tegangan.</p><p>Contoh percakapan ini hanya tampilan antarmuka. Fitur AI belum diaktifkan.</p></div></article><div class="suggestion-row"><button class="suggestion" type="button">Konsep sensor PPG</button><button class="suggestion" type="button">Dasar ECG</button><button class="suggestion" type="button">Prosedur keselamatan</button></div></section><section class="chat-composer-wrap"><form class="chat-composer" id="ai-chat-form"><textarea id="ai-chat-input" rows="1" placeholder="Tulis pertanyaan tentang materi praktikum…" aria-label="Pertanyaan untuk asisten pembelajaran"></textarea><button class="chat-send" aria-label="Kirim pertanyaan" type="submit">↑</button></form><p class="chat-notice" id="ai-chat-notice">Asisten AI masih dalam tahap pengembangan dan belum memberikan jawaban otomatis.</p></section>`;
        document.querySelectorAll('.suggestion').forEach((button) =>
            button.addEventListener('click', () => {
                document.querySelector('#ai-chat-input').value =
                    button.textContent;
            }),
        );
        document
            .querySelector('#ai-chat-form')
            .addEventListener('submit', (event) => {
                event.preventDefault();
                document.querySelector('#ai-chat-notice').textContent =
                    'Pesan belum dikirim karena layanan Asisten AI belum diimplementasikan.';
            });
    }
}

if (toggle && nav)
    toggle.addEventListener('click', () => {
        const isOpen = nav.classList.toggle('open');
        toggle.setAttribute('aria-expanded', String(isOpen));
    });

document.querySelectorAll('.main-nav a').forEach((link) => {
    link.addEventListener('click', () => {
        nav?.classList.remove('open');
        link.closest('.nav-dropdown')?.removeAttribute('open');
        if (toggle) toggle.setAttribute('aria-expanded', 'false');
    });
});

const reportForm = document.querySelector('#report-form');
const reportFile = document.querySelector('#report-file');
const selectedFile = document.querySelector('#selected-file');
const uploadStatus = document.querySelector('#upload-status');
const dropzone = document.querySelector('.upload-dropzone');
let selectedReportFile;

const maxReportBytes = 10 * 1024 * 1024;

function showSelectedFile(file) {
    selectedReportFile = undefined;
    if (!file) {
        if (selectedFile) selectedFile.textContent = 'Belum ada berkas yang dipilih.';
        return;
    }
    const isPdf = file.type === 'application/pdf' || /\\.pdf$/i.test(file.name);
    if (!isPdf || file.size > maxReportBytes || file.size === 0) {
        if (reportFile) reportFile.value = '';
        if (selectedFile) selectedFile.textContent = 'Berkas belum diterima.';
        if (uploadStatus)
            uploadStatus.textContent = !isPdf
                ? 'Pilih berkas PDF.'
                : 'Ukuran PDF harus lebih dari 0 byte dan maksimal 10 MB.';
        return;
    }
    selectedReportFile = file;
    const sizeMb = (file.size / 1024 / 1024).toFixed(2);
    if (selectedFile)
        selectedFile.textContent = `Berkas dipilih: ${file.name} (${sizeMb} MB)`;
    if (uploadStatus) uploadStatus.textContent = '';
}

if (reportFile)
    reportFile.addEventListener('change', () =>
        showSelectedFile(reportFile.files[0]),
    );

['dragenter', 'dragover'].forEach((eventName) => {
    if (dropzone)
        dropzone.addEventListener(eventName, (event) => {
            event.preventDefault();
            dropzone.classList.add('dragover');
        });
});

['dragleave', 'drop'].forEach((eventName) => {
    if (dropzone)
        dropzone.addEventListener(eventName, (event) => {
            event.preventDefault();
            dropzone.classList.remove('dragover');
            if (eventName === 'drop') showSelectedFile(event.dataTransfer?.files?.[0]);
        });
});

if (reportForm)
    reportForm.addEventListener('submit', (event) => {
        event.preventDefault();
        uploadStatus.textContent = selectedReportFile
            ? 'Berkas PDF terpilih untuk pengumpulan manual. Belum dikirim ke dosen atau server; fitur pengumpulan daring belum tersedia.'
            : 'Silakan pilih PDF yang valid (maksimal 10 MB) terlebih dahulu. Tidak ada berkas yang dikirim.';
    });

const readinessQuiz = document.querySelector('#readiness-quiz');
if (readinessQuiz)
    readinessQuiz.addEventListener('submit', (event) => {
        event.preventDefault();
        const answers = new FormData(readinessQuiz);
        const score = ['safety', 'signal', 'report'].reduce(
            (total, name) => total + (answers.get(name) === 'correct' ? 1 : 0),
            0,
        );
        document.querySelector('#quiz-result').textContent =
            `Hasil latihan: ${score}/3 jawaban tepat. Hasil ini hanya latihan awal dan belum disimpan.`;
    });


document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    document.querySelectorAll('.nav-dropdown[open]').forEach((dropdown) => {
        dropdown.removeAttribute('open');
        dropdown.querySelector('summary')?.focus();
    });
});

// Profil mahasiswa tersimpan hanya dalam localStorage pada origin saat ini.
if (!document.querySelector('script[data-student-profile-loader]')) {
    const stylesheet = document.createElement('link');
    stylesheet.rel = 'stylesheet';
    stylesheet.href = '/css/student-profile.css';
    document.head.appendChild(stylesheet);
    const profileScript = document.createElement('script');
    profileScript.src = '/js/student-profile.js';
    profileScript.defer = true;
    profileScript.dataset.studentProfileLoader = '';
    document.body.appendChild(profileScript);
}
