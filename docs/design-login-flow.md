# Desain Alur Login (Design Doc) — T-014

## 1. Ringkasan
Diagram alur login digambar di **Sketch canvas (AI Agent Center, proyek P-F045EE)**,
judul: `Login Flow: User -> Login Page -> Dashboard` — 31 elemen, status terverifikasi
via `GET /api/projects/P-F045EE/sketch` (31 live, 0 terhapus).

## 2. Tata letak diagram (koordinat acuan)
- **Baris atas (kiri → kanan):** `User` (ellipse kuning, x60) —panah→
  `Login Page` (kotak biru `/login`, x340) —panah→ `Dashboard` (kotak hijau
  `/dashboard`, x740). Label panah: `1. buka /login`, `2. valid: redirect`.
- **Keputusan (bawah Login Page):** garis vertikal dari Login Page ke diamond oranye
  `Kredensial valid?` (x380, y330).
  - `Ya` → panah kanan ke kotak hijau kecil `ke Dashboard / HTTP redirect`.
  - `Tidak` → garis bawah ke teks `Tidak: error, tetap /login`.
- **Logout (bawah Dashboard):** garis vertikal ke teks `3. Log Out -> / (guest)`.

Isi tiap node:
- Login Page: `email + password + LOG IN`, `Remember me`, `POST /login + CSRF`,
  `gagal: pesan error`.
- Dashboard: `You are logged in! (SMH)`, `menu SMH: Log Out -> /`,
  `guest: /dashboard -> /login`, `verified live :9998 (BA)`.

## 3. Catatan teknis Sketch API (pembelajaran sesi ini)
- `POST .../sketch/act {"action":"add", ...}` **menambah** (append), bukan mengganti;
  `{"action":"clear"}` mengosongkan — dipakai sekali untuk menghapus artefak probe
  sesi ini sebelum menggambar final.
- Batch besar (>~10 elemen) atau elemen tak valid menyebabkan batch ditolak
  (`ok:true` dengan count proyeksi, tetapi GET tidak bertambah). Aman: batch ≤ 6.
- Elemen yang terbukti aman: `rectangle`, `ellipse`, `diamond`, `text` dengan
  `fontSize` 16/20/24, `arrow` horizontal (`height:0`, `width>0`), `line` vertikal
  (`width:0`, `height>0`).
- Dihindari: `fontSize` 13/14, `arrow` dengan `width:0`, dimensi negatif —
  menyebabkan seluruh batch ditolak diam-diam.
- Verifikasi akhir: `GET` → `total: 31, live: 31`
  (20 text, 3 arrow, 3 rectangle, 3 line, 1 ellipse, 1 diamond).

## 4. Keterkaitan
- Requirements: `docs/requirements-login-flow.md`
- User stories: `docs/user-stories-login.md`
- Histori tugas terkait: T-004 s.d. T-013 di `tasks/board.md` (verifikasi login/logout).
