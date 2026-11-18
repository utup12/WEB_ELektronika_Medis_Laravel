# Panduan Setup Cloudflare R2 + Database Eksternal di Vercel

Agar unggahan laporan mahasiswa (PDF hingga 10 MB) dan data akun/evaluasi tersimpan **permanen** di deployment Vercel (karena filesystem serverless Vercel bersifat sementara dan batas body HTTP Vercel ~4,5 MB):

## 1. Buat Bucket Cloudflare R2
1. Masuk ke **Cloudflare Dashboard → R2 Object Storage → Create bucket** (misal nama bucket: `pem-uny-laporan`).
2. Buka tab **Settings → CORS Policy** di bucket tersebut, lalu tambahkan konfigurasi CORS agar browser mahasiswa bisa mengunggah PDF langsung (*direct presigned PUT*) ke R2:

```json
[
  {
    "AllowedOrigins": [
      "https://praktik-elkamedis.vercel.app",
      "http://localhost:8000"
    ],
    "AllowedMethods": ["GET", "PUT", "HEAD"],
    "AllowedHeaders": ["*"],
    "ExposeHeaders": ["ETag"],
    "MaxAgeSeconds": 3600
  }
]
```

3. Buka **R2 → Manage R2 API Tokens → Create API Token**:
   - Permissions: **Object Read & Write**
   - Specify bucket: pilih `pem-uny-laporan`
   - Salin **Access Key ID**, **Secret Access Key**, dan **Account ID** Cloudflare Anda.

## 2. Buat Database PostgreSQL Gratis (Neon atau Supabase)
- Di **Neon** (`neon.tech`) atau **Supabase**, buat 1 database PostgreSQL gratis dan catat detail koneksi (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

## 3. Tambahkan Environment Variables di Vercel Project Settings
Masuk ke **Vercel → Project Settings → Environment Variables** (`Production`), lalu isi:

### Cloudflare R2
- `R2_ACCOUNT_ID` = `<Account ID Cloudflare Anda>`
- `R2_BUCKET` = `pem-uny-laporan`
- `R2_ACCESS_KEY_ID` = `<Access Key ID R2>`
- `R2_SECRET_ACCESS_KEY` = `<Secret Access Key R2>`
- `R2_REGION` = `auto`

### Database PostgreSQL
- `DB_CONNECTION` = `pgsql`
- `DB_HOST` = `<host database Neon/Supabase>`
- `DB_PORT` = `5432`
- `DB_DATABASE` = `<nama database>`
- `DB_USERNAME` = `<username>`
- `DB_PASSWORD` = `<password>`
- `SESSION_DRIVER` = `database` (opsional, disarankan jika DB eksternal sudah aktif)

Setelah menyimpan environment variables di atas, lakukan redeploy agar container memakai konfigurasi terbaru.
