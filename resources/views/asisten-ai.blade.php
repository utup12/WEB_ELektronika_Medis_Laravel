<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Asisten pembelajaran Praktik Elektronika Medis berbasis materi website.">
    <title>Asisten AI | Praktik Elektronika Medis</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/identity.css">
    <link rel="stylesheet" href="/css/ai.css">
<link rel="stylesheet" href="/css/a11y.css">
</head>
<body><a class="skip-link" href="#main-content">Lewati ke konten utama</a>
    <header class="site-header">
        <div class="identity-bar">
            <a class="uny-seal" href="{{ route('home', [], false) }}" aria-label="Kembali ke Beranda">
                <span><img src="/assets/logo-uny-reference.png" alt="Lambang Universitas Negeri Yogyakarta"></span>
            </a>
            <div class="institution-name">
                <strong>Universitas Negeri Yogyakarta</strong>
                <span>Fakultas Teknik · Program Studi Pendidikan Teknik Elektronika</span>
            </div>
        </div>
        <div class="platform-bar">
            <a class="course-brand" href="{{ route('home', [], false) }}">Praktik Elektronika Medis</a>
            <button class="menu-toggle" aria-label="Buka menu" aria-expanded="false"><span></span><span></span></button>
            <nav class="main-nav" aria-label="Navigasi utama">
                <a href="{{ route('home', [], false) }}">Beranda</a>
                <a href="{{ route('materi', [], false) }}">Materi</a>
                <a href="{{ route('praktikum', [], false) }}">Praktikum</a>
                <a href="{{ route('evaluasi', [], false) }}">Evaluasi</a>
                <a href="{{ route('laporan', [], false) }}">Unggah Laporan</a>
                <a class="active" href="{{ route('asisten-ai', [], false) }}">Asisten AI</a>
                <a href="{{ route('profil-dosen', [], false) }}">Profil Dosen</a>
            </nav>
        </div>
    </header>

    <main id="main-content" tabindex="-1" class="ai-chat-page">
        <section class="ai-chat-shell" aria-labelledby="assistant-title">
            <header class="ai-chat-head">
                <div class="ai-chat-title">
                    <span class="ai-avatar" aria-hidden="true">
                        <img src="/assets/ai-medtech-logo.svg" alt="Logo AI Elektronika Medis" class="ai-emblem-img">
                    </span>
                    <div>
                        <p class="eyebrow">Asisten pembelajaran akademik</p>
                        <h1 id="assistant-title">Tanya Praktik Elektronika Medis</h1>
                        <p>Kecerdasan buatan berbasis rujukan kurikulum dan teori instrumentasi elektronika medis.</p>
                    </div>
                </div>
                <div class="ai-status">100% lokal · tanpa API AI</div>
            </header>

            <div class="ai-source-scope" aria-label="Sumber pengetahuan asisten">
                <span>Menjawab dari:</span>
                <a href="{{ route('materi', [], false) }}">Materi</a>
                <a href="{{ route('praktikum', [], false) }}">Praktikum &amp; Jobsheet</a>
                <a href="{{ route('monitor-trainer', [], false) }}">Monitor Trainer (BLE)</a>
                <a href="{{ route('evaluasi', [], false) }}">Evaluasi</a>
                <a href="{{ route('laporan', [], false) }}">Laporan</a>
            </div>

            @php
                $usedCount = $memoryCount ?? 0;
                $limitCount = $memoryLimit ?? \App\Models\AiConversationHistory::LIMIT_PER_PERSON;
                $isFull = $memoryFull ?? ($usedCount >= $limitCount);
                $historyItems = $savedHistory ?? collect();
            @endphp

            <div class="ai-memory-bar" aria-label="Status memori percakapan">
                <div class="ai-memory-status">
                    <span>Memori tersimpan:</span>
                    <strong><span id="memory-count">{{ $usedCount }}</span> / <span id="memory-limit">{{ $limitCount }}</span></strong>
                </div>
                <button
                    type="button"
                    id="ai-reset-memory"
                    class="ai-reset-btn"
                    data-reset-url="{{ route('asisten-ai.reset', [], false) }}"
                    @if ($usedCount === 0) disabled @endif
                >
                    Reset Memori
                </button>
            </div>

            <div
                id="memory-warning"
                class="ai-memory-warning"
                role="alert"
                @if (! $isFull) hidden @endif
            >
                Memori penuh ({{ $limitCount }}/{{ $limitCount }}). Klik Reset Memori untuk menyimpan percakapan baru.
            </div>

            <div class="chat-stream" id="chat-stream" aria-live="polite" aria-label="Percakapan dengan asisten">
                <article class="chat-message assistant-message" data-welcome-message="true">
                    <span class="message-avatar" aria-hidden="true">
                        <img src="/assets/ai-medtech-logo.svg" alt="AI" class="message-avatar-img">
                    </span>
                    <div class="message-content">
                        <p class="message-author">Asisten Praktik</p>
                        <div class="message-bubble">
