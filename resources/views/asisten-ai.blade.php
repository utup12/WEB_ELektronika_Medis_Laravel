<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Asisten pembelajaran Praktik Elektronika Medis berbasis materi website.">
    <title>Asisten AI | Praktik Elektronika Medis</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/identity.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ai.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="identity-bar">
            <a class="uny-seal" href="{{ route('home') }}" aria-label="Kembali ke Beranda">
                <span><img src="{{ asset('assets/logo-uny-reference.png') }}" alt="Lambang Universitas Negeri Yogyakarta"></span>
            </a>
            <div class="institution-name">
                <strong>Universitas Negeri Yogyakarta</strong>
                <span>Fakultas Teknik · Program Studi Pendidikan Teknik Elektronika</span>
            </div>
        </div>
        <div class="platform-bar">
            <a class="course-brand" href="{{ route('home') }}">Praktik Elektronika Medis</a>
            <button class="menu-toggle" aria-label="Buka menu" aria-expanded="false"><span></span><span></span></button>
            <nav class="main-nav" aria-label="Navigasi utama">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('materi') }}">Materi</a>
                <a href="{{ route('jobsheet') }}">Jobsheet</a>
                <a href="{{ route('praktikum') }}">Praktikum</a>
                <a href="{{ route('evaluasi') }}">Evaluasi</a>
                <a href="{{ route('laporan') }}">Unggah Laporan</a>
                <a class="active" href="{{ route('asisten-ai') }}">Asisten AI</a>
                <a href="{{ route('profil-dosen') }}">Profil Dosen</a>
                <a href="{{ route('tentang') }}">Tentang</a>
            </nav>
        </div>
    </header>

    <main class="ai-chat-page">
        <section class="ai-chat-shell" aria-labelledby="assistant-title">
            <header class="ai-chat-head">
                <div class="ai-chat-title">
                    <span class="ai-avatar" aria-hidden="true">AI</span>
                    <div>
                        <p class="eyebrow">Asisten pembelajaran</p>
                        <h1 id="assistant-title">Tanya Praktik Elektronika Medis</h1>
                        <p>Jawaban dibatasi pada sumber pembelajaran yang tersedia di website ini.</p>
                    </div>
                </div>
                <div class="ai-status">Sumber terbatas</div>
            </header>

            <div class="ai-source-scope" aria-label="Sumber pengetahuan asisten">
                <span>Menjawab dari:</span>
                <a href="{{ route('materi') }}">Materi</a>
                <a href="{{ route('jobsheet') }}">Jobsheet</a>
                <a href="{{ route('panduan-praktikum') }}">Panduan</a>
                <a href="{{ route('praktikum') }}">Praktikum</a>
                <a href="{{ route('evaluasi') }}">Evaluasi</a>
                <a href="{{ route('laporan') }}">Laporan</a>
            </div>

            <div class="chat-stream" id="chat-stream" aria-live="polite" aria-label="Percakapan dengan asisten">
                <article class="chat-message assistant-message">
                    <span class="message-avatar" aria-hidden="true">AI</span>
                    <div class="message-content">
                        <p class="message-author">Asisten Praktik</p>
                        <div class="message-bubble">
                            Halo! Saya membantu menjelaskan informasi yang sudah ada di website Praktik Elektronika Medis. Tanyakan persiapan praktikum, jobsheet, evaluasi, training kit, atau laporan.
                        </div>
                        <div class="suggestion-row" aria-label="Contoh pertanyaan">
                            <button class="suggestion" type="button" data-prompt="Apa langkah pertama sebelum menggunakan peralatan praktikum?">Persiapan praktikum</button>
                            <button class="suggestion" type="button" data-prompt="Apa saja yang perlu dicantumkan dalam laporan praktikum?">Isi laporan</button>
                            <button class="suggestion" type="button" data-prompt="Apa fungsi pengkondisian sinyal?">Pengkondisian sinyal</button>
                        </div>
                    </div>
                </article>
            </div>

            <form class="chat-composer" id="ai-chat-form" action="{{ route('asisten-ai.chat') }}" method="POST">
                @csrf
                <label class="sr-only" for="chat-message">Pertanyaan Anda</label>
                <textarea id="chat-message" name="message" maxlength="1000" placeholder="Tulis pertanyaan tentang Praktik Elektronika Medis…" required></textarea>
                <button class="chat-send" type="submit">
                    <span>Kirim</span>
                    <span aria-hidden="true">↑</span>
                </button>
            </form>
            <p class="chat-notice" id="chat-notice" role="status">Asisten tidak menggunakan sumber dari luar website ini.</p>
        </section>
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        const chatForm = document.querySelector('#ai-chat-form');
        const chatMessage = document.querySelector('#chat-message');
        const chatStream = document.querySelector('#chat-stream');
        const chatNotice = document.querySelector('#chat-notice');
        const chatSendButton = chatForm.querySelector('.chat-send');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        function scrollToLatestMessage() {
            chatStream.scrollTop = chatStream.scrollHeight;
        }

        function addMessage(role, message, sources = []) {
            const article = document.createElement('article');
            article.className = `chat-message ${role}-message`;

            const avatar = document.createElement('span');
            avatar.className = 'message-avatar';
            avatar.setAttribute('aria-hidden', 'true');
            avatar.textContent = role === 'assistant' ? 'AI' : 'Anda';

            const content = document.createElement('div');
            content.className = 'message-content';

            const author = document.createElement('p');
            author.className = 'message-author';
            author.textContent = role === 'assistant' ? 'Asisten Praktik' : 'Anda';

            const bubble = document.createElement('div');
            bubble.className = 'message-bubble';
            bubble.textContent = message;

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
            chatMessage.disabled = isSubmitting;
            chatSendButton.disabled = isSubmitting;
            chatSendButton.querySelector('span').textContent = isSubmitting ? 'Menjawab…' : 'Kirim';
        }

        async function sendMessage(message) {
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

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.errors?.message?.[0] ?? 'Pesan belum dapat diproses.');
                }

                addMessage('assistant', data.answer, data.sources);
                chatNotice.textContent = 'Jawaban diberikan dari sumber website yang paling relevan.';
            } catch (error) {
                addMessage('assistant', error.message ?? 'Terjadi gangguan. Silakan coba lagi.');
                chatNotice.textContent = 'Pesan belum terkirim. Periksa koneksi lalu coba lagi.';
            } finally {
                setSubmitting(false);
                chatMessage.focus();
            }
        }

        chatForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const message = chatMessage.value.trim();

            if (message === '') {
                return;
            }

            chatMessage.value = '';
            await sendMessage(message);
        });

        document.querySelectorAll('[data-prompt]').forEach((button) => {
            button.addEventListener('click', async () => {
                const message = button.dataset.prompt;

                if (message) {
                    await sendMessage(message);
                }
            });
        });
    </script>
</body>
</html>
