<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="Profil mahasiswa lokal Praktik Elektronika Medis">
    <title>Profil Mahasiswa | Praktik Elektronika Medis</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/identity.css">
    <link rel="stylesheet" href="/css/student-profile.css">
</head>
<body>
    <header class="site-header">
        <div class="identity-bar">
            <a class="uny-seal" href="/" aria-label="Beranda"><span><img src="/assets/logo-uny-reference.png" alt="Lambang UNY"></span></a>
            <div class="institution-name"><strong>Universitas Negeri Yogyakarta</strong><span>Fakultas Teknik · Pendidikan Teknik Elektronika</span></div>
        </div>
        <div class="platform-bar">
            <a class="course-brand" href="/">Praktik Elektronika Medis</a>
            <button type="button" class="menu-toggle" aria-label="Buka menu">☰</button>
            <nav class="main-nav" aria-label="Navigasi utama"><a href="/">Beranda</a><a href="/materi">Materi</a><a href="/jobsheet">Jobsheet</a><a href="/praktikum">Praktikum</a><a href="/asisten-ai">Asisten AI</a></nav>
        </div>
    </header>
    <main class="student-profile-page" data-student-profile-form>
        <section class="student-profile-card">
            <p class="eyebrow">Identitas lokal perangkat</p>
            <h1>Profil Mahasiswa</h1>
            <p>Masukkan nama, NIM, dan foto profil. Informasi hanya disimpan di browser pada perangkat ini, tanpa akun server, database, atau upload foto. Fitur ini <strong>bukan login akademik terverifikasi</strong>.</p>
            <div class="student-profile-preview" data-profile-preview aria-label="Pratinjau foto profil">👤</div>
            <form class="student-profile-form" autocomplete="off">
                <label>Nama lengkap
                    <input type="text" name="student_name" required minlength="2" maxlength="100" placeholder="Nama mahasiswa">
                </label>
                <label>Nomor Induk Mahasiswa (NIM)
                    <input type="text" name="student_nim" required inputmode="numeric" pattern="[0-9]{6,20}" minlength="6" maxlength="20" placeholder="Contoh: 26051640021">
                </label>
                <label>Foto profil (opsional, JPG/PNG/WebP maksimal 2 MB)
                    <input type="file" name="student_photo" accept="image/jpeg,image/png,image/webp">
                </label>
                <div class="student-profile-actions">
                    <button type="submit">Simpan Profil</button>
                    <button type="button" data-remove-profile-photo>Hapus Foto</button>
                    <button type="button" data-remove-student-profile>Hapus Profil Lokal</button>
                </div>
            </form>
            <p data-profile-status role="status" aria-live="polite">Isi formulir untuk menyimpan profil pada browser ini.</p>
            <p><strong>Privasi:</strong> profil dapat dibaca oleh orang yang menggunakan browser yang sama dan akan hilang bila data situs dihapus. Profil tidak tersinkron antar browser, perangkat, maupun domain Preview dan Production. Gunakan perangkat pribadi.</p>
            <a href="/jobsheet">Kembali ke Jobsheet</a>
        </section>
    </main>
    <script src="/js/script.js"></script>
</body>
</html>
