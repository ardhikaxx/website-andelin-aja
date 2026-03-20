# Andelin Aja - Sistem Penjadwalan Karyawan

Aplikasi sistem penjadwalan karyawan berbasis Laravel yang membantu mengelola jadwal kerja, penugasan tugas, dan pertukaran shift secara efisien.

## Fitur

### Fitur Admin
- **Dashboard** - Overview statistik karyawan, jadwal, dan tugas
- **Kelola Karyawan** - Tambah, edit, hapus data karyawan
- **Kelola Spesialisasi** - Mengatur specialization karyawan
- **Kelola Tugas** - Membuat dan mengelola tugas
- **Penugasan** - Menugaskan karyawan ke tugas tertentu
- **Penjadwalan Otomatis** - Generate jadwal otomatis menggunakan algoritma greedy
- **Kelola Permintaan** - Menyetujui/menolak pertukaran shift
- **Laporan** - Melihat laporan dan statistik
- **Kelola Admin** - Mengelola data admin lain

### Fitur Karyawan
- **Dashboard** - Melihat jadwal dan tugas hari ini
- **Jadwal** - Melihat jadwal kerja pribadi
- **Tugas** - Melihat dan menyelesaikan tugas yang ditugaskan
- **Permintaan** - Membuat permintaan pertukaran shift
- **Profil** - Mengubah profil dan password

### Fitur Lainnya
- **Login & Register** - Autentikasi dengan reset password
- **Middleware Role** - Pembatasan akses berdasarkan role
- **Logging** - Pencatatan aktivitas admin

## Tech Stack

- **Backend**: Laravel 11
- **Database**: MySQL
- **Frontend**: Bootstrap 5
- **Authentication**: Laravel Breeze/Jetstream

## Installation

```bash
# Clone repository
git clone https://github.com/ardhikaxx/website-andelin-aja.git

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate key
php artisan key:generate

# Configure database in .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=andelin_aja
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed

# Run server
php artisan serve
```

## Struktur Model

- **User** - Data pengguna (admin/karyawan)
- **Employee** - Data detail karyawan
- **Specialization** - Spesialisasi karyawan (perawat, dokter, dll)
- **Task** - Definisi tugas
- **TaskAssignment** - Penugasan tugas ke karyawan
- **Schedule** - Jadwal kerja karyawan
- **SchedulingRule** - Aturan penjadwalan
- **EmployeeAvailability** - Ketersediaan karyawan
- **Request** - Permintaan pertukaran shift
- **ShiftSwap** - Data pertukaran shift
- **Report** - Laporan
- **AdminLog** - Log aktivitas admin

## Struktur Folder

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Controller admin
│   │   ├── Auth/          # Controller autentikasi
│   │   └── Employee/      # Controller karyawan
│   └── Middleware/        # Role middleware
├── Models/                # Eloquent models
└── Services/             # Business logic (GreedySchedulerService)

resources/views/
├── admin/                 # View halaman admin
├── auth/                  # View autentikasi
├── employee/              # View halaman karyawan
└── layouts/               # Layout template
```

## License

MIT License
