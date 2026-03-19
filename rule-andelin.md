# 📋 RULE-ANDELIN.MD — Blueprint Proyek ANDELIN AJA
> Sistem Penjadwalan Karyawan dengan Implementasi Algoritma Greedy
> Stack: Laravel 12 | Bootstrap CDN | Font Awesome CDN | SweetAlert2 CDN | FullCalendar CDN | Draggable.js

---

## 🗂️ DAFTAR ISI
1. [Gambaran Umum Proyek](#1-gambaran-umum-proyek)
2. [Tech Stack & CDN](#2-tech-stack--cdn)
3. [Struktur Direktori Laravel](#3-struktur-direktori-laravel)
4. [Database & Migration](#4-database--migration)
5. [Model & Relasi Eloquent](#5-model--relasi-eloquent)
6. [Role & Authentication](#6-role--authentication)
7. [Algoritma Greedy — Detail Implementasi](#7-algoritma-greedy--detail-implementasi)
8. [Fitur Admin — Lengkap](#8-fitur-admin--lengkap)
9. [Fitur Karyawan — Lengkap](#9-fitur-karyawan--lengkap)
10. [Routes](#10-routes)
11. [Controller List](#11-controller-list)
12. [UI/UX Design System & CSS Theme](#12-uiux-design-system--css-theme)
13. [Layout Blade & Aturan @stack / @push](#13-layout-blade--aturan-stack--push)
14. [SweetAlert — Pola Penggunaan](#14-sweetalert--pola-penggunaan)
15. [Validasi & Rules](#15-validasi--rules)
16. [Seeder & Factory](#16-seeder--factory)

---

## 1. GAMBARAN UMUM PROYEK

**Nama Aplikasi**: ANDELIN AJA
**Tagline**: Sistem Cerdas Penjadwalan Karyawan Berbasis Algoritma Greedy
**Tujuan**: Mengotomatisasi penjadwalan karyawan secara efisien berdasarkan keahlian, ketersediaan, dan beban kerja menggunakan pendekatan Greedy Algorithm.

### Dua Role Utama:
| Role | Akses |
|------|-------|
| `admin` | Full akses: manajemen karyawan, tugas, jadwal, laporan, log |
| `karyawan` | Akses terbatas: melihat jadwal pribadi, tugas sendiri, pengajuan |

---

## 2. TECH STACK & CDN

### Backend
```
Laravel 12 (PHP 8.2+)
MySQL / MariaDB
Laravel Sanctum (auth session)
```

### Frontend CDN (taruh di `layouts/app.blade.php`)
```html
<!-- Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- FullCalendar (khusus halaman karyawan - jadwal saya) -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<!-- Draggable.js (khusus halaman tugas karyawan) -->
<script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.12/lib/draggable.bundle.js"></script>

<!-- Google Fonts: Poppins + Plus Jakarta Sans -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
```

---

## 3. STRUKTUR DIREKTORI LARAVEL

```
andelin-aja/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── LoginController.php
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── EmployeeController.php
│   │   │   │   ├── SpecializationController.php
│   │   │   │   ├── TaskController.php
│   │   │   │   ├── AssignmentController.php
│   │   │   │   ├── SchedulingController.php       ← GREEDY ENGINE
│   │   │   │   ├── RequestController.php
│   │   │   │   ├── ReportController.php
│   │   │   │   ├── AdminManagementController.php
│   │   │   │   └── ProfileController.php
│   │   │   └── Employee/
│   │   │       ├── HomeController.php
│   │   │       ├── TaskController.php
│   │   │       ├── ScheduleController.php
│   │   │       ├── RequestController.php
│   │   │       └── ProfileController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       └── EmployeeMiddleware.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Employee.php
│   │   ├── Specialization.php
│   │   ├── EmployeeSpecialization.php
│   │   ├── Task.php
│   │   ├── TaskAssignment.php
│   │   ├── Schedule.php
│   │   ├── SchedulingRule.php
│   │   ├── EmployeeAvailability.php
│   │   ├── Request.php
│   │   ├── ShiftSwap.php
│   │   ├── Report.php
│   │   └── AdminLog.php
│   └── Services/
│       └── GreedySchedulerService.php             ← CORE GREEDY LOGIC
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── admin.blade.php
│       │   └── employee.blade.php
│       ├── auth/
│       │   └── login.blade.php
│       ├── admin/
│       │   ├── dashboard/
│       │   ├── employees/
│       │   ├── specializations/
│       │   ├── tasks/
│       │   ├── assignments/
│       │   ├── scheduling/
│       │   ├── requests/
│       │   ├── reports/
│       │   ├── admins/
│       │   └── profile/
│       └── employee/
│           ├── home/
│           ├── tasks/
│           ├── schedule/
│           ├── requests/
│           └── profile/
└── routes/
    └── web.php
```

---

## 4. DATABASE & MIGRATION

### Urutan Migration (buat dalam urutan ini agar FK tidak error):
```
1. create_users_table
2. create_specializations_table
3. create_employees_table
4. create_employee_specializations_table
5. create_tasks_table
6. create_task_assignments_table
7. create_scheduling_rules_table
8. create_employee_availabilities_table
9. create_schedules_table
10. create_requests_table
11. create_shift_swaps_table
12. create_reports_table
13. create_admin_logs_table
```

### Detail Setiap Tabel:

#### `users`
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('phone')->nullable();
    $table->enum('role', ['admin', 'karyawan'])->default('karyawan');
    $table->timestamps();
});
```

#### `employees`
```php
Schema::create('employees', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->enum('position', ['pengawas_1', 'pengawas_2', 'senior_team', 'junior_team']);
    $table->timestamps();
});
```

#### `specializations`
```php
Schema::create('specializations', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->text('description')->nullable();
    $table->timestamps();
});
```

#### `employee_specializations`
```php
Schema::create('employee_specializations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
    $table->foreignId('specialization_id')->constrained('specializations')->onDelete('cascade');
    $table->unique(['employee_id', 'specialization_id']);
});
```

#### `tasks`
```php
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->date('deadline');
    $table->enum('status', ['pending', 'in_progress', 'done'])->default('pending');
    $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
    $table->timestamps();
});
```

#### `task_assignments`
```php
Schema::create('task_assignments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
    $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
    $table->timestamp('assigned_at')->useCurrent();
});
```

#### `scheduling_rules`
```php
Schema::create('scheduling_rules', function (Blueprint $table) {
    $table->id();
    $table->integer('max_hours_per_week')->default(40);
    $table->integer('max_tasks_per_day')->default(3);
    $table->timestamps();
});
```

#### `employee_availabilities`
```php
Schema::create('employee_availabilities', function (Blueprint $table) {
    $table->id();
    $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
    $table->tinyInteger('day_of_week'); // 1=Senin, 7=Minggu
    $table->time('start_time');
    $table->time('end_time');
});
```

#### `schedules`
```php
Schema::create('schedules', function (Blueprint $table) {
    $table->id();
    $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
    $table->foreignId('task_id')->nullable()->constrained('tasks')->onDelete('set null');
    $table->date('work_date');
    $table->time('start_time');
    $table->time('end_time');
    $table->enum('status', ['scheduled', 'completed'])->default('scheduled');
    $table->enum('generated_by', ['manual', 'greedy'])->default('manual');
    $table->timestamps();
});
```

#### `requests`
```php
Schema::create('requests', function (Blueprint $table) {
    $table->id();
    $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
    $table->enum('type', ['cuti', 'tukar_jadwal']);
    $table->text('description')->nullable();
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->timestamps();
});
```

#### `shift_swaps`
```php
Schema::create('shift_swaps', function (Blueprint $table) {
    $table->id();
    $table->foreignId('request_id')->constrained('requests')->onDelete('cascade');
    $table->foreignId('from_employee_id')->constrained('employees')->onDelete('cascade');
    $table->foreignId('to_employee_id')->constrained('employees')->onDelete('cascade');
    $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
});
```

#### `reports`
```php
Schema::create('reports', function (Blueprint $table) {
    $table->id();
    $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
    $table->tinyInteger('month'); // 1-12
    $table->year('year');
    $table->decimal('total_hours', 8, 2)->default(0);
    $table->integer('total_tasks')->default(0);
    $table->timestamps();
});
```

#### `admin_logs`
```php
Schema::create('admin_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
    $table->string('action');
    $table->text('description')->nullable();
    $table->timestamps();
});
```

---

## 5. MODEL & RELASI ELOQUENT

### `User.php`
```php
protected $fillable = ['name', 'email', 'password', 'phone', 'role'];

public function employee() {
    return $this->hasOne(Employee::class);
}

public function isAdmin(): bool {
    return $this->role === 'admin';
}

public function isEmployee(): bool {
    return $this->role === 'karyawan';
}
```

### `Employee.php`
```php
protected $fillable = ['user_id', 'position'];

public function user() {
    return $this->belongsTo(User::class);
}

public function specializations() {
    return $this->belongsToMany(Specialization::class, 'employee_specializations');
}

public function tasks() {
    return $this->belongsToMany(Task::class, 'task_assignments');
}

public function schedules() {
    return $this->hasMany(Schedule::class);
}

public function availability() {
    return $this->hasMany(EmployeeAvailability::class);
}

public function requests() {
    return $this->hasMany(Request::class);
}

// Helper: total jam kerja minggu ini
public function weeklyHours(string $weekStart): float {
    return $this->schedules()
        ->whereBetween('work_date', [$weekStart, now()->endOfWeek()])
        ->get()
        ->sum(fn($s) => Carbon::parse($s->start_time)->diffInHours(Carbon::parse($s->end_time)));
}
```

### `Task.php`
```php
protected $fillable = ['title', 'description', 'deadline', 'status', 'created_by'];
protected $casts = ['deadline' => 'date'];

public function employees() {
    return $this->belongsToMany(Employee::class, 'task_assignments');
}

public function schedules() {
    return $this->hasMany(Schedule::class);
}

public function creator() {
    return $this->belongsTo(User::class, 'created_by');
}
```

### `Schedule.php`
```php
protected $fillable = ['employee_id', 'task_id', 'work_date', 'start_time', 'end_time', 'status', 'generated_by'];

public function employee() {
    return $this->belongsTo(Employee::class);
}

public function task() {
    return $this->belongsTo(Task::class);
}

// Durasi dalam jam
public function getDurationAttribute(): float {
    return Carbon::parse($this->start_time)->diffInHours(Carbon::parse($this->end_time));
}
```

---

## 6. ROLE & AUTHENTICATION

### Middleware

**`AdminMiddleware.php`**
```php
public function handle(Request $request, Closure $next): Response {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Akses ditolak. Hanya admin yang diperbolehkan.');
    }
    return $next($request);
}
```

**`EmployeeMiddleware.php`**
```php
public function handle(Request $request, Closure $next): Response {
    if (!auth()->check() || auth()->user()->role !== 'karyawan') {
        abort(403, 'Akses ditolak.');
    }
    return $next($request);
}
```

### Register di `bootstrap/app.php`
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => AdminMiddleware::class,
        'employee' => EmployeeMiddleware::class,
    ]);
})
```

### Redirect Setelah Login (di `LoginController`)
```php
protected function authenticated(Request $request, $user) {
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('employee.home');
}
```

---

## 7. ALGORITMA GREEDY — DETAIL IMPLEMENTASI

### File: `app/Services/GreedySchedulerService.php`

```php
<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\SchedulingRule;
use Carbon\Carbon;

class GreedySchedulerService
{
    private SchedulingRule $rules;

    public function __construct()
    {
        $this->rules = SchedulingRule::firstOrCreate([], [
            'max_hours_per_week' => 40,
            'max_tasks_per_day'  => 3,
        ]);
    }

    /**
     * Entry point: generate jadwal otomatis dengan Greedy
     * @return array ['scheduled' => int, 'skipped' => int, 'details' => array]
     */
    public function generate(): array
    {
        $result = ['scheduled' => 0, 'skipped' => 0, 'details' => []];

        // LANGKAH 1: Ambil semua tugas pending, sort by deadline (ascending = paling dekat dulu)
        $tasks = Task::where('status', 'pending')
                     ->orderBy('deadline', 'asc')
                     ->get();

        // LANGKAH 2: Loop setiap tugas
        foreach ($tasks as $task) {
            $assigned = false;
            $workDate = Carbon::today();
            $deadline = Carbon::parse($task->deadline);

            // LANGKAH 3: Tentukan tanggal kerja (dari hari ini s/d deadline)
            while ($workDate->lte($deadline)) {
                $dayOfWeek = $workDate->dayOfWeekIso; // 1=Senin, 7=Minggu

                // LANGKAH 4: Cari semua karyawan yang:
                //   a. Available pada hari tersebut
                //   b. Punya spesialisasi sesuai (jika task punya spesialis tertentu)
                //   c. Belum melebihi max_hours_per_week
                //   d. Belum melebihi max_tasks_per_day pada hari itu
                $candidates = $this->getCandidates($task, $workDate, $dayOfWeek);

                if ($candidates->isNotEmpty()) {
                    // LANGKAH 5: Pilih karyawan "paling ringan" (workload terkecil)
                    $bestEmployee = $this->selectLightestEmployee($candidates, $workDate);

                    // LANGKAH 6: Assign jadwal
                    $availability = $bestEmployee->availability
                        ->where('day_of_week', $dayOfWeek)
                        ->first();

                    Schedule::create([
                        'employee_id'  => $bestEmployee->id,
                        'task_id'      => $task->id,
                        'work_date'    => $workDate->toDateString(),
                        'start_time'   => $availability->start_time,
                        'end_time'     => $availability->end_time,
                        'status'       => 'scheduled',
                        'generated_by' => 'greedy',
                    ]);

                    // Update status tugas
                    $task->update(['status' => 'in_progress']);

                    $result['scheduled']++;
                    $result['details'][] = [
                        'task'     => $task->title,
                        'employee' => $bestEmployee->user->name,
                        'date'     => $workDate->format('d/m/Y'),
                    ];

                    $assigned = true;
                    break; // Lanjut ke tugas berikutnya
                }

                $workDate->addDay(); // Coba hari berikutnya
            }

            if (!$assigned) {
                $result['skipped']++;
                $result['details'][] = [
                    'task'   => $task->title,
                    'reason' => 'Tidak ada karyawan tersedia sebelum deadline',
                ];
            }
        }

        return $result;
    }

    /**
     * Cari kandidat karyawan yang memenuhi semua kriteria Greedy
     */
    private function getCandidates(Task $task, Carbon $workDate, int $dayOfWeek)
    {
        $weekStart = $workDate->copy()->startOfWeek()->toDateString();

        return Employee::with(['user', 'specializations', 'availability', 'schedules'])
            ->whereHas('availability', fn($q) => $q->where('day_of_week', $dayOfWeek))
            ->whereDoesntHave('schedules', function($q) use ($workDate) {
                // Belum punya jadwal task lain di hari ini melebihi batas
                $q->where('work_date', $workDate->toDateString())
                  ->where('task_id', '!=', null);
            }, '>=', $this->rules->max_tasks_per_day)
            ->get()
            ->filter(function($employee) use ($weekStart) {
                // Filter: total jam minggu ini belum penuh
                return $this->getWeeklyHours($employee, $weekStart) < $this->rules->max_hours_per_week;
            });
    }

    /**
     * Pilih karyawan dengan beban kerja minggu ini paling ringan (Greedy Choice)
     */
    private function selectLightestEmployee($candidates, Carbon $workDate): Employee
    {
        $weekStart = $workDate->copy()->startOfWeek()->toDateString();

        return $candidates->sortBy(function($employee) use ($weekStart) {
            return $this->getWeeklyHours($employee, $weekStart);
        })->first();
    }

    /**
     * Hitung total jam kerja karyawan dalam satu minggu
     */
    private function getWeeklyHours(Employee $employee, string $weekStart): float
    {
        $weekEnd = Carbon::parse($weekStart)->endOfWeek()->toDateString();

        return $employee->schedules
            ->whereBetween('work_date', [$weekStart, $weekEnd])
            ->sum(function($schedule) {
                return Carbon::parse($schedule->start_time)
                             ->diffInHours(Carbon::parse($schedule->end_time));
            });
    }
}
```

### Controller: `SchedulingController.php` (Admin)
```php
public function index() {
    $rules = SchedulingRule::first();
    $schedules = Schedule::with(['employee.user', 'task'])->latest()->paginate(20);
    return view('admin.scheduling.index', compact('rules', 'schedules'));
}

public function generate() {
    $service = new GreedySchedulerService();
    $result = $service->generate();

    // Log ke admin_logs
    AdminLog::create([
        'admin_id'    => auth()->id(),
        'action'      => 'GREEDY_GENERATE',
        'description' => "Dijadwalkan: {$result['scheduled']} tugas, Dilewati: {$result['skipped']} tugas",
    ]);

    return response()->json($result);
}

public function updateRules(Request $request) {
    $request->validate([
        'max_hours_per_week' => 'required|integer|min:1|max:168',
        'max_tasks_per_day'  => 'required|integer|min:1|max:24',
    ]);

    SchedulingRule::updateOrCreate([], $request->only(['max_hours_per_week', 'max_tasks_per_day']));

    return back()->with('success', 'Aturan penjadwalan berhasil diperbarui.');
}
```

---

## 8. FITUR ADMIN — LENGKAP

### 8.1 Dashboard (`admin/dashboard`)

**Card Stats (4 cards):**
| Card | Query | Icon | Warna |
|------|-------|------|-------|
| Total Karyawan | `Employee::count()` | `fa-users` | Biru |
| Total Tugas Aktif | `Task::where('status','!=','done')->count()` | `fa-tasks` | Oranye |
| Dijadwalkan Greedy | `Schedule::where('generated_by','greedy')->count()` | `fa-robot` | Hijau |
| Total Spesialisasi | `Specialization::count()` | `fa-star` | Ungu |

**Tabel Daftar Tugas Terbaru:**
- Kolom: Nama Tugas, Penanggung Jawab, Tenggat Waktu, Status
- Query: `Task::with('employees.user')->latest()->take(10)->get()`
- Status badge: `pending` → warning, `in_progress` → info, `done` → success

**Tindakan Cepat (Quick Actions):**
```html
<a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
    <i class="fas fa-user-plus"></i> Tambah Karyawan
</a>
<a href="{{ route('admin.tasks.create') }}" class="btn btn-success">
    <i class="fas fa-plus-circle"></i> Buat Tugas
</a>
<a href="{{ route('admin.reports.index') }}" class="btn btn-info">
    <i class="fas fa-chart-bar"></i> Lihat Laporan
</a>
```

### 8.2 Manajemen Karyawan (`admin/employees`)
- **Index**: Tabel semua karyawan + posisi + spesialisasi + aksi (edit/hapus)
- **Create**: Form tambah karyawan (otomatis buat user + employee)
  - Input: nama, email, password, telepon, posisi, spesialisasi (checkbox multiple)
- **Edit**: Edit data user & employee
- **Delete**: SweetAlert konfirmasi sebelum hapus
- **Show**: Detail karyawan + jadwal + tugas

### 8.3 Manajemen Spesialisasi (`admin/specializations`)
- **Index**: Tabel spesialisasi + jumlah karyawan yang punya
- **Create**: Form tambah spesialisasi (nama + deskripsi)
- **Edit/Delete**: inline atau modal

### 8.4 Manajemen Penugasan (`admin/assignments`)
- Assign tugas ke karyawan secara manual
- Select tugas → pilih karyawan (multi-select) → simpan ke `task_assignments`
- Tampilkan existing assignments per tugas

### 8.5 Manajemen Penjadwalan / Greedy (`admin/scheduling`)

**Layout Halaman:**
```
┌─────────────────────────────────────────────────┐
│  ATURAN PENJADWALAN                             │
│  Max Jam/Minggu: [40]  Max Tugas/Hari: [3]     │
│                                    [Simpan]     │
├─────────────────────────────────────────────────┤
│  [🤖 Generate Jadwal Otomatis (Greedy)]        │
│  Progress bar + log hasil generate             │
├─────────────────────────────────────────────────┤
│  TABEL JADWAL                                   │
│  Filter: Tanggal | Karyawan | Status | Generate │
│  Karyawan | Tugas | Tanggal | Jam | Status | By │
└─────────────────────────────────────────────────┘
```

**Flow Generate (AJAX):**
```javascript
// Tombol Generate
$('#btn-generate').on('click', function () {
    Swal.fire({
        title: 'Generate Jadwal Otomatis?',
        text: 'Sistem akan menjalankan algoritma Greedy untuk menjadwalkan semua tugas pending.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Generate!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#loading-overlay').show();
            $.post('/admin/scheduling/generate', { _token: '{{ csrf_token() }}' })
                .done(function(data) {
                    Swal.fire({
                        title: 'Berhasil!',
                        html: `✅ <b>${data.scheduled}</b> tugas berhasil dijadwalkan<br>
                               ⚠️ <b>${data.skipped}</b> tugas dilewati`,
                        icon: 'success'
                    }).then(() => location.reload());
                });
        }
    });
});
```

### 8.6 Manajemen Pengajuan (`admin/requests`)
- Tabel semua pengajuan (cuti & tukar jadwal) dari karyawan
- Aksi: Approve / Reject dengan SweetAlert konfirmasi
- Jika `tukar_jadwal`: tampilkan detail shift_swaps

### 8.7 Laporan & Arsip (`admin/reports`)
- Filter: bulan + tahun + karyawan
- Tabel: Karyawan | Total Jam | Total Tugas
- Tombol Export PDF / Excel (gunakan Laravel Excel atau DomPDF)
- Grafik Bar Chart (bisa dengan Chart.js CDN tambahan)

### 8.8 Manajemen Admin (`admin/admins`)
- Daftar semua user dengan role `admin`
- Tambah admin baru, edit, nonaktifkan
- Lihat `admin_logs`: log semua aksi admin

### 8.9 Pengaturan Profil (`admin/profile`)
- Edit nama, email, telepon
- Ganti password (validasi password lama)
- Upload foto profil (opsional)

---

## 9. FITUR KARYAWAN — LENGKAP

### 9.1 Beranda (`employee/home`)
- Tampilkan jadwal kerja HARI INI
- Query: `Schedule::where('employee_id', $empId)->where('work_date', today())->with('task')->get()`
- Card: jam mulai, jam selesai, nama tugas, status

### 9.2 Tugas Saya (`employee/tasks`)

**Implementasi Drag & Drop dengan Draggable.js (todo list style):**
```html
<!-- 3 kolom: Pending, In Progress, Done -->
<div class="row" id="kanban-board">
    <div class="col-md-4">
        <div class="kanban-col" data-status="pending" id="col-pending">
            <h5>📋 Pending</h5>
            @foreach($tasks->where('status','pending') as $task)
                <div class="task-card draggable" data-id="{{ $task->id }}" data-status="pending">
                    <strong>{{ $task->title }}</strong>
                    <small>Deadline: {{ $task->deadline->format('d M Y') }}</small>
                </div>
            @endforeach
        </div>
    </div>
    <!-- kolom in_progress & done sama -->
</div>
```

```javascript
// Draggable.js Setup
const containers = document.querySelectorAll('.kanban-col');
const draggable = new Draggable.Sortable(containers, {
    draggable: '.task-card',
});

draggable.on('drag:stop', (evt) => {
    const taskId = evt.data.source.dataset.id;
    const newStatus = evt.data.source.closest('.kanban-col').dataset.status;
    // AJAX update status
    fetch(`/employee/tasks/${taskId}/status`, {
        method: 'PATCH',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken},
        body: JSON.stringify({ status: newStatus })
    });
});
```

### 9.3 Jadwal Saya (`employee/schedule`)

**FullCalendar Setup:**
```javascript
const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
    initialView: 'dayGridMonth',
    locale: 'id',
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listMonth'
    },
    events: '/employee/schedule/events', // endpoint JSON
    eventColor: '#667eea',
    eventClick: function(info) {
        Swal.fire({
            title: info.event.title,
            html: `📅 ${info.event.startStr}<br>⏰ ${info.event.extendedProps.time}`,
            icon: 'info'
        });
    }
});
calendar.render();
```

**Endpoint `/employee/schedule/events` (JSON):**
```php
public function events() {
    $empId = auth()->user()->employee->id;
    $schedules = Schedule::where('employee_id', $empId)
                         ->with('task')
                         ->get()
                         ->map(fn($s) => [
                             'title' => $s->task?->title ?? 'Jadwal Kerja',
                             'start' => $s->work_date,
                             'extendedProps' => [
                                 'time' => "{$s->start_time} - {$s->end_time}",
                                 'status' => $s->status,
                             ]
                         ]);
    return response()->json($schedules);
}
```

### 9.4 Menu Pengajuan (`employee/requests`)
- **Form Cuti**: tanggal mulai, tanggal selesai, alasan
- **Form Tukar Jadwal**: pilih jadwal saya + pilih jadwal rekan + alasan
- Tabel riwayat pengajuan (status: pending/approved/rejected)

### 9.5 Profil (`employee/profile`)
- Edit nama, email, telepon, password

---

## 10. ROUTES

```php
// routes/web.php

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ADMIN ROUTES
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('employees', Admin\EmployeeController::class);
    Route::resource('specializations', Admin\SpecializationController::class);
    Route::resource('tasks', Admin\TaskController::class);
    Route::resource('assignments', Admin\AssignmentController::class);
    Route::resource('requests', Admin\RequestController::class);
    Route::resource('admins', Admin\AdminManagementController::class);

    // Scheduling (Greedy)
    Route::get('/scheduling', [Admin\SchedulingController::class, 'index'])->name('scheduling.index');
    Route::post('/scheduling/generate', [Admin\SchedulingController::class, 'generate'])->name('scheduling.generate');
    Route::put('/scheduling/rules', [Admin\SchedulingController::class, 'updateRules'])->name('scheduling.rules');
    Route::delete('/scheduling/{schedule}', [Admin\SchedulingController::class, 'destroy'])->name('scheduling.destroy');

    // Requests: approve/reject
    Route::patch('/requests/{request}/approve', [Admin\RequestController::class, 'approve'])->name('requests.approve');
    Route::patch('/requests/{request}/reject', [Admin\RequestController::class, 'reject'])->name('requests.reject');

    // Reports
    Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [Admin\ReportController::class, 'export'])->name('reports.export');

    // Profile
    Route::get('/profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [Admin\ProfileController::class, 'update'])->name('profile.update');
});

// EMPLOYEE ROUTES
Route::prefix('employee')->name('employee.')->middleware(['auth', 'employee'])->group(function () {
    Route::get('/home', [Employee\HomeController::class, 'index'])->name('home');

    Route::get('/tasks', [Employee\TaskController::class, 'index'])->name('tasks.index');
    Route::patch('/tasks/{task}/status', [Employee\TaskController::class, 'updateStatus'])->name('tasks.status');

    Route::get('/schedule', [Employee\ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/events', [Employee\ScheduleController::class, 'events'])->name('schedule.events');

    Route::get('/requests', [Employee\RequestController::class, 'index'])->name('requests.index');
    Route::post('/requests', [Employee\RequestController::class, 'store'])->name('requests.store');

    Route::get('/profile', [Employee\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [Employee\ProfileController::class, 'update'])->name('profile.update');
});

// Redirect root
Route::get('/', fn() => redirect()->route('login'));
```

---

## 11. CONTROLLER LIST

| Controller | Namespace | Fungsi Utama |
|-----------|-----------|--------------|
| `LoginController` | `Auth` | login, logout, redirect by role |
| `DashboardController` | `Admin` | stats cards, tabel tugas terbaru |
| `EmployeeController` | `Admin` | CRUD karyawan + spesialisasi |
| `SpecializationController` | `Admin` | CRUD spesialisasi |
| `TaskController` | `Admin` | CRUD tugas |
| `AssignmentController` | `Admin` | assign tugas ke karyawan |
| `SchedulingController` | `Admin` | tampilan jadwal + trigger greedy |
| `RequestController` | `Admin` | kelola pengajuan karyawan |
| `ReportController` | `Admin` | laporan rekap + export |
| `AdminManagementController` | `Admin` | kelola admin + log |
| `ProfileController` | `Admin` | edit profil admin |
| `HomeController` | `Employee` | beranda + jadwal hari ini |
| `TaskController` | `Employee` | kanban tugas + drag drop |
| `ScheduleController` | `Employee` | kalender FullCalendar |
| `RequestController` | `Employee` | form cuti & tukar jadwal |
| `ProfileController` | `Employee` | edit profil karyawan |

---

## 12. UI/UX DESIGN SYSTEM & CSS THEME

### Identitas Visual
```
Font Heading : Poppins (700/800)
Font Body    : Plus Jakarta Sans (400/500)
Tema         : Light clean dengan aksen biru-indigo + gradien soft
```

### CSS Variables — Tema Wajib (taruh di `<style>` dalam `layouts/admin.blade.php` & `layouts/employee.blade.php`)

> ⚠️ **WAJIB**: Seluruh tampilan harus menggunakan variabel CSS di bawah ini. Dilarang menggunakan warna hardcode (hex/rgb) di luar variabel ini kecuali untuk nilai `rgba()` transparan dari variabel yang sudah ada.

```css
:root {
  /* ===== PRIMARY COLORS ===== */
  --color-primary: #3B82F6;
  --color-primary-dark: #2563EB;
  --color-primary-light: #60A5FA;
  /* ===== SECONDARY COLORS ===== */
  --color-secondary: #6366F1;
  --color-accent: #93C5FD;
  /* ===== BACKGROUND ===== */
  --color-bg-main: #F5F7FB;
  --color-bg-card: #FFFFFF;
  --color-bg-sidebar: #F9FAFB;
  /* ===== TEXT ===== */
  --color-text-primary: #111827;
  --color-text-secondary: #6B7280;
  --color-text-muted: #9CA3AF;
  /* ===== BORDER ===== */
  --color-border: #E5E7EB;
  --color-divider: #D1D5DB;
  /* ===== STATUS ===== */
  --color-success: #22C55E;
  --color-warning: #F59E0B;
  --color-danger: #EF4444;
  /* ===== GRADIENT ===== */
  --gradient-primary: linear-gradient(135deg, #3B82F6, #6366F1);
  /* ===== UI ===== */
  --radius-lg: 20px;
  --radius-md: 16px;
  --radius-sm: 10px;
  --shadow-soft: 0 10px 25px rgba(0, 0, 0, 0.05);
}
```

### Panduan Penggunaan Variabel per Elemen

| Elemen | Variabel yang Digunakan |
|--------|------------------------|
| Background halaman | `--color-bg-main` |
| Background card / panel | `--color-bg-card` |
| Background sidebar | `--color-bg-sidebar` |
| Tombol utama (btn-primary) | `--color-primary` → hover: `--color-primary-dark` |
| Tombol secondary | `--color-secondary` |
| Teks heading/judul | `--color-text-primary` |
| Teks body/deskripsi | `--color-text-secondary` |
| Teks placeholder/label kecil | `--color-text-muted` |
| Border card, input, tabel | `--color-border` |
| Garis pemisah (hr, divider) | `--color-divider` |
| Badge / status sukses | `--color-success` |
| Badge / status warning | `--color-warning` |
| Badge / status error/hapus | `--color-danger` |
| Gradient header, banner, icon | `--gradient-primary` |
| Border radius card besar | `--radius-lg` |
| Border radius card sedang | `--radius-md` |
| Border radius badge/tombol | `--radius-sm` |
| Box shadow card | `--shadow-soft` |

### Contoh Penggunaan Variabel dalam CSS

```css
/* Card */
.card-custom {
    background: var(--color-bg-card);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-soft);
}

/* Tombol Primary */
.btn-primary-custom {
    background: var(--color-primary);
    color: #fff;
    border-radius: var(--radius-sm);
    transition: background 0.2s;
}
.btn-primary-custom:hover {
    background: var(--color-primary-dark);
}

/* Gradient Header */
.page-header {
    background: var(--gradient-primary);
    border-radius: var(--radius-lg);
    color: #fff;
}

/* Sidebar */
.sidebar {
    background: var(--color-bg-sidebar);
    border-right: 1px solid var(--color-border);
}

/* Link aktif sidebar */
.sidebar-link.active {
    background: rgba(59, 130, 246, 0.1); /* rgba dari --color-primary */
    color: var(--color-primary);
    border-left: 3px solid var(--color-primary);
}

/* Stat Card Icon */
.stat-icon {
    background: var(--gradient-primary);
    border-radius: var(--radius-sm);
    color: #fff;
}

/* Badge Status */
.badge-success { background: var(--color-success); color: #fff; border-radius: var(--radius-sm); }
.badge-warning { background: var(--color-warning); color: #fff; border-radius: var(--radius-sm); }
.badge-danger  { background: var(--color-danger);  color: #fff; border-radius: var(--radius-sm); }

/* Input/Form */
.form-control-custom {
    border: 1px solid var(--color-border);
    border-radius: var(--radius-sm);
    color: var(--color-text-primary);
    background: var(--color-bg-card);
}
.form-control-custom:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}

/* Tabel */
.table-custom th {
    background: var(--color-bg-main);
    color: var(--color-text-secondary);
    border-bottom: 2px solid var(--color-divider);
}
.table-custom td {
    border-bottom: 1px solid var(--color-border);
    color: var(--color-text-primary);
}
```

---

## 13. LAYOUT BLADE & ATURAN @stack / @push

### ⚠️ ATURAN WAJIB — @stack dan @push

> **Setiap layout WAJIB menyediakan `@stack`** untuk menampung style dan script tambahan dari child views.
> **Setiap halaman (child view) WAJIB menggunakan `@push`** untuk menyuntikkan style dan script spesifik halaman tersebut.
> **Dilarang** menaruh `<style>` atau `<script>` langsung di dalam body tanpa `@push`.

#### Slot yang WAJIB ada di setiap layout:

```
@stack('styles')   → diletakkan di dalam <head>, SETELAH semua CDN
@stack('scripts')  → diletakkan di akhir <body>, SETELAH semua CDN script
```

---

### Struktur Layout Admin (`resources/views/layouts/admin.blade.php`)

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ANDELIN AJA') — Admin</title>

    {{-- CDN: Bootstrap 5 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    {{-- CDN: Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    {{-- CDN: Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ===== CSS VARIABLES — TEMA ANDELIN AJA ===== */
        :root {
            --color-primary: #3B82F6;
            --color-primary-dark: #2563EB;
            --color-primary-light: #60A5FA;
            --color-secondary: #6366F1;
            --color-accent: #93C5FD;
            --color-bg-main: #F5F7FB;
            --color-bg-card: #FFFFFF;
            --color-bg-sidebar: #F9FAFB;
            --color-text-primary: #111827;
            --color-text-secondary: #6B7280;
            --color-text-muted: #9CA3AF;
            --color-border: #E5E7EB;
            --color-divider: #D1D5DB;
            --color-success: #22C55E;
            --color-warning: #F59E0B;
            --color-danger: #EF4444;
            --gradient-primary: linear-gradient(135deg, #3B82F6, #6366F1);
            --radius-lg: 20px;
            --radius-md: 16px;
            --radius-sm: 10px;
            --shadow-soft: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        /* ===== BASE STYLES ===== */
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        body { background: var(--color-bg-main); color: var(--color-text-primary); }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: var(--color-bg-sidebar);
            border-right: 1px solid var(--color-border);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            background: var(--gradient-primary);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .65rem 1.25rem;
            color: var(--color-text-secondary);
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.2s;
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        }
        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(59, 130, 246, 0.08);
            color: var(--color-primary);
            border-left-color: var(--color-primary);
        }
        .sidebar-link i { width: 18px; text-align: center; }

        /* ===== TOPBAR ===== */
        .topbar {
            height: 64px;
            background: var(--color-bg-card);
            border-bottom: 1px solid var(--color-border);
            box-shadow: var(--shadow-soft);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
        }

        /* ===== CONTENT ===== */
        .main-content {
            margin-left: 240px;
            padding: 1.5rem;
            min-height: 100vh;
        }

        /* ===== CARD ===== */
        .card-andelin {
            background: var(--color-bg-card);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-soft);
        }

        /* ===== STAT CARD ===== */
        .stat-card {
            background: var(--color-bg-card);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-soft);
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: var(--radius-sm);
            background: var(--gradient-primary);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.3rem;
            flex-shrink: 0;
        }
        .stat-number {
            font-family: 'Poppins', sans-serif;
            font-weight: 700; font-size: 1.75rem;
            color: var(--color-text-primary);
            margin: 0;
        }
        .stat-label {
            color: var(--color-text-muted);
            font-size: .85rem;
            margin: 0;
        }

        /* ===== BADGE STATUS ===== */
        .badge-pending    { background: var(--color-warning); color: #fff; border-radius: var(--radius-sm); padding: 4px 10px; font-size: .75rem; }
        .badge-inprogress { background: var(--color-primary); color: #fff; border-radius: var(--radius-sm); padding: 4px 10px; font-size: .75rem; }
        .badge-done       { background: var(--color-success); color: #fff; border-radius: var(--radius-sm); padding: 4px 10px; font-size: .75rem; }
        .badge-danger-c   { background: var(--color-danger);  color: #fff; border-radius: var(--radius-sm); padding: 4px 10px; font-size: .75rem; }

        /* ===== BUTTON ===== */
        .btn-andelin-primary {
            background: var(--color-primary);
            color: #fff; border: none;
            border-radius: var(--radius-sm);
            padding: .5rem 1.25rem;
            font-weight: 500;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-andelin-primary:hover {
            background: var(--color-primary-dark);
            color: #fff;
            transform: translateY(-1px);
        }
        .btn-andelin-danger {
            background: var(--color-danger);
            color: #fff; border: none;
            border-radius: var(--radius-sm);
        }

        /* ===== TABLE ===== */
        .table-andelin th {
            background: var(--color-bg-main);
            color: var(--color-text-secondary);
            font-size: .8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            border-bottom: 2px solid var(--color-divider);
        }
        .table-andelin td {
            border-bottom: 1px solid var(--color-border);
            color: var(--color-text-primary);
            vertical-align: middle;
        }

        /* ===== FORM ===== */
        .form-control, .form-select {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            color: var(--color-text-primary);
            background: var(--color-bg-card);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        .form-label {
            font-weight: 500;
            color: var(--color-text-secondary);
            font-size: .875rem;
        }
    </style>

    {{-- ════════════════════════════════════════════
         @stack('styles') — SLOT UNTUK STYLE HALAMAN
         Setiap child view taruh style spesifik di sini
         via @push('styles') ... @endpush
         ════════════════════════════════════════════ --}}
    @stack('styles')
</head>
<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-calendar-check me-2"></i> ANDELIN AJA
        </div>
        <nav class="py-3 grow">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('admin.employees.index') }}" class="sidebar-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Karyawan
            </a>
            <a href="{{ route('admin.specializations.index') }}" class="sidebar-link {{ request()->routeIs('admin.specializations.*') ? 'active' : '' }}">
                <i class="fas fa-star"></i> Spesialisasi
            </a>
            <a href="{{ route('admin.tasks.index') }}" class="sidebar-link {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Tugas
            </a>
            <a href="{{ route('admin.assignments.index') }}" class="sidebar-link {{ request()->routeIs('admin.assignments.*') ? 'active' : '' }}">
                <i class="fas fa-link"></i> Penugasan
            </a>
            <a href="{{ route('admin.scheduling.index') }}" class="sidebar-link {{ request()->routeIs('admin.scheduling.*') ? 'active' : '' }}">
                <i class="fas fa-robot"></i> Penjadwalan
            </a>
            <a href="{{ route('admin.requests.index') }}" class="sidebar-link {{ request()->routeIs('admin.requests.*') ? 'active' : '' }}">
                <i class="fas fa-paper-plane"></i> Pengajuan
            </a>
            <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Laporan
            </a>
            <a href="{{ route('admin.admins.index') }}" class="sidebar-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i> Manajemen Admin
            </a>
        </nav>
        <div class="p-3 border-top" style="border-color: var(--color-border) !important;">
            <a href="{{ route('admin.profile.edit') }}" class="sidebar-link">
                <i class="fas fa-cog"></i> Profil Saya
            </a>
        </div>
    </aside>

    {{-- TOPBAR + KONTEN UTAMA --}}
    <div class="main-content">
        <div class="topbar mb-4 rounded-3">
            <h6 class="mb-0 fw-600" style="color: var(--color-text-primary);">
                @yield('page-title', 'Dashboard')
            </h6>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span style="color: var(--color-text-secondary); font-size: .875rem;">
                    <i class="fas fa-user-circle me-1"></i>
                    {{ auth()->user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-sm" style="color: var(--color-danger); border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        {{-- SESSION FLASH (SweetAlert ditangani di @stack scripts) --}}
        @yield('content')
    </div>

    {{-- CDN Scripts (wajib sebelum @stack scripts) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Flash Message Global via SweetAlert --}}
    @if(session('success'))
    <script>
        Swal.fire({ toast: true, position: 'top-end', icon: 'success',
            title: '{{ session('success') }}', showConfirmButton: false,
            timer: 3000, timerProgressBar: true });
    </script>
    @endif
    @if(session('error'))
    <script>
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}' });
    </script>
    @endif

    {{-- ════════════════════════════════════════════════
         @stack('scripts') — SLOT UNTUK SCRIPT HALAMAN
         Setiap child view taruh script spesifik di sini
         via @push('scripts') ... @endpush
         ════════════════════════════════════════════════ --}}
    @stack('scripts')
</body>
</html>
```

---

### Struktur Layout Karyawan (`resources/views/layouts/employee.blade.php`)

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ANDELIN AJA') — Karyawan</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ===== CSS VARIABLES — SAMA DENGAN ADMIN LAYOUT ===== */
        :root {
            --color-primary: #3B82F6;
            --color-primary-dark: #2563EB;
            --color-primary-light: #60A5FA;
            --color-secondary: #6366F1;
            --color-accent: #93C5FD;
            --color-bg-main: #F5F7FB;
            --color-bg-card: #FFFFFF;
            --color-bg-sidebar: #F9FAFB;
            --color-text-primary: #111827;
            --color-text-secondary: #6B7280;
            --color-text-muted: #9CA3AF;
            --color-border: #E5E7EB;
            --color-divider: #D1D5DB;
            --color-success: #22C55E;
            --color-warning: #F59E0B;
            --color-danger: #EF4444;
            --gradient-primary: linear-gradient(135deg, #3B82F6, #6366F1);
            --radius-lg: 20px;
            --radius-md: 16px;
            --radius-sm: 10px;
            --shadow-soft: 0 10px 25px rgba(0, 0, 0, 0.05);
        }
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        body { background: var(--color-bg-main); color: var(--color-text-primary); }

        /* ... (sama seperti admin: sidebar, topbar, card, tabel, form) ... */
    </style>

    @stack('styles')
    {{-- ↑ WAJIB ADA: slot untuk style spesifik tiap halaman karyawan --}}
</head>
<body>
    {{-- Sidebar Karyawan --}}
    <aside class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-calendar-check me-2"></i> ANDELIN AJA
        </div>
        <nav class="py-3 grow">
            <a href="{{ route('employee.home') }}" class="sidebar-link {{ request()->routeIs('employee.home') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Beranda
            </a>
            <a href="{{ route('employee.tasks.index') }}" class="sidebar-link {{ request()->routeIs('employee.tasks.*') ? 'active' : '' }}">
                <i class="fas fa-check-square"></i> Tugas Saya
            </a>
            <a href="{{ route('employee.schedule.index') }}" class="sidebar-link {{ request()->routeIs('employee.schedule.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Jadwal Saya
            </a>
            <a href="{{ route('employee.requests.index') }}" class="sidebar-link {{ request()->routeIs('employee.requests.*') ? 'active' : '' }}">
                <i class="fas fa-paper-plane"></i> Pengajuan
            </a>
        </nav>
        <div class="p-3 border-top" style="border-color: var(--color-border) !important;">
            <a href="{{ route('employee.profile.edit') }}" class="sidebar-link">
                <i class="fas fa-cog"></i> Profil Saya
            </a>
        </div>
    </aside>

    <div class="main-content">
        <div class="topbar mb-4 rounded-3">
            <h6 class="mb-0">@yield('page-title', 'Beranda')</h6>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span style="color: var(--color-text-secondary); font-size: .875rem;">
                    <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-sm" style="color: var(--color-danger); border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        Swal.fire({ toast: true, position: 'top-end', icon: 'success',
            title: '{{ session('success') }}', showConfirmButton: false,
            timer: 3000, timerProgressBar: true });
    </script>
    @endif
    @if(session('error'))
    <script>
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}' });
    </script>
    @endif

    @stack('scripts')
    {{-- ↑ WAJIB ADA: slot untuk script spesifik tiap halaman karyawan --}}
</body>
</html>
```

---

### Aturan @push pada Child Views

> **WAJIB diikuti di SEMUA file blade halaman (child view):**

#### Template Child View yang Benar

```blade
{{-- resources/views/admin/[module]/[halaman].blade.php --}}

@extends('layouts.admin')

@section('title', 'Judul Halaman')
@section('page-title', 'Judul Halaman')

{{-- ✅ BENAR: Style spesifik halaman ini --}}
@push('styles')
<style>
    /* Hanya style yang UNIK untuk halaman ini, bukan global */
    .kanban-col { min-height: 300px; background: var(--color-bg-main); border-radius: var(--radius-md); }
</style>
{{-- CDN yang hanya diperlukan halaman ini, contoh FullCalendar --}}
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
@endpush

@section('content')
    {{-- konten halaman --}}
@endsection

{{-- ✅ BENAR: Script spesifik halaman ini --}}
@push('scripts')
{{-- CDN yang hanya diperlukan halaman ini --}}
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
    // Logika JavaScript khusus halaman ini
    document.addEventListener('DOMContentLoaded', function () {
        // ...
    });
</script>
@endpush
```

#### Yang DILARANG

```blade
{{-- ❌ SALAH: Menaruh <style> langsung di @section('content') --}}
@section('content')
<style>
    .something { color: red; } /* ← DILARANG */
</style>
<div>...</div>
@endsection

{{-- ❌ SALAH: Menaruh <script> langsung di @section('content') --}}
@section('content')
<div>...</div>
<script>
    console.log('hello'); /* ← DILARANG */
</script>
@endsection

{{-- ❌ SALAH: Menggunakan warna hardcode, bukan variabel --}}
<div style="background: #3B82F6;">...</div> /* ← DILARANG */
{{-- ✅ BENAR --}}
<div style="background: var(--color-primary);">...</div>
```

---

### Halaman yang Menggunakan CDN Tambahan via @push

| Halaman | CDN Tambahan | Taruh di |
|---------|-------------|----------|
| `employee/schedule/index.blade.php` | FullCalendar CSS + JS + locale id | `@push('styles')` & `@push('scripts')` |
| `employee/tasks/index.blade.php` | Draggable.js | `@push('scripts')` |
| `admin/scheduling/index.blade.php` | — (jQuery/Axios untuk AJAX generate) | `@push('scripts')` |
| `admin/reports/index.blade.php` | Chart.js (opsional) | `@push('scripts')` |

#### Contoh konkret untuk halaman Jadwal Karyawan:

```blade
{{-- resources/views/employee/schedule/index.blade.php --}}

@extends('layouts.employee')

@section('title', 'Jadwal Saya')
@section('page-title', 'Jadwal Saya')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<style>
    #calendar {
        background: var(--color-bg-card);
        border-radius: var(--radius-md);
        padding: 1rem;
        box-shadow: var(--shadow-soft);
        border: 1px solid var(--color-border);
    }
    .fc-button-primary {
        background: var(--color-primary) !important;
        border-color: var(--color-primary-dark) !important;
        border-radius: var(--radius-sm) !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div id="calendar"></div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/id.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth'
            },
            events: '{{ route('employee.schedule.events') }}',
            eventColor: 'var(--color-primary)',
            eventClick: function (info) {
                Swal.fire({
                    title: info.event.title,
                    html: `📅 ${info.event.startStr}<br>⏰ ${info.event.extendedProps.time}`,
                    icon: 'info',
                    confirmButtonColor: 'var(--color-primary)'
                });
            }
        });
        calendar.render();
    });
</script>
@endpush
```

#### Contoh konkret untuk halaman Penjadwalan Greedy (Admin):

```blade
{{-- resources/views/admin/scheduling/index.blade.php --}}

@extends('layouts.admin')

@section('title', 'Penjadwalan Greedy')
@section('page-title', '<i class="fas fa-robot me-2"></i> Penjadwalan Otomatis (Greedy)')

@push('styles')
<style>
    .greedy-result-item {
        padding: .5rem 1rem;
        border-left: 3px solid var(--color-primary);
        background: rgba(59, 130, 246, 0.05);
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        margin-bottom: .5rem;
        font-size: .875rem;
        color: var(--color-text-secondary);
    }
    .rules-card {
        background: var(--color-bg-card);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-soft);
        padding: 1.5rem;
    }
</style>
@endpush

@section('content')
    {{-- Konten halaman scheduling --}}
@endsection

@push('scripts')
<script>
    document.getElementById('btn-generate').addEventListener('click', function () {
        Swal.fire({
            title: 'Generate Jadwal Otomatis?',
            text: 'Sistem akan menjalankan Algoritma Greedy.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: 'var(--color-primary)',
            cancelButtonColor: 'var(--color-text-muted)',
            confirmButtonText: 'Ya, Generate!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Algoritma Greedy sedang berjalan...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                fetch('{{ route('admin.scheduling.generate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(r => r.json())
                .then(data => {
                    Swal.fire({
                        title: 'Selesai!',
                        html: `✅ <b>${data.scheduled}</b> tugas berhasil dijadwalkan<br>⚠️ <b>${data.skipped}</b> tugas dilewati`,
                        icon: 'success',
                        confirmButtonColor: 'var(--color-primary)'
                    }).then(() => location.reload());
                });
            }
        });
    });
</script>
@endpush
```

---

### Komponen Umum

**Card Stat:**
```html
<div class="stat-card">
    <div class="stat-icon bg-primary">
        <i class="fas fa-users"></i>
    </div>
    <div class="stat-body">
        <h2 class="stat-number">{{ $totalKaryawan }}</h2>
        <p class="stat-label">Total Karyawan</p>
    </div>
</div>
```

**Badge Status Tugas:**
```php
// Helper / Blade directive
@switch($task->status)
    @case('pending')   <span class="badge bg-warning">Tertunda</span> @break
    @case('in_progress') <span class="badge bg-info">Berjalan</span> @break
    @case('done')      <span class="badge bg-success">Selesai</span> @break
@endswitch
```

**Badge Generated By:**
```html
<span class="badge bg-{{ $schedule->generated_by === 'greedy' ? 'success' : 'secondary' }}">
    <i class="fas fa-{{ $schedule->generated_by === 'greedy' ? 'robot' : 'hand-paper' }}"></i>
    {{ ucfirst($schedule->generated_by) }}
</span>
```

---

## 14. SWEETALERT — POLA PENGGUNAAN

### Konfirmasi Hapus
```javascript
function confirmDelete(formId) {
    Swal.fire({
        title: 'Hapus Data?',
        text: 'Data yang dihapus tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',  /* --color-danger */
        cancelButtonColor: '#9CA3AF',  /* --color-text-muted */
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) document.getElementById(formId).submit();
    });
}
```

### Notifikasi Sukses (dari Session)
```blade
@if(session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({ icon: 'error', title: 'Oops!', text: '{{ session('error') }}' });
</script>
@endif
```

### Konfirmasi Approve/Reject Pengajuan
```javascript
function confirmApprove(id) {
    Swal.fire({
        title: 'Setujui Pengajuan?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '✅ Setujui',
        cancelButtonText: 'Batal'
    }).then(r => {
        if (r.isConfirmed) document.getElementById('form-approve-' + id).submit();
    });
}
```

### Loading saat Generate Greedy
```javascript
Swal.fire({
    title: 'Memproses...',
    html: 'Algoritma Greedy sedang berjalan...',
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading()
});
```

---

## 15. VALIDASI & RULES

### Tambah Karyawan
```php
$request->validate([
    'name'               => 'required|string|max:100',
    'email'              => 'required|email|unique:users,email',
    'password'           => 'required|min:8|confirmed',
    'phone'              => 'nullable|string|max:20',
    'position'           => 'required|in:pengawas_1,pengawas_2,senior_team,junior_team',
    'specializations'    => 'nullable|array',
    'specializations.*'  => 'exists:specializations,id',
]);
```

### Tambah Tugas
```php
$request->validate([
    'title'       => 'required|string|max:200',
    'description' => 'nullable|string',
    'deadline'    => 'required|date|after_or_equal:today',
]);
```

### Pengajuan Karyawan
```php
$request->validate([
    'type'        => 'required|in:cuti,tukar_jadwal',
    'description' => 'required|string|max:500',
    // Jika tukar jadwal:
    'from_schedule_id' => 'required_if:type,tukar_jadwal|exists:schedules,id',
    'to_employee_id'   => 'required_if:type,tukar_jadwal|exists:employees,id',
]);
```

### Aturan Penjadwalan
```php
$request->validate([
    'max_hours_per_week' => 'required|integer|min:1|max:168',
    'max_tasks_per_day'  => 'required|integer|min:1|max:24',
]);
```

---

## 16. SEEDER & FACTORY

### DatabaseSeeder.php
```php
public function run(): void {
    // 1. Admin default
    User::create([
        'name'     => 'Super Admin',
        'email'    => 'admin@andelin.com',
        'password' => bcrypt('password'),
        'role'     => 'admin',
    ]);

    // 2. Spesialisasi
    $specs = ['Konstruksi', 'Elektrikal', 'Plumbing', 'Finishing', 'Pengawasan'];
    foreach ($specs as $s) Specialization::create(['name' => $s]);

    // 3. Scheduling rules default
    SchedulingRule::create([
        'max_hours_per_week' => 40,
        'max_tasks_per_day'  => 3,
    ]);

    // 4. Karyawan sample (gunakan EmployeeSeeder)
    $this->call([EmployeeSeeder::class]);
}
```

### EmployeeSeeder.php (contoh)
```php
// Buat 10 karyawan contoh dengan availability & spesialisasi acak
for ($i = 1; $i <= 10; $i++) {
    $user = User::create([
        'name'     => "Karyawan $i",
        'email'    => "karyawan$i@andelin.com",
        'password' => bcrypt('password'),
        'role'     => 'karyawan',
    ]);

    $employee = Employee::create([
        'user_id'  => $user->id,
        'position' => ['pengawas_1','pengawas_2','senior_team','junior_team'][rand(0,3)],
    ]);

    // Assign 1-3 spesialisasi acak
    $specIds = Specialization::inRandomOrder()->take(rand(1,3))->pluck('id');
    $employee->specializations()->attach($specIds);

    // Availability: Senin-Jumat, 08:00-17:00
    for ($day = 1; $day <= 5; $day++) {
        EmployeeAvailability::create([
            'employee_id' => $employee->id,
            'day_of_week' => $day,
            'start_time'  => '08:00',
            'end_time'    => '17:00',
        ]);
    }
}
```

---

## 🔑 KREDENSIAL DEFAULT

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@andelin.com | password |
| Karyawan | karyawan1@andelin.com | password |

---

## ⚡ QUICK START COMMANDS

```bash
# Install Laravel 12
composer create-project laravel/laravel andelin-aja

# Masuk ke folder
cd andelin-aja

# Setup .env (isi DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# Buat database
php artisan migrate

# Jalankan seeder
php artisan db:seed

# Serve
php artisan serve
```

---

## 📌 CATATAN PENTING

1. **Greedy bukan optimal global** — Greedy memilih solusi terbaik lokal di setiap langkah. Hasilnya baik dan cepat, namun mungkin bukan yang paling optimal secara global. Ini adalah tradeoff yang disengaja untuk performa.

2. **Spesialisasi Task** — Pada implementasi ini, task tidak punya field spesialisasi khusus. Jika ingin menambahkan matching spesialisasi, tambahkan kolom `specialization_id` (nullable) di tabel `tasks` dan filter karyawan berdasarkan kecocokan spesialisasi di `GreedySchedulerService::getCandidates()`.

3. **Drag & Drop Task** — Status task yang diubah via drag-drop di halaman karyawan harus divalidasi di backend (karyawan hanya bisa ubah tugas miliknya sendiri).

4. **FullCalendar Locale** — Pastikan import locale Indonesia: `locale: 'id'` dan tambahkan `<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/id.global.min.js"></script>`.

5. **CSRF pada AJAX** — Selalu sertakan `X-CSRF-TOKEN` di header AJAX atau gunakan `@csrf` di form Blade.

6. **Admin Logs** — Setiap aksi penting admin (tambah/hapus karyawan, generate greedy, approve request) wajib dicatat di `admin_logs`.

---

*Dokumen ini adalah panduan lengkap pengembangan ANDELIN AJA. Mulai dengan setup database, buat migration secara berurutan, implementasikan GreedySchedulerService, lalu bangun UI layer per layer.*
