<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operasional Andelin Aja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            --shadow-soft: 0 18px 36px rgba(37, 99, 235, 0.10);
        }
        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        html {
            scroll-behavior: smooth;
        }
        body {
            margin: 0;
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.14), transparent 26%),
                linear-gradient(180deg, #F9FBFF 0%, var(--color-bg-main) 100%);
            color: var(--color-text-primary);
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        a {
            text-decoration: none;
        }
        .landing-navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 1rem 0;
            background: rgba(245, 247, 251, 0.88);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.88);
        }
        .brand-link {
            display: inline-flex;
            align-items: center;
            gap: .85rem;
            color: var(--color-text-primary);
            font-weight: 800;
            letter-spacing: -.02em;
        }
        .brand-mark {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: var(--gradient-primary);
            color: #fff;
            box-shadow: 0 14px 28px rgba(59, 130, 246, 0.22);
        }
        .nav-links {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.2rem;
            flex-wrap: wrap;
        }
        .nav-links a {
            color: var(--color-text-secondary);
            font-size: .92rem;
            font-weight: 700;
        }
        .nav-links a:hover {
            color: var(--color-primary);
        }
        .btn-landing-primary,
        .btn-landing-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            border-radius: 999px;
            padding: .85rem 1.2rem;
            font-weight: 700;
            transition: all .2s ease;
        }
        .btn-landing-primary {
            background: var(--gradient-primary);
            color: #fff;
            box-shadow: 0 16px 28px rgba(59, 130, 246, 0.22);
        }
        .btn-landing-primary:hover {
            color: #fff;
            transform: translateY(-1px);
        }
        .btn-landing-outline {
            border: 1px solid var(--color-border);
            color: var(--color-text-primary);
            background: rgba(255, 255, 255, 0.92);
        }
        .btn-landing-outline:hover {
            color: var(--color-primary);
            border-color: var(--color-primary-light);
        }
        .hero-section {
            padding: 5rem 0 4rem;
        }
        .hero-shell {
            position: relative;
            padding: 2rem;
            border-radius: 32px;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.20), transparent 24%),
                linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 52%, var(--color-primary-light) 100%);
            color: #fff;
            overflow: hidden;
            box-shadow: 0 28px 56px rgba(15, 23, 42, 0.16);
        }
        .hero-shell::after {
            content: '';
            position: absolute;
            width: 280px;
            height: 280px;
            right: -60px;
            top: -90px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }
        .hero-content,
        .hero-card {
            position: relative;
            z-index: 1;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            padding: .45rem .78rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
        .hero-title {
            margin: 1rem 0 .85rem;
            font-size: clamp(2.3rem, 2rem + 2vw, 4.3rem);
            line-height: .98;
            letter-spacing: -.05em;
            font-weight: 800;
        }
        .hero-text {
            margin: 0;
            max-width: 620px;
            color: rgba(255, 255, 255, 0.84);
            font-size: 1rem;
            line-height: 1.8;
        }
        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .9rem;
            margin-top: 1.6rem;
        }
        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: .9rem;
            margin-top: 1.8rem;
        }
        .hero-stat {
            padding: 1rem 1.05rem;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.14);
        }
        .hero-stat strong {
            display: block;
            font-size: 1.45rem;
            margin-bottom: .25rem;
        }
        .hero-stat span {
            color: rgba(255, 255, 255, 0.76);
            font-size: .84rem;
        }
        .hero-card {
            padding: 1.25rem;
            border-radius: 26px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(12px);
        }
        .hero-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .hero-card-title {
            margin: 0;
            font-size: 1rem;
            font-weight: 800;
        }
        .hero-card-subtitle {
            margin: .3rem 0 0;
            color: rgba(255, 255, 255, 0.76);
            font-size: .82rem;
        }
        .hero-card-icon {
            width: 54px;
            height: 54px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.16);
        }
        .hero-list {
            display: grid;
            gap: .75rem;
        }
        .hero-list-item {
            display: flex;
            align-items: center;
            gap: .8rem;
            padding: .85rem .9rem;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.12);
        }
        .hero-list-item i {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.18);
        }
        .section-block {
            padding: 4.5rem 0;
        }
        .section-head {
            max-width: 620px;
            margin-bottom: 2rem;
        }
        .section-kicker {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .42rem .72rem;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.08);
            color: var(--color-primary);
            font-size: .74rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
        .section-title {
            margin: .9rem 0 .65rem;
            font-size: clamp(1.8rem, 1.5rem + .7vw, 2.7rem);
            line-height: 1.08;
            letter-spacing: -.04em;
        }
        .section-text {
            margin: 0;
            color: var(--color-text-secondary);
            line-height: 1.8;
        }
        .service-card,
        .about-card,
        .contact-card,
        .footer-shell {
            background: var(--color-bg-card);
            border: 1px solid var(--color-border);
            border-radius: 24px;
            box-shadow: var(--shadow-soft);
        }
        .service-card {
            height: 100%;
            padding: 1.4rem;
        }
        .service-icon {
            width: 56px;
            height: 56px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: var(--gradient-primary);
            color: #fff;
            box-shadow: 0 16px 28px rgba(59, 130, 246, 0.18);
            margin-bottom: 1rem;
        }
        .service-title {
            margin: 0 0 .5rem;
            font-size: 1.02rem;
            font-weight: 800;
        }
        .service-text {
            margin: 0;
            color: var(--color-text-secondary);
            line-height: 1.8;
            font-size: .92rem;
        }
        .about-card,
        .contact-card {
            height: 100%;
            padding: 1.6rem;
        }
        .about-highlights {
            display: grid;
            gap: .8rem;
            margin-top: 1.4rem;
        }
        .about-highlight {
            display: flex;
            align-items: flex-start;
            gap: .8rem;
            padding: .9rem 1rem;
            border-radius: 18px;
            background: rgba(59, 130, 246, 0.06);
            border: 1px solid rgba(147, 197, 253, 0.45);
        }
        .about-highlight i {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: rgba(59, 130, 246, 0.12);
            color: var(--color-primary);
            flex-shrink: 0;
        }
        .contact-list {
            display: grid;
            gap: .85rem;
            margin-top: 1.3rem;
        }
        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: .9rem;
            padding: .95rem 1rem;
            border-radius: 18px;
            background: var(--color-bg-main);
            border: 1px solid var(--color-border);
        }
        .contact-item i {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: var(--gradient-primary);
            color: #fff;
            flex-shrink: 0;
        }
        .contact-item strong {
            display: block;
            margin-bottom: .22rem;
            font-size: .92rem;
        }
        .contact-item span,
        .contact-item a {
            color: var(--color-text-secondary);
            line-height: 1.7;
        }
        .contact-item a:hover {
            color: var(--color-primary);
        }
        .footer-section {
            padding: 0 0 2rem;
        }
        .footer-shell {
            padding: 1.5rem;
        }
        .footer-title {
            margin: 0;
            font-size: 1rem;
            font-weight: 800;
        }
        .footer-text {
            margin: .35rem 0 0;
            color: var(--color-text-secondary);
            line-height: 1.8;
            font-size: .9rem;
        }
        .footer-links {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        .footer-links a {
            color: var(--color-text-secondary);
            font-weight: 700;
        }
        .footer-links a:hover {
            color: var(--color-primary);
        }
        @media (max-width: 991.98px) {
            .landing-navbar {
                position: static;
            }
            .hero-section,
            .section-block {
                padding: 3rem 0;
            }
            .hero-shell,
            .about-card,
            .contact-card,
            .service-card,
            .footer-shell {
                border-radius: 22px;
            }
            .hero-stats {
                grid-template-columns: 1fr;
            }
            .nav-links {
                justify-content: flex-start;
                margin-top: 1rem;
            }
            .footer-links {
                justify-content: flex-start;
                margin-top: 1rem;
            }
        }
        @media (max-width: 575.98px) {
            .hero-shell,
            .about-card,
            .contact-card,
            .service-card,
            .footer-shell {
                padding-left: 1.15rem;
                padding-right: 1.15rem;
            }
            .hero-shell {
                padding-top: 1.4rem;
                padding-bottom: 1.4rem;
            }
            .hero-actions {
                flex-direction: column;
            }
            .btn-landing-primary,
            .btn-landing-outline {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <nav class="landing-navbar">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-lg-4">
                    <a href="#hero" class="brand-link">
                        <span class="brand-mark"><i class="fas fa-calendar-check"></i></span>
                        <span>Operasional Andelin Aja</span>
                    </a>
                </div>
                <div class="col-lg-5">
                    <div class="nav-links">
                        <a href="#hero">Beranda</a>
                        <a href="#layanan">Layanan</a>
                        <a href="#tentang">Tentang</a>
                        <a href="#kontak">Kontak</a>
                    </div>
                </div>
                <div class="col-lg-3 text-lg-end">
                    <a href="{{ route('login') }}" class="btn-landing-primary"><i class="fas fa-right-to-bracket"></i> Masuk Sistem</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-section" id="hero">
        <div class="container">
            <div class="hero-shell">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <div class="hero-content">
                            <span class="hero-badge"><i class="fas fa-sparkles"></i> Solusi Operasional Tim Lapangan</span>
                            <h1 class="hero-title">Andelin Aja membantu operasional tim berjalan lebih rapi, cepat, dan terpantau.</h1>
                            <p class="hero-text">
                                Kelola penjadwalan, pembagian tugas, monitoring progres, hingga pengajuan karyawan dalam satu sistem yang dirancang untuk mendukung jasa operasional Andelin Aja.
                            </p>
                            <div class="hero-actions">
                                <a href="#layanan" class="btn-landing-primary"><i class="fas fa-arrow-down"></i> Lihat Layanan</a>
                                <a href="#kontak" class="btn-landing-outline"><i class="fas fa-phone"></i> Hubungi Kami</a>
                            </div>
                            <div class="hero-stats">
                                <div class="hero-stat">
                                    <strong>Penjadwalan</strong>
                                    <span>Pengaturan shift dan tugas lebih tertata.</span>
                                </div>
                                <div class="hero-stat">
                                    <strong>Monitoring</strong>
                                    <span>Pantau progres tim dan status pekerjaan.</span>
                                </div>
                                <div class="hero-stat">
                                    <strong>Operasional</strong>
                                    <span>Satu sistem untuk ritme kerja harian.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="hero-card">
                            <div class="hero-card-top">
                                <div>
                                    <p class="hero-card-title">Fokus layanan Andelin Aja</p>
                                    <p class="hero-card-subtitle">Dirancang untuk kebutuhan operasional yang bergerak cepat.</p>
                                </div>
                                <span class="hero-card-icon"><i class="fas fa-layer-group"></i></span>
                            </div>
                            <div class="hero-list">
                                <div class="hero-list-item">
                                    <i class="fas fa-calendar-days"></i>
                                    <div>
                                        <strong>Penjadwalan kerja</strong>
                                        <div style="color: rgba(255, 255, 255, 0.76); font-size: .84rem; margin-top: .18rem;">Membantu tim tersusun dengan pembagian kerja yang jelas.</div>
                                    </div>
                                </div>
                                <div class="hero-list-item">
                                    <i class="fas fa-clipboard-list"></i>
                                    <div>
                                        <strong>Manajemen tugas</strong>
                                        <div style="color: rgba(255, 255, 255, 0.76); font-size: .84rem; margin-top: .18rem;">Memastikan setiap pekerjaan punya PIC dan deadline yang terpantau.</div>
                                    </div>
                                </div>
                                <div class="hero-list-item">
                                    <i class="fas fa-chart-pie"></i>
                                    <div>
                                        <strong>Pantauan performa</strong>
                                        <div style="color: rgba(255, 255, 255, 0.76); font-size: .84rem; margin-top: .18rem;">Ringkas performa tim agar keputusan operasional lebih cepat diambil.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-block" id="layanan">
        <div class="container">
            <div class="section-head">
                <span class="section-kicker"><i class="fas fa-briefcase"></i> Layanan</span>
                <h2 class="section-title">Layanan inti untuk mendukung operasional jasa Andelin Aja</h2>
                <p class="section-text">Tampilan layanan ini difokuskan pada apa yang paling dibutuhkan tim operasional: penjadwalan, manajemen pekerjaan, dan kontrol aktivitas lapangan.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-xl-4">
                    <div class="service-card">
                        <span class="service-icon"><i class="fas fa-calendar-alt"></i></span>
                        <h3 class="service-title">Penjadwalan Tim</h3>
                        <p class="service-text">Menyusun jadwal kerja karyawan dengan alur yang lebih cepat, jelas, dan mudah dipantau oleh admin operasional.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="service-card">
                        <span class="service-icon"><i class="fas fa-list-check"></i></span>
                        <h3 class="service-title">Manajemen Tugas</h3>
                        <p class="service-text">Membantu pengelolaan tugas aktif, penanggung jawab, tenggat waktu, dan perkembangan status pekerjaan harian.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="service-card">
                        <span class="service-icon"><i class="fas fa-chart-line"></i></span>
                        <h3 class="service-title">Monitoring Operasional</h3>
                        <p class="service-text">Memberikan gambaran ringkas performa dan kondisi tim agar pengambilan keputusan operasional menjadi lebih cepat.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-block pt-0" id="tentang">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-7">
                    <div class="about-card">
                        <span class="section-kicker"><i class="fas fa-circle-info"></i> Tentang Kami</span>
                        <h2 class="section-title">Andelin Aja hadir untuk membuat operasional jasa lebih terstruktur</h2>
                        <p class="section-text">
                            Kami membangun pendekatan operasional yang menempatkan kejelasan penjadwalan, kontrol tugas, dan koordinasi tim sebagai fondasi utama. Fokusnya bukan hanya tampilan yang rapi, tetapi alur kerja yang benar-benar membantu aktivitas jasa berjalan lebih efisien.
                        </p>
                        <div class="about-highlights">
                            <div class="about-highlight">
                                <i class="fas fa-bolt"></i>
                                <div>
                                    <strong>Respons cepat</strong>
                                    <div style="color: var(--color-text-secondary); margin-top: .18rem; line-height: 1.7;">Operasional dapat bergerak lebih gesit dengan data yang selalu mudah diakses.</div>
                                </div>
                            </div>
                            <div class="about-highlight">
                                <i class="fas fa-people-group"></i>
                                <div>
                                    <strong>Koordinasi tim lebih jelas</strong>
                                    <div style="color: var(--color-text-secondary); margin-top: .18rem; line-height: 1.7;">Setiap pekerjaan, penanggung jawab, dan jadwal tersusun dalam satu alur kerja.</div>
                                </div>
                            </div>
                            <div class="about-highlight">
                                <i class="fas fa-shield-heart"></i>
                                <div>
                                    <strong>Kontrol operasional lebih kuat</strong>
                                    <div style="color: var(--color-text-secondary); margin-top: .18rem; line-height: 1.7;">Memudahkan admin dalam memantau dan menindaklanjuti kebutuhan tim lapangan.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" id="kontak">
                    <div class="contact-card">
                        <span class="section-kicker"><i class="fas fa-envelope-open-text"></i> Kontak</span>
                        <h2 class="section-title">Siap berdiskusi untuk kebutuhan layanan Anda</h2>
                        <p class="section-text">Hubungi Andelin Aja untuk informasi lebih lanjut mengenai layanan operasional, koordinasi tim, dan implementasi sistem kerja yang lebih tertata.</p>
                        <div class="contact-list">
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <strong>Email</strong>
                                    <a href="mailto:halo@andelinaja.com">halo@andelinaja.com</a>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone-volume"></i>
                                <div>
                                    <strong>Telepon</strong>
                                    <a href="tel:+6281234567890">+62 812-3456-7890</a>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-location-dot"></i>
                                <div>
                                    <strong>Area Layanan</strong>
                                    <span>Operasional jasa dan koordinasi tim lapangan di wilayah Indonesia.</span>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 1.4rem;">
                            <a href="{{ route('login') }}" class="btn-landing-primary"><i class="fas fa-right-to-bracket"></i> Masuk ke Sistem</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer-section">
        <div class="container">
            <div class="footer-shell">
                <div class="row align-items-center g-3">
                    <div class="col-lg-7">
                        <h3 class="footer-title">Operasional Andelin Aja</h3>
                        <p class="footer-text">Landing page ini merangkum layanan utama Andelin Aja: penjadwalan tim, pengelolaan tugas, monitoring operasional, dan dukungan koordinasi jasa yang lebih tertata.</p>
                    </div>
                    <div class="col-lg-5">
                        <div class="footer-links">
                            <a href="#hero">Beranda</a>
                            <a href="#layanan">Layanan</a>
                            <a href="#tentang">Tentang</a>
                            <a href="#kontak">Kontak</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>