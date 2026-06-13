# User Import Guide

Fitur import user tersedia di `App > Access Control > Users`.

## Format File

Import sistem memakai file CSV karena fitur import bawaan Filament paling stabil untuk format itu.

Alur yang disarankan:

1. Klik `Download Excel Template` di halaman Users.
2. Isi data user di Microsoft Excel.
3. Simpan dengan `Save As > CSV UTF-8`.
4. Upload file CSV lewat tombol `Import Users`.

Alternatif: klik `Download CSV Template`, isi langsung di Excel/Google Sheets, lalu simpan sebagai CSV UTF-8.

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
