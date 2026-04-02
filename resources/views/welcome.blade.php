<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANDELIN AJA - Solusi Semua Kebutuhanmu, Tinggal Suruh!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary: #2563EB;
            --color-primary-dark: #1E40AF;
            --color-primary-light: #60A5FA;
            --color-secondary: #7C3AED;
            --color-accent: #F59E0B;
            --color-bg-main: #F8FAFC;
            --color-bg-card: #FFFFFF;
            --color-text-primary: #0F172A;
            --color-text-secondary: #475569;
            --color-border: #E2E8F0;
            --color-success: #10B981;
            --gradient-primary: linear-gradient(135deg, #2563EB, #7C3AED);
            --gradient-whatsapp: linear-gradient(135deg, #22C55E, #16A34A);
            --shadow-sm: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            --radius-xl: 2rem;
            --radius-lg: 1rem;
        }

        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            background-color: var(--color-bg-main);
            color: var(--color-text-primary);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; font-weight: 700; }

        /* --- Decorative Background Elements --- */
        .bg-decoration {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
            pointer-events: none;
        }
        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: var(--color-primary-light);
            filter: blur(80px);
            opacity: 0.15;
            border-radius: 50%;
        }
        .blob-1 { top: -100px; right: -100px; }
        .blob-2 { bottom: 20%; left: -200px; background: var(--color-secondary); }

        /* --- Navbar --- */
        .landing-navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 1rem 0;
            background: rgba(248, 250, 252, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--color-border);
            transition: all 0.3s;
        }
        .brand-link {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
            color: var(--color-text-primary);
            text-decoration: none;
        }
        .brand-mark {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: var(--gradient-primary);
            color: #fff;
            font-size: 1.2rem;
            box-shadow: var(--shadow-md);
        }
        .nav-links a {
            color: var(--color-text-secondary);
            font-weight: 600;
            margin: 0 1rem;
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--color-primary); }

        /* --- Buttons --- */
        .btn-custom {
            border-radius: 999px;
            padding: 0.8rem 2rem;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .btn-primary-gradient {
            background: var(--gradient-primary);
            color: #fff;
            border: none;
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);
        }
        .btn-primary-gradient:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px -5px rgba(37, 99, 235, 0.5);
            color: #fff;
        }
        .btn-white {
            background: #fff;
            color: var(--color-primary);
            border: 1px solid var(--color-border);
        }
        .btn-white:hover {
            background: var(--color-bg-main);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        /* --- Hero Section --- */
        .hero-section { padding: 6rem 0; position: relative; }
        .hero-tag {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            background: rgba(37, 99, 235, 0.1);
            color: var(--color-primary);
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4.5rem);
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: var(--color-primary); /* Changed from gradient to primary color */
        }
        .hero-desc {
            font-size: 1.25rem;
            color: var(--color-text-secondary);
            margin-bottom: 2.5rem;
            max-width: 600px;
        }

        /* --- Stats Card --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 3rem;
        }
        .stat-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 1.5rem;
            border: 1px solid var(--color-border);
            text-align: center;
        }
        .stat-number { font-size: 2rem; font-weight: 800; color: var(--color-primary); display: block; }
        .stat-label { font-size: 0.875rem; color: var(--color-text-secondary); }

        /* --- Section Styling --- */
        .section-padding { padding: 6rem 0; }
        .section-kicker {
            color: var(--color-primary);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 800;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: block;
        }
        .section-title { font-size: 2.5rem; margin-bottom: 3rem; }

        /* --- Service Cards --- */
        .service-card-wrapper { height: 100%; }
        .service-card {
            background: #fff;
            border-radius: 2rem;
            padding: 2.5rem;
            height: 100%;
            border: 1px solid var(--color-border);
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
        }
        .service-card:hover {
            transform: translateY(-12px);
            border-color: var(--color-primary-light);
            box-shadow: var(--shadow-lg);
        }
        .service-card::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 100px; height: 100px;
            background: var(--gradient-primary);
            opacity: 0;
            clip-path: circle(0% at 100% 0%);
            transition: all 0.4s;
        }
        .service-card:hover::after { opacity: 0.05; clip-path: circle(100% at 100% 0%); }
        
        /* --- Team Card --- */
        .team-card {
            background: #fff;
            border-radius: 1.5rem;
            padding: 1.5rem;
            border: 1px solid var(--color-border);
            text-align: center;
            transition: all 0.3s;
        }
        .team-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }
        .team-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: #fff;
            font-weight: 700;
        }
        .team-name {
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        .team-position {
            font-size: 0.875rem;
            color: var(--color-text-secondary);
        }
        
        .service-icon {
            width: 64px;
            height: 64px;
            background: rgba(37, 99, 235, 0.1);
            color: var(--color-primary);
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .service-list { list-style: none; padding: 0; margin: 0; }
        .service-list li {
            padding: 0.5rem 0;
            color: var(--color-text-secondary);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .service-list li i { color: var(--color-success); font-size: 0.8rem; }

        /* --- How it Works --- */
        .step-card {
            text-align: center;
            position: relative;
        }
        .step-number {
            width: 80px;
            height: 80px;
            background: #fff;
            border: 2px solid var(--color-primary);
            color: var(--color-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0 auto 1.5rem;
            box-shadow: var(--shadow-md);
            position: relative;
            z-index: 2;
        }
        .step-card:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 40px;
            left: 50%;
            width: 100%;
            height: 2px;
            background: var(--color-border);
            z-index: 1;
        }

        /* --- Trust / Why Us --- */
        .trust-item {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            background: #fff;
            padding: 1.5rem;
            border-radius: 1.5rem;
            border: 1px solid var(--color-border);
        }
        .trust-icon {
            width: 48px;
            height: 48px;
            background: var(--color-primary);
            color: #fff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* --- Floating WhatsApp --- */
        .floating-wa {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1001;
            background: var(--gradient-whatsapp);
            color: #fff;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: 0 10px 25px rgba(34, 197, 94, 0.4);
            transition: all 0.3s;
            text-decoration: none;
        }
        .floating-wa:hover { transform: scale(1.1) rotate(10deg); color: #fff; }

        /* --- CTA Card --- */
        .cta-section { padding-bottom: 6rem; }
        .cta-box {
            background: var(--gradient-primary);
            border-radius: 3rem;
            padding: 4rem;
            color: #fff;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 30px 60px -15px rgba(37, 99, 235, 0.5);
        }
        .cta-box::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        }

        /* --- Footer --- */
        .footer { padding: 4rem 0 2rem; background: #0F172A; color: rgba(255,255,255,0.6); }
        .footer-brand { color: #fff; font-size: 1.5rem; margin-bottom: 1.5rem; display: block; font-weight: 800; text-decoration: none; }
        .footer-links { list-style: none; padding: 0; }
        .footer-links a { color: rgba(255,255,255,0.6); text-decoration: none; display: block; padding: 0.5rem 0; transition: color 0.2s; }
        .footer-links a:hover { color: #fff; }

        @media (max-width: 991px) {
            .step-card:not(:last-child)::after { display: none; }
            .hero-section { text-align: center; }
            .hero-desc { margin-left: auto; margin-right: auto; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>
    <div class="bg-decoration">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>

    <nav class="landing-navbar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="brand-link">
                    <span class="brand-mark"><i class="fas fa-bolt"></i></span>
                    <span class="fs-4 fw-bold">ANDELIN AJA</span>
                </a>
                <div class="nav-links d-none d-lg-block">
                    <a href="#layanan">Layanan</a>
                    <a href="#cara-kerja">Cara Kerja</a>
                    <a href="#kenapa">Keunggulan</a>
                    <a href="#tenaga-profesional">Tim Kami</a> <!-- Added link to new section -->
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn-custom btn-white px-4 d-none d-sm-inline-flex">Login</a>
                    <a href="https://wa.me/6289666648592" class="btn-custom btn-primary-gradient px-4">Pesan Jasa</a>
                </div>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <span class="hero-tag">✨ Jasa Serba Bisa Nomor #1</span>
                    <h1 class="hero-title">Apa Saja Kebutuhanmu, Kami Kerjakan!</h1>
                    <p class="hero-desc">
                        Gak sempat belanja? Malas antre? Atau butuh bantuan beresin rumah? Tinggal suruh <strong>ANDELIN AJA</strong>. Cepat, Terpercaya, dan Tanpa Ribet.
                    </p>
                    <div class="d-flex gap-3 flex-wrap justify-content-center justify-content-lg-start">
                        <a href="https://wa.me/6289666648592" class="btn-custom btn-primary-gradient btn-lg">
                            <i class="fas fa-paper-plane"></i> Order Sekarang
                        </a>
                        <a href="#layanan" class="btn-custom btn-white btn-lg">
                            Lihat Layanan
                        </a>
                    </div>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <span class="stat-number">1k+</span>
                            <span class="stat-label">Order Selesai</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number">4.9</span>
                            <span class="stat-label">Rating Puas</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">Layanan Siaga</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1 d-none d-lg-block">
                    <div class="position-relative">
                        <div class="service-card p-4" style="border-radius: 3rem; transform: rotate(-3deg);">
                            <img src="https://img.freepik.com/free-vector/delivery-service-illustrated_23-2148505081.jpg" class="img-fluid rounded-4" alt="Delivery Service">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="section-padding bg-white" id="layanan">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-kicker">Layanan Kami</span>
                <h2 class="section-title">Pilih Bantuan Yang Kamu Butuhkan</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-shopping-basket"></i></div>
                        <h4>Kurir & Jastip</h4>
                        <p class="text-muted">Beli makanan, titip belanjaan pasar, atau antar barang ketinggalan.</p>
                        <ul class="service-list">
                            <li><i class="fas fa-check-circle"></i> Beli Makanan/Barang</li>
                            <li><i class="fas fa-check-circle"></i> Ambil/Antar Dokumen</li>
                            <li><i class="fas fa-check-circle"></i> Jastip Barang Unik</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon" style="background: rgba(124, 58, 237, 0.1); color: var(--color-secondary);"><i class="fas fa-broom"></i></div>
                        <h4>Bantuan Rumah</h4>
                        <p class="text-muted">Bantu jaga kebersihan dan kenyamanan hunian kamu setiap hari.</p>
                        <ul class="service-list">
                            <li><i class="fas fa-check-circle"></i> Bersih-bersih Rumah</li>
                            <li><i class="fas fa-check-circle"></i> Rakit Furnitur</li>
                            <li><i class="fas fa-check-circle"></i> Ganti Lampu/Kran</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--color-success);"><i class="fas fa-laptop-code"></i></div>
                        <h4>Admin & Jasa Ketik</h4>
                        <p class="text-muted">Tugas kantor atau kuliah menumpuk? Biar kami yang bantu ketik.</p>
                        <ul class="service-list">
                            <li><i class="fas fa-check-circle"></i> Input Data Excel</li>
                            <li><i class="fas fa-check-circle"></i> Jasa Tulis/Ketik</li>
                            <li><i class="fas fa-check-circle"></i> Urusan Dokumen</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--color-accent);"><i class="fas fa-tools"></i></div>
                        <h4>Maintenance</h4>
                        <p class="text-muted">Perbaikan ringan furniture atau peralatan rumah tangga lainnya.</p>
                        <ul class="service-list">
                            <li><i class="fas fa-check-circle"></i> Perbaikan Kursi</li>
                            <li><i class="fas fa-check-circle"></i> Cat Ulang Ringan</li>
                            <li><i class="fas fa-check-circle"></i> Servis Peralatan</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-user-friends"></i></div>
                        <h4>Jasa Personal</h4>
                        <p class="text-muted">Butuh teman aktivitas atau bantuan unik lainnya? Kami siap.</p>
                        <ul class="service-list">
                            <li><i class="fas fa-check-circle"></i> Teman Belanja/Nonton</li>
                            <li><i class="fas fa-check-circle"></i> Antre Tiket/Nomor</li>
                            <li><i class="fas fa-check-circle"></i> Antar Jemput</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-card border-primary" style="background: var(--color-bg-main);">
                        <div class="service-icon bg-primary text-white"><i class="fas fa-plus"></i></div>
                        <h4>Request Khusus</h4>
                        <p class="text-muted">Punya kebutuhan lain yang tidak ada di list? Konsultasikan saja!</p>
                        <a href="https://wa.me/6289666648592" class="fw-bold text-primary text-decoration-none">Tanya via WA →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-white" id="tim-kami">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-kicker">Tim Kami</span>
                <h2 class="section-title">Tim Profesional Kami</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">Tim profesional Andelin Aja yang siap membantu kebutuhanmu kapan saja dengan layanan terbaik.</p>
            </div>
            <div class="row g-4 justify-content-center" id="team-grid">
                @php
                $employees = \App\Models\Employee::with('user', 'specializations')->get();
                $displayed = 6;
                @endphp
                @forelse($employees as $index => $emp)
                <div class="col-md-6 col-lg-4 col-xl-3 team-item" {{ $index >= $displayed ? 'style=display:none' : '' }}>
                    <div class="team-card">
                        <div class="team-avatar">
                            {{ strtoupper(substr($emp->user->name, 0, 1)) }}
                        </div>
                        <h5 class="team-name">{{ $emp->user->name }}</h5>
                        <p class="team-position">
                            @foreach($emp->specializations as $spec)
                            {{ $loop->first ? '' : ', ' }}{{ $spec->name }}
                            @endforeach
                        </p>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted">Tim kami akan segera hadir. Stay tuned!</p>
                </div>
                @endforelse
            </div>
            @if($employees->count() > $displayed)
            <div class="text-center mt-4">
                <button class="btn btn-primary" onclick="showAllTeam()">Tampilkan Semua ({{ $employees->count() }})</button>
            </div>
            @endif
        </div>
    </section>

    <section class="section-padding" id="cara-kerja">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-kicker">Proses Mudah</span>
                <h2 class="section-title">Gimana Cara Pakainya?</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h5 class="fw-bold">Pesan Jasa</h5>
                        <p class="text-muted">Hubungi kami via WhatsApp dan jelaskan apa yang perlu dikerjakan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h5 class="fw-bold">Kami Kerjakan</h5>
                        <p class="text-muted">Tim profesional kami akan langsung menuju lokasi atau menjalankan instruksimu.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h5 class="fw-bold">Beres & Bayar</h5>
                        <p class="text-muted">Setelah tugas selesai dengan sempurna, baru kamu lakukan pembayaran.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- New Section: Tenaga Profesional Kami -->
    <section class="section-padding bg-white" id="tenaga-profesional">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-kicker">Tim Kami</span>
                <h2 class="section-title">Tenaga Profesional ANDELIN AJA</h2>
            </div>
            <div class="row g-4">
                <!-- Employee Data Loop Placeholder -->
                {{--
                @foreach ($employees as $employee)
                --}}
                <div class="col-md-6 col-lg-3">
                    <div class="service-card text-center p-4" style="border-radius: 2rem;">
                        {{-- Placeholder Image: Replace with $employee->photo_url if available, or a default --}}
                        <img src="{{ $employee->photo_url ?? 'https://via.placeholder.com/150/CCCCCC/FFFFFF?text=FOTO' }}" alt="{{ $employee->name ?? 'Karyawan' }}" class="rounded-circle img-fluid mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                        <h5 class="fw-bold mb-0">{{ $employee->name ?? 'Nama Karyawan' }}</h5>
                        <p class="text-muted small">{{ $employee->specialization ?? 'Spesialisasi' }}</p>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            {{-- Replace '#' with actual WhatsApp link if available --}}
                            <a href="https://wa.me/+62{{ str_replace('-', '', substr($employee->phone_number ?? '6289666648592', -11)) }}" class="text-primary" target="_blank"><i class="fab fa-whatsapp"></i></a>
                            {{-- Replace '#' with actual employee info link if needed --}}
                            <a href="#" class="text-secondary"><i class="fas fa-info-circle"></i></a>
                        </div>
                    </div>
                </div>
                {{--
                @endforeach
                --}}

                {{-- Fallback if no employees are found or for static display if not using Blade loop --}}
                @if (empty($employees) || count($employees) === 0)
                    <div class="col-12 text-center text-muted">
                        Belum ada data karyawan yang ditampilkan.
                    </div>
                @endif
                {{-- Dummy Employee Cards (if static display is preferred or for testing structure) --}}
                @for ($i = 0; $i < 4; $i++)
                    <div class="col-md-6 col-lg-3">
                        <div class="service-card text-center p-4" style="border-radius: 2rem;">
                            <img src="https://via.placeholder.com/150/CCCCCC/FFFFFF?text=FOTO" alt="Foto Karyawan" class="rounded-circle img-fluid mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                            <h5 class="fw-bold mb-0">Nama Karyawan {{ $i+1 }}</h5>
                            <p class="text-muted small">Spesialisasi {{ $i+1 }}</p>
                            <div class="d-flex justify-content-center gap-3 mt-3">
                                <a href="https://wa.me/+6289666648592" class="text-primary" target="_blank"><i class="fab fa-whatsapp"></i></a>
                                <a href="#" class="text-secondary"><i class="fas fa-info-circle"></i></a>
                            </div>
                        </div>
                    </div>
                @endfor

            </div>
        </div>
    </section>
    <!-- End New Section -->


    <section class="section-padding" id="kenapa">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <span class="section-kicker">Mengapa Kami?</span>
                    <h2 class="section-title">Nikmati Kemudahan Hidup Tanpa Perlu Ribet</h2>
                    <div class="trust-item">
                        <div class="trust-icon"><i class="fas fa-bolt"></i></div>
                        <div>
                            <h5 class="fw-bold">Super Cepat</h5>
                            <p class="text-muted mb-0">Respon kilat dan pengerjaan tepat waktu sesuai permintaanmu.</p>
                        </div>
                    </div>
                    <div class="trust-item">
                        <div class="trust-icon" style="background: var(--color-secondary);"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <h5 class="fw-bold">100% Terpercaya</h5>
                            <p class="text-muted mb-0">Tim kami sudah terverifikasi dan profesional dalam bekerja.</p>
                        </div>
                    </div>
                    <div class="trust-item">
                        <div class="trust-icon" style="background: var(--color-success);"><i class="fas fa-tags"></i></div>
                        <div>
                            <h5 class="fw-bold">Harga Transparan</h5>
                            <p class="text-muted mb-0">Tanpa biaya tersembunyi. Harga jujur sesuai beban tugas.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="p-5 bg-light rounded-5 border">
                        <h3 class="fw-bold mb-4 text-center">Apa Kata Mereka?</h3>
                        <div class="text-center">
                            <i class="fas fa-quote-left fa-2x text-primary opacity-25 mb-3"></i>
                            <p class="fs-5 italic text-muted mb-4">"Andelin Aja bener-bener nolong banget pas lagi sibuk kantor tapi harus kirim dokumen ke klien. Kurirnya ramah dan cepet banget!"</p>
                            <h6 class="fw-bold mb-0">Budi Santoso</h6>
                            <span class="text-muted small">Karyawan Swasta</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section container">
        <div class="cta-box">
            <h2 class="display-4 fw-bold mb-3">Siap Kami Bantu Sekarang?</h2>
            <p class="fs-5 opacity-75 mb-5 mx-auto" style="max-width: 600px;">Jangan biarkan pekerjaan kecil menghambat harimu. Serahkan semuanya ke ANDELIN AJA.</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="https://wa.me/6289666648592" class="btn-custom btn-white btn-lg">
                    <i class="fab fa-whatsapp"></i> Chat WhatsApp
                </a>
                <a href="{{ route('login') }}" class="btn-custom btn-lg" style="background: rgba(255,255,255,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.3);">
                    Portal Karyawan
                </a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <a href="#" class="footer-brand">ANDELIN AJA</a>
                    <p>Solusi jasa serba bisa terbaik di kotamu. Hemat waktu, tenaga, dan biaya dengan bantuan profesional kami.</p>
                    <div class="d-flex gap-3 fs-5 mt-4">
                        <a href="#" class="text-white opacity-50"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white opacity-50"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white opacity-50"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2 offset-lg-2">
                    <h6 class="text-white fw-bold mb-4">Navigasi</h6>
                    <ul class="footer-links">
                        <li><a href="#hero">Home</a></li>
                        <li><a href="#layanan">Layanan</a></li>
                        <li><a href="#cara-kerja">Cara Kerja</a></li>
                        <li><a href="#kenapa">Keunggulan</a></li>
                        <li><a href="#tenaga-profesional">Tim Kami</a></li> <!-- Added link to new section -->
                    </ul>
                </div>
                <div class="col-md-4 col-lg-2">
                    <h6 class="text-white fw-bold mb-4">Legal</h6>
                    <ul class="footer-links">
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-lg-2">
                    <h6 class="text-white fw-bold mb-4">Bantuan</h6>
                    <ul class="footer-links">
                        <li><a href="https://wa.me/6289666648592">Customer Service</a></li>
                        <li><a href="mailto:halo@andelinaja.com">Email Kami</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-5 border-secondary opacity-25">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} ANDELIN AJA. Semua Hak Dilindungi.</p>
            </div>
        </div>
    </footer>

    <a href="https://wa.me/6289666648592" class="floating-wa" title="Chat WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scroll adjustment for fixed header
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.landing-navbar');
            if (window.scrollY > 50) {
                nav.style.padding = '0.5rem 0';
                nav.style.boxShadow = '0 10px 30px -10px rgba(0,0,0,0.1)';
            } else {
                nav.style.padding = '1rem 0';
                nav.style.boxShadow = 'none';
            }
        });
    </script>
    <script>
        function showAllTeam() {
            document.querySelectorAll('.team-item').forEach(function(item) {
                item.style.display = '';
            });
            document.querySelector('.btn-primary[onclick="showAllTeam()"]').style.display = 'none';
        }
    </script>
</body>
</html>