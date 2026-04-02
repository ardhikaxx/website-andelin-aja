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

        .sidebar.offcanvas-lg {
            --bs-offcanvas-width: 320px;
            width: 278px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1045;
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
        .sidebar-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 2;
            opacity: .9;
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
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            padding-right: .35rem;
            scrollbar-width: thin;
            scrollbar-color: rgba(59, 130, 246, 0.35) transparent;
        }
        .sidebar-links::-webkit-scrollbar {
            width: 8px;
        }
        .sidebar-links::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-links::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.24);
            border-radius: 999px;
        }
        .sidebar-links::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.42);
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
            color: #fff;
            background: #3B82F6;
            border-color: #3B82F6;
            box-shadow: 0 14px 24px rgba(59, 130, 246, 0.22);
        }
        .sidebar-link.active .sidebar-icon {
            background: rgba(255, 255, 255, 0.16);
            color: #fff;
            box-shadow: none;
        }
        .sidebar-link.active .sidebar-title,
        .sidebar-link.active .sidebar-arrow {
            color: #fff;
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

        .sidebar-arrow {
            margin-left: auto;
            color: var(--color-text-muted);
            font-size: .76rem;
            transition: transform .2s ease;
        }
        .sidebar-link:hover .sidebar-arrow {
            color: var(--color-primary);
            transform: translateX(2px);
        }
        .sidebar-link.active .sidebar-arrow {
            color: #fff;
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
            position: relative;
            min-height: 90px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.96), rgba(248, 250, 255, 0.92));
            border: 1px solid rgba(229, 231, 235, 0.92);
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.15rem 1.25rem;
            backdrop-filter: blur(18px);
            overflow: hidden;
        }
        .topbar::after {
            content: '';
            position: absolute;
            top: -36px;
            right: 18px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.14), transparent 68%);
            pointer-events: none;
        }
        .topbar-start {
            display: flex;
            align-items: center;
            gap: .95rem;
            min-width: 0;
            position: relative;
            z-index: 1;
        }
        .topbar-heading {
            display: flex;
            flex-direction: column;
            gap: .3rem;
            min-width: 0;
        }
        .topbar-kicker {
            display: inline-flex;
            align-items: center;
            align-self: flex-start;
            padding: .38rem .7rem;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.10);
            color: var(--color-primary);
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
        .topbar-title {
            margin: 0;
            color: var(--color-text-primary);
            font-family: 'Poppins', sans-serif;
            font-size: clamp(1.15rem, 1rem + .5vw, 1.6rem);
            font-weight: 700;
            letter-spacing: -.02em;
            line-height: 1.1;
        }
        .topbar-subtitle {
            margin: 0;
            color: var(--color-text-muted);
            font-size: .86rem;
            line-height: 1.45;
        }
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: .8rem;
            margin-left: auto;
            position: relative;
            z-index: 1;
            flex-shrink: 0;
        }
        .sidebar-toggle {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            border: 1px solid rgba(209, 213, 219, 0.95);
            background: #fff;
            color: var(--color-primary);
            flex-shrink: 0;
            box-shadow: 0 10px 18px rgba(15, 23, 42, 0.05);
        }
        .sidebar-toggle:hover {
            color: #fff;
            background: var(--gradient-primary);
            border-color: transparent;
        }
        .main-content {
            margin-left: 278px;
            padding: 1.8rem;
            min-height: 100vh;
        }
        .user-chip {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
            padding: .55rem .8rem;
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(239, 246, 255, 0.98));
            border: 1px solid rgba(191, 219, 254, 0.9);
            box-shadow: 0 12px 24px rgba(59, 130, 246, 0.08);
            min-width: 0;
        }
        .user-chip-avatar {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--gradient-primary);
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 10px 18px rgba(59, 130, 246, 0.20);
        }
        .user-chip-meta {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .user-chip-name {
            color: var(--color-text-primary);
            font-size: .84rem;
            font-weight: 700;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
        }
        .user-chip-role {
            color: var(--color-text-muted);
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
        }
        .logout-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            min-height: 48px;
            padding: .7rem 1rem;
            border-radius: 16px !important;
            background: #fff;
            border: 1px solid rgba(254, 202, 202, 0.95);
            color: var(--color-danger);
            box-shadow: 0 10px 18px rgba(239, 68, 68, 0.08);
        }
        .logout-button:hover {
            background: #FEF2F2;
            border-color: rgba(248, 113, 113, 0.95);
            color: #DC2626;
        }
        .logout-label {
            white-space: nowrap;
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
        .table-andelin { margin-bottom: 0; }
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
        .table-andelin tbody tr:hover { background: rgba(59, 130, 246, 0.04); }
        .table-andelin tbody tr:last-child td { border-bottom: none; }
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
        textarea.form-control { min-height: 120px; }
        .form-label {
            font-weight: 600;
            color: var(--color-text-secondary);
            font-size: .86rem;
            margin-bottom: .45rem;
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
        .btn-outline-success { background: #fff; }
        .btn-outline-primary:hover,
        .btn-outline-secondary:hover,
        .btn-outline-danger:hover,
        .btn-outline-success:hover { transform: translateY(-1px); }
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
        .empty-state {
            padding: 2rem 1rem;
            color: var(--color-text-muted);
            text-align: center;
        }
        .grow { flex: 1; }
        @media (max-width: 991.98px) {
            .sidebar.offcanvas-lg {
                width: auto;
                padding: 0;
                background: transparent;
                border-right: none;
                box-shadow: none;
            }
            .sidebar-shell {
                height: 100%;
                min-height: 100vh;
                border-radius: 0 24px 24px 0;
                border-left: none;
            }
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            .topbar {
                align-items: stretch;
                flex-direction: column;
                padding: 1rem;
                gap: .95rem;
            }
            .topbar-start {
                align-items: flex-start;
                width: 100%;
            }
            .topbar-heading {
                width: 100%;
            }
            .topbar-actions {
                width: 100%;
                margin-left: 0;
                justify-content: space-between;
            }
            .user-chip {
                flex: 1;
            }
            .pagination-wrap { justify-content: center; }
        }
        @media (max-width: 575.98px) {
            .topbar-subtitle {
                display: none;
            }
            .topbar-actions {
                flex-direction: column;
                align-items: stretch;
            }
            .user-chip {
                width: 100%;
            }
            .user-chip-name {
                max-width: none;
            }
            .logout-form {
                width: 100%;
            }
            .logout-button {
                width: 100%;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <aside class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="adminSidebar" aria-labelledby="adminSidebarLabel">
        <div class="sidebar-shell">
            <div class="sidebar-brand">
                <button type="button" class="btn-close btn-close-white sidebar-close d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#adminSidebar" aria-label="Close"></button>
                <div class="brand-row">
                    <img src="{{ asset('assets/logo-andelin.png') }}" alt="Andelin Aja" style="width: 50px; height: 50px; object-fit: contain;">
                    <div>
                        <p class="brand-subtitle">Panel admin penjadwalan cerdas</p>
                    </div>
                </div>
            </div>

            <div class="sidebar-nav">
                <div class="sidebar-section-label">Navigasi Utama</div>
                <nav class="sidebar-links grow">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="sidebar-icon"><i class="fas fa-home"></i></span>
                        <span class="sidebar-text"><span class="sidebar-title">Dashboard</span></span>
                        <span class="sidebar-arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                    <a href="{{ route('admin.employees.index') }}" class="sidebar-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                        <span class="sidebar-icon"><i class="fas fa-users"></i></span>
                        <span class="sidebar-text"><span class="sidebar-title">Karyawan</span></span>
                        <span class="sidebar-arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                    <a href="{{ route('admin.specializations.index') }}" class="sidebar-link {{ request()->routeIs('admin.specializations.*') ? 'active' : '' }}">
                        <span class="sidebar-icon"><i class="fas fa-star"></i></span>
                        <span class="sidebar-text"><span class="sidebar-title">Spesialisasi</span></span>
                        <span class="sidebar-arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                    <a href="{{ route('admin.tasks.index') }}" class="sidebar-link {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}">
                        <span class="sidebar-icon"><i class="fas fa-clipboard-list"></i></span>
                        <span class="sidebar-text"><span class="sidebar-title">Tugas</span></span>
                        <span class="sidebar-arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                    <a href="{{ route('admin.assignments.index') }}" class="sidebar-link {{ request()->routeIs('admin.assignments.*') ? 'active' : '' }}">
                        <span class="sidebar-icon"><i class="fas fa-link"></i></span>
                        <span class="sidebar-text"><span class="sidebar-title">Penugasan</span></span>
                        <span class="sidebar-arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                    <a href="{{ route('admin.scheduling.index') }}" class="sidebar-link {{ request()->routeIs('admin.scheduling.*') ? 'active' : '' }}">
                        <span class="sidebar-icon"><i class="fas fa-robot"></i></span>
                        <span class="sidebar-text"><span class="sidebar-title">Penjadwalan</span></span>
                        <span class="sidebar-arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                    <a href="{{ route('admin.requests.index') }}" class="sidebar-link {{ request()->routeIs('admin.requests.*') ? 'active' : '' }}">
                        <span class="sidebar-icon"><i class="fas fa-paper-plane"></i></span>
                        <span class="sidebar-text"><span class="sidebar-title">Pengajuan</span></span>
                        <span class="sidebar-arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <span class="sidebar-icon"><i class="fas fa-chart-bar"></i></span>
                        <span class="sidebar-text"><span class="sidebar-title">Laporan</span></span>
                        <span class="sidebar-arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                    <a href="{{ route('admin.admins.index') }}" class="sidebar-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                        <span class="sidebar-icon"><i class="fas fa-user-shield"></i></span>
                        <span class="sidebar-text"><span class="sidebar-title">Manajemen Admin</span></span>
                        <span class="sidebar-arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </nav>
            </div>

            <div class="sidebar-footer">
                <div class="sidebar-profile">
                    <div class="sidebar-profile-top">
                        <span class="sidebar-avatar"><i class="fas fa-user-shield"></i></span>
                        <div>
                            <p class="sidebar-profile-name">{{ auth()->user()->name }}</p>
                            <p class="sidebar-profile-role">Admin</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.profile.edit') }}" class="sidebar-profile-link"><i class="fas fa-cog"></i> Profil Saya</a>
                </div>
            </div>
        </div>
    </aside>

    <div class="main-content">
        <div class="topbar mb-4 rounded-4">
            <div class="topbar-start">
                <button class="btn sidebar-toggle d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="topbar-heading">
                    <span class="topbar-kicker">Panel Admin</span>
                    <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>
                    <p class="topbar-subtitle">Kelola penjadwalan, tugas, pengajuan, dan operasional tim dalam satu panel.</p>
                </div>
            </div>
            <div class="topbar-actions">
                <span class="user-chip">
                    <span class="user-chip-avatar"><i class="fas fa-user-shield"></i></span>
                    <span class="user-chip-meta">
                        <span class="user-chip-name">{{ auth()->user()->name }}</span>
                        <span class="user-chip-role">Administrator</span>
                    </span>
                </span>
                <form action="{{ route('logout') }}" method="POST" class="m-0 logout-form">
                    @csrf
                    <button class="btn btn-sm logout-button" type="submit"><i class="fas fa-sign-out-alt"></i><span class="logout-label">Keluar</span></button>
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

        document.querySelectorAll('#adminSidebar .sidebar-link, #adminSidebar .sidebar-profile-link').forEach((link) => {
            link.addEventListener('click', function () {
                if (window.innerWidth < 992) {
                    const sidebarElement = document.getElementById('adminSidebar');
                    const instance = bootstrap.Offcanvas.getOrCreateInstance(sidebarElement);
                    instance.hide();
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>