# Online Status Feature - Usage Guide

## Overview
Fitur online status memungkinkan tracking user yang sedang aktif dan menampilkan waktu terakhir mereka online. Fitur ini sudah terintegrasi di halaman admin management member.

## Optimisasi
- Menggunakan **Cache** untuk tracking real-time (sangat cepat)
- Update database hanya **setiap 5 menit** untuk mengurangi database writes
- Cache TTL: 5 menit (user dianggap online jika ada aktivitas dalam 5 menit terakhir)

## Fitur di Admin Panel

### Management Member Page
Di halaman `/admin/members`, tersedia:
- **Statistik Cards**: Total anggota, sedang online, dan anggota aktif
- **Filter Status Online**: Filter member yang sedang online atau offline
- **Kolom Status Online**: Menampilkan status online setiap member di tabel
- **Detail Member**: Menampilkan status online dan last seen di halaman detail

## Cara Menggunakan

### 1. Di Blade Template

#### Tampilkan status lengkap:
```blade
<x-user-online-status :user="$user" />
```

#### Hanya tampilkan dot indicator:
```blade
<x-user-online-status :user="$user" :showText="false" />
```

#### Custom dot size:
```blade
<x-user-online-status :user="$user" dotSize="w-3 h-3" />
```

### 2. Di Controller/Model

#### Cek apakah user online:
```php
if ($user->isOnline()) {
    // User sedang online
}
```

#### Cek apakah user baru saja online (dalam 15 menit):
```php
if ($user->wasRecentlyOnline()) {
    // User online atau baru saja online
}
```

#### Dapatkan text last seen:
```php
$lastSeen = $user->lastSeenText();
// Output: "Online", "5 minutes ago", "2 hours ago", "3 days ago", atau "25 Nov 2025"
```

### 3. Query Builder

#### Get semua user yang sedang online:
```php
$onlineUsers = User::all()->filter(fn($user) => $user->isOnline());
```

#### Get user dengan last_seen_at:
```php
$recentUsers = User::whereNotNull('last_seen_at')
    ->orderBy('last_seen_at', 'desc')
    ->get();
```

## Status Indicators

| Status | Kondisi | Indikator |
|--------|---------|-----------|
| Online | Aktivitas dalam 5 menit terakhir | 🟢 Green dot (animated) |
| Recently Online | Aktivitas dalam 15 menit terakhir | 🟡 Yellow dot |
| Offline | Lebih dari 15 menit tidak ada aktivitas | ⚪ Gray dot |

## Performance Notes

- **Cache driver**: Pastikan menggunakan Redis atau Memcached untuk production (edit `.env`)
- **Database writes**: Hanya terjadi setiap 5 menit per user
- **Cache reads**: Sangat cepat, tidak memberatkan database

## Konfigurasi

Untuk mengubah durasi "online", edit file `app/Http/Middleware/UpdateLastSeen.php`:

```php
// Ubah durasi online (default: 5 menit)
Cache::put($cacheKey, $now, now()->addMinutes(5));

// Ubah interval update database (default: 5 menit)
if ($now->diffInMinutes($lastUpdate) >= 5) {
    // ...
}
```

Untuk mengubah durasi "recently online", edit file `app/Models/User.php`:

```php
public function wasRecentlyOnline(): bool
{
    // ...
    return $this->last_seen_at->diffInMinutes(now()) <= 15; // Ubah nilai ini
}
```
