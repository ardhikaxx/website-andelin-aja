<div align="center">

# ANDELIN AJA

### Sistem Cerdas Penjadwalan Karyawan Berbasis Algoritma Greedy

![Laravel](https://img.shields.io/badge/Laravel-12.x-blue?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=flat&logo=bootstrap)

</div>

---

## 📋 Daftar Isi

1. [Tentang Proyek](#tentang-proyek)
2. [Fitur](#fitur)
3. [Tech Stack](#tech-stack)
4. [Struktur Database](#struktur-database)
5. [Struktur Model](#struktur-model)
6. [Fitur Admin](#fitur-admin)
7. [Fitur Karyawan](#fitur-karyawan)
8. [Algoritma Greedy](#algoritma-greedy)
9. [Instalasi](#instalasi)
10. [Struktur Folder](#struktur-folder)

---

## 📖 Tentang Proyek

**Andelin Aja** adalah sebuah platform berbasis web yang dirancang untuk menyediakan penjadwalan karyawan dan penginputan keahlian SDMnya sendiri. Agar bisa menginputkan data karyawan dengan mudah. Sistem ini bertujuan untuk menjembatani antara owner dan karyawan dalam memudahkan beberapa tugasnya. Integrasi teknologi pada website ini memungkinkan manajemen owner dan alokasi sumber daya dilakukan secara terpusat dan terstruktur.

Platform ini menggunakan **Bahasa pemrograman PHP** dan **Algoritma Greedy** untuk mengotomatisasi penjadwalan berdasarkan keahlian, ketersediaan, dan beban kerja karyawan.

### Dua Role Utama

| Role | Deskripsi |
|------|-----------|
| **Admin** | Akses penuh: manajemen karyawan, tugas, jadwal, laporan, log aktivitas |
| **Karyawan** | Akses terbatas: melihat jadwal pribadi, tugas sendiri, pengajuan cuti/tukar shift |

---

## ✨ Fitur

### Autentikasi
- Login dengan role-based redirect
- Reset password via email
- Logout aman

### Admin
- Dashboard dengan statistik real-time
- Manajemen karyawan (CRUD)
- Manajemen spesialisasi
- Manajemen tugas
- Penugasan tugas ke karyawan
- **Penjadwalan otomatis dengan Algoritma Greedy**
- Kelola pengajuan cuti & tukar shift
- Laporan & export data
- Manajemen admin lain
- Log aktivitas admin
- Pengaturan profil

### Karyawan
- Dashboard jadwal hari ini
- Kanban board tugas dengan drag & drop
- Kalender jadwal (FullCalendar)
- Pengajuan cuti
- Pengajuan tukar shift
- Pengaturan profil

---

## 🛠 Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Backend | Laravel 12 (PHP 8.2+) |
| Database | MySQL / MariaDB |
| Frontend | Bootstrap 5 |
| Icons | Font Awesome 6 |
| Alerts | SweetAlert2 |
| Calendar | FullCalendar |
| Drag & Drop | Draggable.js |
| Fonts | Poppins + Plus Jakarta Sans |

---

## 🗄️ Struktur Database

```
1. users              → Data user (admin & karyawan)
2. specializations    → Spesialisasi (perawat, dokter, dll)
3. employees          → Detail data karyawan
4. employee_specializations → Relasi many-to-many
5. tasks              → Definisi tugas
6. task_assignments   → Penugasan tugas ke karyawan
7. scheduling_rules   → Aturan penjadwalan (max jam/minggu, max tugas/hari)
8. employee_availabilities → Ketersediaan karyawan per hari
9. schedules         → Jadwal kerja karyawan
10. requests         → Permintaan cuti & tukar shift
11. shift_swaps      → Data pertukaran shift
12. reports          → Laporan bulanan
13. admin_logs       → Log aktivitas admin
```

---

## 📦 Struktur Model

| Model | Deskripsi |
|-------|-----------|
| `User` | Data pengguna dengan role admin/karyawan |
| `Employee` | Detail karyawan dengan posisi |
| `Specialization` | Spesialisasi karyawan |
| `Task` | Definisi tugas dengan deadline |
| `TaskAssignment` | Relasi tugas ke karyawan |
| `Schedule` | Jadwal kerja |
| `SchedulingRule` | Aturan penjadwalan |
| `EmployeeAvailability` | Ketersediaan karyawan |
| `Request` | Permintaan cuti/tukar shift |
| `ShiftSwap` | Data pertukaran shift |
| `Report` | Laporan bulanan |
| `AdminLog` | Log aktivitas admin |

---

## 👨‍💼 Fitur Admin

### Dashboard
- Total karyawan aktif
- Total tugas aktif
- Jumlah jadwal dari greedy
- Jumlah spesialisasi
- Tabel tugas terbaru
- Quick actions

### Manajemen
- **Karyawan**: Tambah, edit, hapus, lihat detail
- **Spesialisasi**: Kelola spesialisasi karyawan
- **Tugas**: Buat & kelola tugas dengan deadline
- **Penugasan**: Assign tugas ke karyawan secara manual
- **Penjadwalan**: Generate jadwal otomatis + filter & search
- **Pengajuan**: Approve/reject cuti & tukar shift
- **Laporan**: Rekap bulanan + export PDF/Excel
- **Admin**: Kelola admin lain + lihat log aktivitas

---

## 👷 Fitur Karyawan

### Beranda
- Jadwal kerja hari ini
- Tugas yang harus diselesaikan

### Tugas (Kanban Board)
- Kolom: Pending, In Progress, Done
- Drag & drop untuk ubah status

### Jadwal (Kalender)
- Tampilan bulan/minggu/list
- Klik event untuk detail

### Pengajuan
- Form pengajuan cuti
- Form tukar shift
- Riwayat pengajuan dengan status

### Profil
- Edit data diri
- Ganti password

---

## 🤖 Algoritma Greedy

Aplikasi ini menggunakan **Greedy Algorithm** untuk penjadwalan otomatis:

### Cara Kerja

1. Ambil semua tugas `pending`, urut berdasarkan deadline (terdekat dulu)
2. Untuk setiap tugas:
   - Cari karyawan yang **available** di hari tersebut
   - Filter karyawan yang **belum penuh** jam kerjanya (max 40 jam/minggu)
   - Filter karyawan yang **belum penuh** tugasnya (max 3 tugas/hari)
3. Pilih karyawan dengan **beban kerja terkecil** (greedy choice)
4. Assign jadwal ke karyawan tersebut
5. Ulangi hingga semua tugas terjadwal

### Konfigurasi

| Parameter | Default | Deskripsi |
|-----------|---------|-----------|
| max_hours_per_week | 40 | Maksimal jam kerja per minggu |
| max_tasks_per_day | 3 | Maksimal tugas per hari |

### Akun Default (Setelah Seeding)

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@andelin.com | password |
| Karyawan | karyawan1@andelin.com | password |
| Karyawan | karyawan2@andelin.com | password |
| Karyawan | karyawan3@andelin.com | password |
| Karyawan | karyawan4@andelin.com | password |
| Karyawan | karyawan5@andelin.com | password |
| Karyawan | karyawan6@andelin.com | password |
| Karyawan | karyawan7@andelin.com | password |
| Karyawan | karyawan8@andelin.com | password |
| Karyawan | karyawan9@andelin.com | password |
| Karyawan | karyawan10@andelin.com | password |

## 📁 Struktur Folder

```
andelin-aja/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/           → LoginController
│   │   │   ├── Admin/          → Dashboard, Employee, Task, Scheduling, dll
│   │   │   └── Employee/       → Home, Task, Schedule, Request, dll
│   │   └── Middleware/         → AdminMiddleware, EmployeeMiddleware
│   ├── Models/                  → 12 Eloquent models
│   └── Services/               → GreedySchedulerService
├── database/
│   ├── migrations/             → 13 migration files
│   └── seeders/               → Database seeders
├── resources/views/
│   ├── layouts/                → admin.blade.php, employee.blade.php
│   ├── auth/                   → login, forgot-password, reset-password
│   ├── admin/                  → dashboard, employees, tasks, scheduling, dll
│   └── employee/               → home, tasks, schedule, requests, dll
└── routes/
    └── web.php                 → Semua route aplikasi
```
