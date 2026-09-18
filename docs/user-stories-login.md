# User Stories — Alur Login (T-014)

## US-01: Login sebagai pengguna terdaftar
**Sebagai** pengguna terdaftar,
**saya ingin** masuk dengan email dan password saya di halaman login,
**sehingga** saya dapat mengakses dashboard saya.

**Kriteria terima:**
- Diberi halaman `/login` dengan field email, password, dan tombol `LOG IN`.
- Ketika saya mengisi kredensial valid dan menekan `LOG IN`,
  maka saya diarahkan ke `/dashboard` dan melihat `You're logged in!`.
- Ketika kredensial salah, maka saya tetap di `/login` dan melihat pesan error.

## US-02: Proteksi halaman dashboard
**Sebagai** tamu (belum login),
**saya ingin** halaman dashboard terlindungi,
**sehingga** data pengguna tidak dapat diakses tanpa autentikasi.

**Kriteria terima:**
- Ketika saya membuka `/dashboard` tanpa sesi login,
  maka saya diarahkan ke `/login`.

## US-03: Logout dari dashboard
**Sebagai** pengguna yang sedang login,
**saya ingin** keluar melalui menu akun di dashboard,
**sehingga** sesi saya berakhir dengan aman.

**Kriteria terima:**
- Diberi saya di `/dashboard`, ketika saya membuka menu akun (tombol nama saya),
  maka opsi `Log Out` tampil.
- Ketika saya mengeklik `Log Out`, maka saya mendarat di `/` sebagai tamu
  dan `/dashboard` kembali mengarah ke `/login`.

## US-04: Navigasi tamu dari halaman utama
**Sebagai** tamu di halaman utama `/`,
**saya ingin** tautan login yang jelas,
**sehingga** saya dapat mencapai halaman login dalam satu klik.

**Kriteria terima:**
- Tautan `Log in` di `/` membawa saya ke `/login`.

## Catatan uji (akun)
- Email: `smh@prokhas.com.my`, password: `abcd1234`, nama tampilan: `SMH`.
- Seluruh story di atas lolos simulasi live-browser pada 2026-09-14 (lihat
  `docs/requirements-login-flow.md` §4 dan verdict browser `success`).