Halo! Saya Asisten Akademik Praktik Elektronika Medis. Saya siap membantu Anda mendiskusikan konsep biosinyal, penguat instrumentasi AD620, filter aktif, prinsip sensor PPG dan smartwatch BLE, mitigasi noise 50 Hz, hingga sistematika penulisan laporan praktikum secara profesional dan akademik.
                        </div>
                        <div class="suggestion-row" aria-label="Contoh pertanyaan">
                            <button class="suggestion" type="button" data-prompt="Bagaimana cara kerja monitoring detak jantung dengan smartwatch menggunakan BLE?">Smartwatch BLE</button>
                            <button class="suggestion" type="button" data-prompt="Jelaskan prinsip kerja sensor optik PPG dan saturasi oksigen SpO2">Prinsip PPG</button>
                            <button class="suggestion" type="button" data-prompt="Apa perbedaan karakteristik sinyal ECG, EMG, dan EEG?">ECG vs EMG vs EEG</button>
                            <button class="suggestion" type="button" data-prompt="Jelaskan fungsi rangkaian Right Leg Drive (RLD) dalam meredam noise 50 Hz">Right Leg Drive</button>
                            <button class="suggestion" type="button" data-prompt="Hitung RG AD620 untuk gain 100 kali">Hitung AD620</button>
                            <button class="suggestion" type="button" data-prompt="Apa saja yang perlu dicantumkan dalam laporan praktikum?">Isi laporan</button>
                        </div>
                    </div>
                </article>

                @foreach ($historyItems as $item)
                    <article class="chat-message user-message">
                        <span class="message-avatar" aria-hidden="true">Anda</span>
                        <div class="message-content">
                            <p class="message-author">Anda</p>
                            <div class="message-bubble">{{ $item->question }}</div>
                        </div>
                    </article>

                    <article class="chat-message assistant-message">
                        <span class="message-avatar" aria-hidden="true">
                            <img src="/assets/ai-medtech-logo.svg" alt="AI" class="message-avatar-img">
                        </span>
                        <div class="message-content">
                            <p class="message-author">Asisten Praktik</p>
                            <div class="message-bubble" data-raw-markdown="{{ $item->answer }}">{{ $item->answer }}</div>
                            @if (! empty($item->sources))
                                <div class="chat-sources">
                                    <span>Sumber:</span>
                                    @foreach ($item->sources as $source)
                                        @if (! empty($source['url']) && ! empty($source['title']))
                                            <a href="{{ $source['url'] }}">{{ $source['title'] }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <form class="chat-composer" id="ai-chat-form" action="{{ route('asisten-ai.chat', [], false) }}" method="POST">
                @csrf
                <label class="sr-only" for="chat-message">Pertanyaan Anda</label>
                <textarea id="chat-message" name="message" maxlength="1000" placeholder="{{ $isFull ? 'Memori penuh. Klik Reset Memori untuk melanjutkan…' : 'Tulis pertanyaan seputar teori, rangkaian, atau praktikum elektronika medis…' }}" @if ($isFull) disabled @endif required></textarea>
                <button class="chat-send" type="submit" @if ($isFull) disabled @endif>
                    <span>Kirim</span>
                    <span aria-hidden="true">↑</span>
                </button>
            </form>
            <p class="chat-notice" id="chat-notice" role="status">Asisten menjawab secara akademis berlandaskan pustaka instrumentasi; selalu konfirmasikan prosedur dan keselamatan dengan dosen pengampu.</p>
        </section>
    </main>

    <script src="/js/script.js"></script>
    <script>
        const chatForm = document.querySelector('#ai-chat-form');
        const chatMessage = document.querySelector('#chat-message');
        const chatStream = document.querySelector('#chat-stream');
        const chatNotice = document.querySelector('#chat-notice');
        const chatSendButton = chatForm.querySelector('.chat-send');
        const memoryCountEl = document.querySelector('#memory-count');
        const memoryLimitEl = document.querySelector('#memory-limit');
        const memoryWarningEl = document.querySelector('#memory-warning');
        const resetMemoryButton = document.querySelector('#ai-reset-memory');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        let isMemoryFull = @json($isFull);

        function escapeHtml(text) {
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function formatSafeMarkdown(text) {
            let safe = escapeHtml(text);
            safe = safe.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
            safe = safe.replace(/`([^`]+)`/g, '<code>$1</code>');
            safe = safe.replace(/(^|\s)\*([^*\n]+)\*(?=\s|[.,!?:;]|$)/g, '$1<em>$2</em>');
            return safe;
        }

        document.querySelectorAll('[data-raw-markdown]').forEach((el) => {
            el.innerHTML = formatSafeMarkdown(el.dataset.rawMarkdown ?? el.textContent ?? '');
        });

        function scrollToLatestMessage() {
            chatStream.scrollTop = chatStream.scrollHeight;
        }

        function updateMemoryState(memory) {
            if (!memory || typeof memory !== 'object') {
                return;
            }

            const used = Number(memory.used ?? 0);
            const limit = Number(memory.limit ?? 10);
            isMemoryFull = Boolean(memory.is_full);

            if (memoryCountEl) {
                memoryCountEl.textContent = String(used);
            }
            if (memoryLimitEl) {
                memoryLimitEl.textContent = String(limit);
            }
            if (resetMemoryButton) {
                resetMemoryButton.disabled = used <= 0;
            }
            if (memoryWarningEl) {
                memoryWarningEl.hidden = !isMemoryFull;
                if (isMemoryFull) {
                    memoryWarningEl.textContent = `Memori penuh (${used}/${limit}). Klik Reset Memori untuk menyimpan percakapan baru.`;
                }
            }

            chatMessage.disabled = isMemoryFull;
            chatSendButton.disabled = isMemoryFull;
            chatMessage.placeholder = isMemoryFull
                ? 'Memori penuh. Klik Reset Memori untuk melanjutkan…'
                : 'Tulis pertanyaan seputar teori, rangkaian, atau praktikum elektronika medis…';
        }

        function addMessage(role, message, sources = []) {
            const article = document.createElement('article');
            article.className = `chat-message ${role}-message`;

            const avatar = document.createElement('span');
            avatar.className = 'message-avatar';
            avatar.setAttribute('aria-hidden', 'true');
            if (role === 'assistant') {
                avatar.innerHTML = '<img src="/assets/ai-medtech-logo.svg" alt="AI" class="message-avatar-img">';
            } else {
                avatar.textContent = 'Anda';
            }

            const content = document.createElement('div');
            content.className = 'message-content';

            const author = document.createElement('p');
            author.className = 'message-author';
            author.textContent = role === 'assistant' ? 'Asisten Praktik' : 'Anda';

            const bubble = document.createElement('div');
            bubble.className = 'message-bubble';
            if (role === 'assistant') {
                bubble.innerHTML = formatSafeMarkdown(message);
            } else {
                bubble.textContent = message;
            }

            content.append(author, bubble);

            if (sources.length > 0) {
                const sourceList = document.createElement('div');
                sourceList.className = 'chat-sources';

                const sourceLabel = document.createElement('span');
                sourceLabel.textContent = 'Sumber:';
                sourceList.append(sourceLabel);

                sources.forEach((source) => {
                    const sourceLink = document.createElement('a');
                    sourceLink.href = source.url;
                    sourceLink.textContent = source.title;
                    sourceList.append(sourceLink);
                });

                content.append(sourceList);
            }

            article.append(avatar, content);
            chatStream.append(article);
            scrollToLatestMessage();
        }

        function setSubmitting(isSubmitting) {
            chatMessage.disabled = isSubmitting || isMemoryFull;
            chatSendButton.disabled = isSubmitting || isMemoryFull;
            chatSendButton.querySelector('span').textContent = isSubmitting ? 'Menjawab…' : 'Kirim';
        }

        async function sendMessage(message) {
            if (isMemoryFull) {
                chatNotice.textContent = 'Memori penuh. Klik Reset Memori untuk melanjutkan percakapan.';
                return;
            }

            addMessage('user', message);
            setSubmitting(true);
            chatNotice.textContent = 'Asisten sedang mencari jawaban dari sumber pembelajaran…';

            try {
                const response = await fetch(chatForm.action, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ message }),
                });

                const contentType = response.headers.get('content-type') ?? '';
                const data = contentType.includes('application/json')
                    ? await response.json()
                    : null;

                if (!response.ok) {
                    const message = response.status === 419
                        ? 'Sesi formulir kedaluwarsa. Muat ulang halaman sebelum mengirim pesan.'
                        : response.status >= 500
                            ? 'Server asisten mengalami gangguan (HTTP ' + response.status + ').'
                            : data?.errors?.message?.[0] ?? data?.message ??
                                'Pesan belum dapat diproses (HTTP ' + response.status + ').';
                    throw new Error(message);
                }

                if (!data || typeof data.answer !== 'string') {
                    throw new Error('Server tidak mengembalikan jawaban JSON yang valid.');
                }

                addMessage('assistant', data.answer, Array.isArray(data.sources) ? data.sources : []);

                if (data.memory) {
                    updateMemoryState(data.memory);
                }

                chatNotice.textContent = data.memory_warning
                    ? data.memory_warning
                    : 'Jawaban diberikan dari sumber website yang paling relevan.';
            } catch (error) {
                const message = error instanceof TypeError
                    ? 'Koneksi ke endpoint asisten gagal. Periksa domain dan koneksi, lalu muat ulang halaman.'
                    : error.message ?? 'Terjadi gangguan. Silakan coba lagi.';
                addMessage('assistant', message);
                chatNotice.textContent = 'Jawaban gagal dimuat. Pertanyaan masih dapat dikirim ulang.';
            } finally {
                setSubmitting(false);
                if (!isMemoryFull) {
                    chatMessage.focus();
                }
            }
        }

        if (resetMemoryButton) {
            resetMemoryButton.addEventListener('click', async () => {
                const resetUrl = resetMemoryButton.dataset.resetUrl;
                if (!resetUrl) {
                    return;
                }

                resetMemoryButton.disabled = true;
                chatNotice.textContent = 'Menghapus riwayat memori percakapan Anda…';

                try {
                    const response = await fetch(resetUrl, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                    });

                    const data = await response.json();

                    if (!response.ok || !data?.ok) {
                        throw new Error(data?.message ?? 'Gagal mereset memori.');
                    }

                    chatStream.querySelectorAll('.chat-message:not([data-welcome-message="true"])').forEach((node) => {
                        node.remove();
                    });

                    updateMemoryState(data.memory);
                    chatNotice.textContent = 'Memori percakapan berhasil direset. Silakan ajukan pertanyaan baru.';
                    chatMessage.focus();
                } catch (error) {
                    chatNotice.textContent = error.message ?? 'Gagal mereset memori.';
                    resetMemoryButton.disabled = false;
                }
            });
        }

        chatForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            if (isMemoryFull) {
                return;
            }

            const message = chatMessage.value.trim();

            if (message === '') {
                return;
            }

            chatMessage.value = '';
            await sendMessage(message);
        });

        chatMessage.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                chatForm.requestSubmit();
            }
        });

        document.querySelectorAll('[data-prompt]').forEach((button) => {
            button.addEventListener('click', async () => {
                if (isMemoryFull) {
                    chatNotice.textContent = 'Memori penuh. Klik Reset Memori untuk melanjutkan percakapan.';
                    return;
                }

                const message = button.dataset.prompt;

                if (message) {
                    await sendMessage(message);
                }
            });
        });

        scrollToLatestMessage();
    </script>
</body>
</html>
