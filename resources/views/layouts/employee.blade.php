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
            width: 278px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            padding: 18px;
            background: linear-gradient(180deg, rgba(248, 250, 255, 0.97), rgba(245, 247, 251, 0.97));
            border-right: 1px solid rgba(229, 231, 235, 0.9);
            box-shadow: 18px 0 50px rgba(15, 23, 42, 0.05);
            backdrop-filter: blur(18px);
        }
        .sidebar-shell {
            height: calc(100vh - 36px);
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(229, 231, 235, 0.95);
            border-radius: 28px;
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.08);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .sidebar-brand {
            position: relative;
            padding: 1.5rem;
            background: var(--gradient-primary);
            color: #fff;
            overflow: hidden;
        }
        .sidebar-brand::after {
            content: '';
            position: absolute;
            top: -38px;
            right: -24px;
            width: 118px;
            height: 118px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.16);
        }
        .brand-row {
            display: flex;
            align-items: center;
            gap: .95rem;
            position: relative;
            z-index: 1;
        }
        .brand-mark {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.22);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.22);
            font-size: 1.15rem;
        }
        .brand-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.08rem;
            font-weight: 700;
            letter-spacing: .02em;
            margin: 0;
        }
        .brand-subtitle {
            margin: .2rem 0 0;
            font-size: .78rem;
            color: rgba(255, 255, 255, 0.85);
        }
        .sidebar-nav {
            padding: 1.15rem .95rem 0;
            display: flex;
            flex-direction: column;
            flex: 1;
            min-height: 0;
        }
        .sidebar-section-label {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--color-text-muted);
            padding: 0 .55rem .65rem;
        }
        .sidebar-links {
            display: flex;
            flex-direction: column;
            gap: .45rem;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: .85rem .95rem;
            color: var(--color-text-secondary);
            border: 1px solid transparent;
            border-radius: 18px;
            transition: all .2s ease;
        }
        .sidebar-link:hover {
            color: var(--color-primary);
            background: rgba(59, 130, 246, 0.06);
            border-color: rgba(147, 197, 253, 0.55);
            transform: translateX(2px);
        }
        .sidebar-link.active {
            color: var(--color-primary);
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.14), rgba(99, 102, 241, 0.08));
            border-color: rgba(96, 165, 250, 0.45);
            box-shadow: 0 14px 24px rgba(59, 130, 246, 0.10);
        }
        .sidebar-link.active .sidebar-icon {
            background: var(--gradient-primary);
            color: #fff;
            box-shadow: 0 10px 18px rgba(59, 130, 246, 0.24);
        }
        .sidebar-icon {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: rgba(59, 130, 246, 0.08);
            color: var(--color-primary);
            flex-shrink: 0;
            transition: all .2s ease;
        }
        .sidebar-text {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .sidebar-title {
            font-weight: 700;
            font-size: .93rem;
            color: inherit;
        }
        .sidebar-note {
            font-size: .75rem;
            color: var(--color-text-muted);
            margin-top: .1rem;
        }
        .sidebar-arrow {
            margin-left: auto;
            color: var(--color-text-muted);
            font-size: .76rem;
            transition: transform .2s ease;
        }
        .sidebar-link:hover .sidebar-arrow,
        .sidebar-link.active .sidebar-arrow {
            color: var(--color-primary);
            transform: translateX(2px);
        }
        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(229, 231, 235, 0.95);
            background: linear-gradient(180deg, rgba(248, 250, 255, 0.65), rgba(255, 255, 255, 0.96));
        }
        .sidebar-profile {
            padding: 1rem;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.08), rgba(99, 102, 241, 0.05));
            border: 1px solid rgba(147, 197, 253, 0.5);
        }
        .sidebar-profile-top {
            display: flex;
            align-items: center;
            gap: .85rem;
            margin-bottom: .85rem;
        }
        .sidebar-avatar {
            width: 44px;
            height: 44px;
            border-radius: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--gradient-primary);
            color: #fff;
            box-shadow: 0 12px 22px rgba(59, 130, 246, 0.24);
            flex-shrink: 0;
        }
        .sidebar-profile-name {
            font-weight: 700;
            font-size: .92rem;
            color: var(--color-text-primary);
            margin: 0;
        }
        .sidebar-profile-role {
            color: var(--color-text-muted);
            font-size: .76rem;
            margin: .15rem 0 0;
            text-transform: uppercase;
            letter-spacing: .08em;
        }
        .sidebar-profile-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            width: 100%;
            padding: .8rem 1rem;
            border-radius: 14px;
            background: #fff;
            border: 1px solid rgba(209, 213, 219, 0.9);
            color: var(--color-text-secondary);
            font-weight: 700;
            transition: all .2s ease;
        }
        .sidebar-profile-link:hover {
            color: var(--color-primary);
            border-color: rgba(96, 165, 250, 0.7);
            background: rgba(255, 255, 255, 0.96);
        }
        .topbar {
            min-height: 74px;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(229, 231, 235, 0.9);
            box-shadow: var(--shadow-soft);
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            backdrop-filter: blur(16px);
        }
        .main-content {
            margin-left: 278px;
            padding: 1.8rem;
            min-height: 100vh;
        }
        .user-chip {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .6rem .95rem;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.08);
            color: var(--color-primary);
            font-size: .85rem;
            font-weight: 700;
        }
        .logout-button {
            border-radius: 999px !important;
            padding: .55rem .95rem;
            background: var(--color-bg-card);
        }
        .card-andelin {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(229, 231, 235, 0.95);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            overflow: hidden;
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
        .btn {
            border-radius: 12px;
            font-weight: 700;
            padding: .62rem 1rem;
            box-shadow: none;
        }
        .btn-sm {
            padding: .45rem .75rem;
            border-radius: 10px;
        }
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            color: #fff;
            box-shadow: 0 12px 22px rgba(59, 130, 246, 0.24);
        }
        .btn-primary:hover {
            color: #fff;
            transform: translateY(-1px);
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
            font-weight: 700;
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
        .swal2-popup { border-radius: 20px !important; }
        .grow { flex: 1; }
        @media (max-width: 991.98px) {
            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
                padding: 1rem;
            }
            .sidebar-shell { height: auto; }
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            .pagination-wrap { justify-content: center; }
        }
    </style>

    @stack('styles')
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-shell">
            <div class="sidebar-brand">
                <div class="brand-row">
                    <span class="brand-mark"><i class="fas fa-calendar-check"></i></span>
                    <div>
                        <p class="brand-title">ANDELIN AJA</p>
                        <p class="brand-subtitle">Ruang kerja karyawan lapangan</p>
                    </div>
                </div>
            </div>

            <div class="sidebar-nav">
                <div class="sidebar-section-label">Menu Karyawan</div>
                <nav class="sidebar-links grow">
                    <a href="{{ route('employee.home') }}" class="sidebar-link {{ request()->routeIs('employee.home') ? 'active' : '' }}">
                        <span class="sidebar-icon"><i class="fas fa-home"></i></span>
                        <span class="sidebar-text"><span class="sidebar-title">Beranda</span><span class="sidebar-note">Jadwal kerja hari ini</span></span>
                        <span class="sidebar-arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                    <a href="{{ route('employee.tasks.index') }}" class="sidebar-link {{ request()->routeIs('employee.tasks.*') ? 'active' : '' }}">
                        <span class="sidebar-icon"><i class="fas fa-check-square"></i></span>
                        <span class="sidebar-text"><span class="sidebar-title">Tugas Saya</span><span class="sidebar-note">Progress pekerjaan aktif</span></span>
                        <span class="sidebar-arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                    <a href="{{ route('employee.schedule.index') }}" class="sidebar-link {{ request()->routeIs('employee.schedule.*') ? 'active' : '' }}">
                        <span class="sidebar-icon"><i class="fas fa-calendar-alt"></i></span>
                        <span class="sidebar-text"><span class="sidebar-title">Jadwal Saya</span><span class="sidebar-note">Kalender penugasan</span></span>
                        <span class="sidebar-arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                    <a href="{{ route('employee.requests.index') }}" class="sidebar-link {{ request()->routeIs('employee.requests.*') ? 'active' : '' }}">
                        <span class="sidebar-icon"><i class="fas fa-paper-plane"></i></span>
                        <span class="sidebar-text"><span class="sidebar-title">Pengajuan</span><span class="sidebar-note">Cuti dan tukar jadwal</span></span>
                        <span class="sidebar-arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </nav>
            </div>

            <div class="sidebar-footer">
                <div class="sidebar-profile">
                    <div class="sidebar-profile-top">
                        <span class="sidebar-avatar"><i class="fas fa-user"></i></span>
                        <div>
                            <p class="sidebar-profile-name">{{ auth()->user()->name }}</p>
                            <p class="sidebar-profile-role">Karyawan</p>
                        </div>
                    </div>
                    <a href="{{ route('employee.profile.edit') }}" class="sidebar-profile-link"><i class="fas fa-cog"></i> Profil Saya</a>
                </div>
            </div>
        </div>
    </aside>

    <div class="main-content">
        <div class="topbar mb-4 rounded-4">
            <h6 class="mb-0 fw-bold">@yield('page-title', 'Beranda')</h6>
            <div class="ms-auto d-flex align-items-center gap-3 flex-wrap">
                <span class="user-chip"><i class="fas fa-user-circle"></i> {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="m-0 logout-form">
                    @csrf
                    <button class="btn btn-sm logout-button" style="color: var(--color-danger); border: 1px solid var(--color-border);"><i class="fas fa-sign-out-alt me-1"></i> Keluar</button>
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