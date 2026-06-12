# User Import Guide

Fitur import user tersedia di `App > Access Control > Users`.

## Format File

Gunakan file CSV. File ini bisa dibuka dan diedit lewat Microsoft Excel atau Google Sheets.

Klik tombol `Download CSV Template` di halaman Users, isi datanya, lalu upload lewat tombol `Import Users`.

## Kolom Template

| Column | Required | Notes |
| --- | --- | --- |
| `name` | Yes | Nama lengkap user. |
| `email` | Yes | Dipakai sebagai kunci create/update. Jika email sudah ada, user akan di-update. |
| `username` | No | Akan dinormalisasi menjadi slug underscore. |
| `npm` | No | Nomor Pokok Mahasiswa. |
| `password` | No | Minimal 8 karakter. Jika user baru dan password kosong, default `Himatif@2026`. |
| `roles` | No | Slug role, pisahkan koma. Contoh `anggota_divisi,sekretaris_1`. |
| `division` | No | Salah satu: `humas`, `psda`, `ristek`, `danus`, `medinfo`. |
| `batch_year` | No | Tahun angkatan, contoh `2023`. |
| `phone` | No | Nomor telepon. |
| `gender` | No | `male` atau `female`. |
| `birth_date` | No | Format `YYYY-MM-DD`. |
| `address` | No | Alamat. |
| `bio` | No | Bio singkat. |
| `instagram_url` | No | URL lengkap. |
| `linkedin_url` | No | URL lengkap. |
| `website_url` | No | URL lengkap. |
| `is_active` | No | `true` atau `false`. |

## Role yang Umum Dipakai

- `admin`
- `ketua`
- `wakil_ketua`
- `sekretaris_1`
- `sekretaris_2`
- `bendahara_1`
- `bendahara_2`
- `ketua_departemen`
- `wakil_ketua_departemen`
- `anggota_divisi`
- `dosen`

## Catatan

- Import hanya bisa dilakukan admin.
- Data role dan divisi harus sudah tersedia di database.
- Jika ada baris gagal validasi, Filament menyediakan file CSV gagal yang bisa diunduh, diperbaiki, lalu diimport ulang.
