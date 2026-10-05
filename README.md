# WorkLeave — Sistem Informasi Manajemen Cuti Mitra Kerja

WorkLeave adalah aplikasi backend berbasis Laravel yang dikembangkan untuk membantu proses pengajuan, persetujuan, perhitungan, pemantauan, dan rekapitulasi cuti mitra kerja secara terstruktur dan terkomputerisasi menggantikan pencatatan manual di Excel.

---

## 🛠️ Tech Stack & Requirements

- **PHP**: `^8.2`
- **Composer**: `^2.x`
- **Framework**: Laravel 12 (RESTful API Starter)
- **Database**: PostgreSQL / [Supabase](https://supabase.com/)

---

## 🚀 Panduan Setup Bagi Anggota Tim (Setelah Clone)

Bagi anggota tim yang melakukan clone repositori ini ke komputer masing-masing, ikuti langkah-langkah berikut:

### 1. Clone Repositori
```bash
git clone <URL_REPOSITORY_GITHUB>
cd workleave
```

### 2. Instal Dependensi Composer
```bash
composer install
```

### 3. Salin Konfigurasi Environment
```bash
# Untuk Windows (Command Prompt / PowerShell)
copy .env.example .env

# Untuk Linux / Mac
cp .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

---

## 🗄️ Konfigurasi Database (Supabase PostgreSQL)

> **Catatan Tim:** Saat ini pembuatan database Supabase menunggu kesepakatan bersama. Konfigurasi di `.env` sudah disiapkan template-nya.

Ketika project database Supabase sudah dibuat, cukup buka menu **Project Settings** > **Database** di dashboard Supabase, lalu salin informasi koneksi ke file `.env`:

```dotenv
# Supabase PostgreSQL Configuration
DB_CONNECTION=pgsql
DB_HOST=db.xxxxxxxxxxxxxxxxxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=KATA_SANDI_DATABASE_SUPABASE_ANDA
DB_SSLMODE=require
```

### Menjalankan Migrasi & Seeder Database (Setelah Supabase Siap):
```bash
php artisan migrate --seed
```

---

## ▶️ Menjalankan Server Lokal

Untuk menjalankan server backend:
```bash
php artisan serve
```
Akses di browser atau Postman: `http://localhost:8000`

---

## 👥 Akun Demo Pengujian (Seeders)

Kata sandi bawaan untuk semua akun adalah: `password`

| Peran | Nama | Email | NIP |
| :--- | :--- | :--- | :--- |
| **Admin / HR** | HR Administrator | `admin@workleave.test` | `ADM-001` |
| **Mitra Kerja** | Budi Santoso | `budi@workleave.test` | `MTR-2024-001` |
| **Mitra Kerja** | Siti Rahmawati | `siti@workleave.test` | `MTR-2024-002` |
| **Mitra Kerja** | Dimas Prasetyo | `dimas@workleave.test` | `MTR-2024-003` |

---

## 📡 Daftar Endpoint API Utama

- `POST /api/login` : Login user
- `POST /api/logout` : Logout user
- `GET  /api/me` : Informasi user login
- `GET  /api/dashboard` : Statistik kuota & ringkasan cuti
- `GET  /api/leave-requests` : Riwayat pengajuan cuti
- `POST /api/leave-requests` : Pengajuan cuti baru
- `GET  /api/leave-requests/{id}` : Detail permohonan & riwayat persetujuan
- `POST /api/leave-requests/{id}/cancel` : Batalkan pengajuan cuti
- `GET  /api/admin/approvals` : Antrean approval admin
- `POST /api/admin/approvals/{id}/approve` : Persetujuan cuti oleh admin
- `POST /api/admin/approvals/{id}/reject` : Penolakan cuti beserta alasan
- `GET  /api/admin/balances` : Monitoring & penyesuaian kuota mitra
- `GET  /api/admin/reports` : Rekapitulasi laporan cuti mitra
