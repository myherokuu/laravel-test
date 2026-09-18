# Kebutuhan Alur Login (Requirements) — T-014

Sumber: observasi langsung aplikasi live di `http://localhost:9998` via Live Browser
(app Laravel v8.83.29, PHP v8.5.10), diverifikasi end-to-end pada 2026-09-14 oleh BA.
Akun uji: `smh@prokhas.com.my` / `abcd1234` (nama tampilan: SMH).

## 1. Ruang lingkup
Alur autentikasi pengguna: halaman publik (`/`) → halaman login (`/login`) →
dashboard terproteksi (`/dashboard`) → logout kembali menjadi tamu (`/`).
Di luar lingkup: registrasi, reset password, remember-me persistence (didokumentasikan
sebagai perilaku teramati saja).

## 2. Persyaratan fungsional

| ID | Kebutuhan | Kriteria terima |
|----|-----------|-----------------|
| FR-01 | Tamu yang membuka `/` melihat tautan `Log in` dan `Register`. | Tautan mengarah ke `/login` dan `/register`. |
| FR-02 | `GET /login` menampilkan form: field `email`, `password`, checkbox `remember`, tautan `Forgot your password?`, tombol `LOG IN`. | Semua kontrol terlihat & dapat diisi via browser (terverifikasi live). |
| FR-03 | `POST /login` memvalidasi kredensial + CSRF; kredensial salah tetap di `/login` dengan pesan error. | Tidak ada redirect ke dashboard saat gagal. |
| FR-04 | Kredensial valid me-redirect ke `/dashboard` dengan sapaan `You're logged in!` dan menu akun berlabel nama user (SMH). | Terverifikasi live: `/login` → `/dashboard`. |
| FR-05 | `/dashboard` hanya untuk user terautentikasi; tamu yang membukanya di-redirect ke `/login`. | Terverifikasi live setelah logout. |
| FR-06 | Menu akun (tombol nama user) membuka opsi `Log Out` (`href=/logout`). | Terverifikasi live: klik tombol SMH → anchor `Log Out` muncul. |
| FR-07 | Klik `Log Out` mengakhiri sesi dan mendarat di `/` sebagai tamu. | Terverifikasi live: teks kembali `Log in Register`. |
| FR-08 | Setelah logout, `/dashboard` kembali me-redirect ke `/login` (sesi benar-benar bersih). | Terverifikasi live. |

## 3. Persyaratan non-fungsional
- NFR-01: Form login harus ter-render dengan CSS/JS (regresi T-003 tidak boleh terulang:
  tidak ada directive `@vite` mentah di halaman guest).
- NFR-02: Alur login→dashboard harus selesai < 3 dtk pada lingkungan dev lokal.
- NFR-03: Tidak ada kredensial/plain secret di repo (aturan global: jangan commit `.env`).

## 4. Bukti verifikasi live (BA, 2026-09-14)
1. Buka `/` → teks `Log in Register`, klik `Log in` → `/login` (field email, password,
   remember, `Forgot your password?`, tombol `LOG IN`).
2. Isi `smh@prokhas.com.my` / `abcd1234`, klik `LOG IN` → `/dashboard`
   (`Dashboard`, `SMH`, `You're logged in!`).
3. Klik tombol `SMH` → muncul `Log Out` (`/logout`); klik → `/` sebagai tamu.
4. Buka `/dashboard` sebagai tamu → redirect ke `/login`.
5. Verdict browser: `success`.
Diagram visual alur ini ada di Sketch canvas proyek P-F045EE
(judul: "Login Flow: User -> Login Page -> Dashboard", 31 elemen, terverifikasi via GET).
