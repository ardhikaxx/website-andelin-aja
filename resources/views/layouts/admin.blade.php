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
            --shadow-card: 0 18px 40px rgba(37, 99, 235, 0.08);
        }
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        body {
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.10), transparent 28%),
                linear-gradient(180deg, #F8FAFF 0%, var(--color-bg-main) 32%);
            color: var(--color-text-primary);
        }
        a { text-decoration: none; }
        .sidebar {
            width: 252px;
            min-height: 100vh;
            background: rgba(249, 250, 251, 0.96);
            backdrop-filter: blur(18px);
            border-right: 1px solid rgba(229, 231, 235, 0.95);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 16px 0 40px rgba(15, 23, 42, 0.04);
            z-index: 100;
        }
        .sidebar-brand {
            padding: 1.5rem 1.35rem;
            background: var(--gradient-primary);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: .01em;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: .2rem .8rem;
            padding: .78rem 1rem;
            color: var(--color-text-secondary);
            border: 1px solid transparent;
            transition: all .2s ease;
            border-radius: 14px;
        }
        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(59, 130, 246, 0.08);
            color: var(--color-primary);
            border-color: rgba(147, 197, 253, 0.6);
            transform: translateX(2px);
        }
        .sidebar-link i { width: 18px; text-align: center; }
        .topbar {
            min-height: 70px;
            background: rgba(255, 255, 255, 0.86);
            border: 1px solid rgba(229, 231, 235, 0.9);
            box-shadow: var(--shadow-soft);
            display: flex;
            align-items: center;
            padding: .9rem 1.25rem;
            backdrop-filter: blur(16px);
        }
        .topbar-title {
            color: var(--color-text-primary);
            font-weight: 700;
            letter-spacing: -.01em;
        }
        .main-content {
            margin-left: 252px;
            padding: 1.75rem;
            min-height: 100vh;
        }
        .user-chip {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .55rem .9rem;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.08);
            color: var(--color-primary);
            font-size: .85rem;
            font-weight: 600;
        }
        .logout-button {
            border-radius: 999px !important;
            padding: .5rem .9rem;
            background: var(--color-bg-card);
        }
        .card-andelin {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(229, 231, 235, 0.95);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.97);
            border: 1px solid rgba(229, 231, 235, 0.95);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 1.35rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            min-height: 124px;
        }
        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.3rem;
            flex-shrink: 0;
            box-shadow: 0 12px 24px rgba(59, 130, 246, 0.28);
        }
        .stat-number {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.85rem;
            margin: 0;
            letter-spacing: -.02em;
        }
        .stat-label {
            color: var(--color-text-muted);
            font-size: .88rem;
            margin: 0;
        }
        .table-responsive {
            border: 1px solid rgba(229, 231, 235, 0.9);
            border-radius: 18px;
            overflow: hidden;
            background: var(--color-bg-card);
        }
        .table-andelin {
            margin-bottom: 0;
        }
        .table-andelin th {
            background: #F8FAFC;
            color: var(--color-text-secondary);
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            border-bottom: 1px solid rgba(209, 213, 219, 0.9);
            padding: 1rem 1.1rem;
            white-space: nowrap;
        }
        .table-andelin td {
            border-bottom: 1px solid rgba(229, 231, 235, 0.75);
            color: var(--color-text-primary);
            vertical-align: middle;
            padding: 1rem 1.1rem;
        }
        .table-andelin tbody tr:hover {
            background: rgba(59, 130, 246, 0.04);
        }
        .table-andelin tbody tr:last-child td {
            border-bottom: none;
        }
        .form-control,
        .form-select {
            min-height: 46px;
            border: 1px solid rgba(209, 213, 219, 0.95);
            border-radius: 14px;
            color: var(--color-text-primary);
            background: #fff;
            padding: .7rem .95rem;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.14);
        }
        textarea.form-control {
            min-height: 120px;
        }
        .form-label {
            font-weight: 600;
            color: var(--color-text-secondary);
            font-size: .86rem;
            margin-bottom: .45rem;
        }
        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: .62rem 1rem;
            box-shadow: none;
        }
        .btn-sm {
            padding: .45rem .75rem;
            border-radius: 10px;
        }
        .btn-primary,
        .btn-andelin-primary {
            background: var(--gradient-primary);
            border: none;
            color: #fff;
            box-shadow: 0 12px 22px rgba(59, 130, 246, 0.24);
        }
        .btn-primary:hover,
        .btn-andelin-primary:hover {
            color: #fff;
            transform: translateY(-1px);
        }
        .btn-success {
            background: linear-gradient(135deg, #22C55E, #16A34A);
            border: none;
            color: #fff;
        }
        .btn-info {
            background: linear-gradient(135deg, #0EA5E9, #2563EB);
            border: none;
            color: #fff;
        }
        .btn-light {
            background: #fff;
            color: var(--color-text-secondary);
            border: 1px solid rgba(209, 213, 219, 0.95);
        }
        .btn-outline-primary,
        .btn-outline-secondary,
        .btn-outline-danger,
        .btn-outline-success {
            background: #fff;
        }
        .btn-outline-primary:hover,
        .btn-outline-secondary:hover,
        .btn-outline-danger:hover,
        .btn-outline-success:hover {
            transform: translateY(-1px);
        }
        .badge,
        .badge-soft {
            border-radius: 999px;
            padding: .45rem .72rem;
            font-size: .74rem;
            font-weight: 700;
        }
        .pagination-wrap {
            display: flex;
            justify-content: flex-end;
            margin-top: 1.25rem;
        }
        .pagination {
            gap: .45rem;
            margin-bottom: 0;
        }
        .page-item .page-link {
            min-width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px !important;
            border: 1px solid rgba(209, 213, 219, 0.95);
            color: var(--color-text-secondary);
            background: #fff;
            font-weight: 600;
            box-shadow: 0 8px 16px rgba(15, 23, 42, 0.04);
        }
        .page-item.active .page-link {
            color: #fff;
            background: var(--gradient-primary);
            border-color: transparent;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.24);
        }
        .page-item.disabled .page-link {
            background: #F8FAFC;
            color: var(--color-text-muted);
            box-shadow: none;
        }
        .page-link:hover {
            color: var(--color-primary);
            border-color: rgba(96, 165, 250, 0.95);
            background: rgba(59, 130, 246, 0.04);
        }
        .swal2-popup {
            border-radius: 20px !important;
        }
        .empty-state {
            padding: 2rem 1rem;
            color: var(--color-text-muted);
            text-align: center;
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
                padding: 1rem;
            }
            .topbar {
                padding: 1rem;
            }
            .pagination-wrap {
                justify-content: center;
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
        <div class="topbar mb-4 rounded-4">
            <h6 class="mb-0 topbar-title">@yield('page-title', 'Dashboard')</h6>
            <div class="ms-auto d-flex align-items-center gap-3 flex-wrap">
                <span class="user-chip">
                    <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="m-0 logout-form">
                    @csrf
                    <button class="btn btn-sm logout-button" style="color: var(--color-danger); border: 1px solid var(--color-border);">
                        <i class="fas fa-sign-out-alt me-1"></i> Keluar
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

    <script>
        document.querySelectorAll('.logout-form').forEach((form) => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Keluar dari akun?',
                    text: 'Sesi login Anda akan diakhiri.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#9CA3AF',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>