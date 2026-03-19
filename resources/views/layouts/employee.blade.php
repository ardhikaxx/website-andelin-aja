<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ANDELIN AJA') - Karyawan</title>

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
        .form-control,
        .form-select {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
        }
        .form-control:focus,
        .form-select:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
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
