<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ANDELIN AJA') - Admin</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
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
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: var(--color-bg-sidebar);
            border-right: 1px solid var(--color-border);
            position: fixed;
            top: 0;
            left: 0;
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
            transition: all .2s;
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        }
        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(59, 130, 246, 0.08);
            color: var(--color-primary);
            border-left-color: var(--color-primary);
        }
        .sidebar-link i { width: 18px; text-align: center; }
        .topbar {
            height: 64px;
            background: var(--color-bg-card);
            border-bottom: 1px solid var(--color-border);
            box-shadow: var(--shadow-soft);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
        }
        .main-content {
            margin-left: 240px;
            padding: 1.5rem;
            min-height: 100vh;
        }
        .card-andelin {
            background: var(--color-bg-card);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-soft);
        }
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
            width: 52px;
            height: 52px;
            border-radius: var(--radius-sm);
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.3rem;
            flex-shrink: 0;
        }
        .stat-number {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.75rem;
            margin: 0;
        }
        .stat-label {
            color: var(--color-text-muted);
            font-size: .85rem;
            margin: 0;
        }
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
        .form-control,
        .form-select {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            color: var(--color-text-primary);
            background: var(--color-bg-card);
        }
        .form-control:focus,
        .form-select:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        .form-label {
            font-weight: 500;
            color: var(--color-text-secondary);
            font-size: .875rem;
        }
        .btn-andelin-primary {
            background: var(--color-primary);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: .5rem 1.25rem;
            font-weight: 500;
        }
        .btn-andelin-primary:hover {
            background: var(--color-primary-dark);
            color: #fff;
        }
        .badge-soft {
            border-radius: var(--radius-sm);
            padding: .35rem .65rem;
            font-size: .75rem;
            color: #fff;
        }
        .grow { flex: 1; }
        @media (max-width: 991.98px) {
            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
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

    <div class="main-content">
        <div class="topbar mb-4 rounded-3">
            <h6 class="mb-0" style="color: var(--color-text-primary);">@yield('page-title', 'Dashboard')</h6>
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
        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: '{{ session('success') }}', showConfirmButton: false, timer: 3000, timerProgressBar: true });
    </script>
    @endif
    @if(session('error'))
    <script>
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}' });
    </script>
    @endif

    @stack('scripts')
</body>
</html>
