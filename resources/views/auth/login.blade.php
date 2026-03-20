<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ANDELIN AJA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary: #3B82F6;
            --color-primary-dark: #2563EB;
            --color-secondary: #0F172A;
            --color-bg-main: #EAF1FF;
            --color-bg-card: #FFFFFF;
            --color-text-primary: #111827;
            --color-text-secondary: #6B7280;
            --color-text-soft: #CBD5E1;
            --color-border: #E5E7EB;
            --radius-xl: 34px;
            --radius-lg: 24px;
            --radius-md: 18px;
            --radius-sm: 14px;
            --shadow-shell: 0 30px 60px rgba(15, 23, 42, 0.14);
            --shadow-card: 0 22px 40px rgba(15, 23, 42, 0.08);
            --gradient-primary: linear-gradient(145deg, #1D4ED8 0%, #3B82F6 55%, #60A5FA 100%);
        }

        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }

        body {
            min-height: 100vh;
            margin: 0;
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.26), transparent 28%),
                radial-gradient(circle at bottom right, rgba(37, 99, 235, 0.16), transparent 24%),
                linear-gradient(180deg, #F6F9FF 0%, var(--color-bg-main) 100%);
            padding: 24px;
            color: var(--color-text-primary);
        }

        .login-shell {
            width: 100%;
            min-height: calc(100vh - 48px);
            display: grid;
            grid-template-columns: 1.12fr .88fr;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-shell);
            backdrop-filter: blur(18px);
        }

        .login-brand {
            position: relative;
            overflow: hidden;
            background: var(--gradient-primary);
            color: #fff;
            padding: 3rem;
            display: flex;
            align-items: stretch;
            min-height: 100%;
        }

        .login-brand::before,
        .login-brand::after {
            content: '';
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
        }

        .login-brand::before {
            width: 360px;
            height: 360px;
            top: -110px;
            left: -130px;
            background: rgba(255, 255, 255, 0.12);
        }

        .login-brand::after {
            width: 420px;
            height: 420px;
            right: -180px;
            bottom: -180px;
            background: rgba(191, 219, 254, 0.18);
        }

        .brand-grid {
            position: relative;
            z-index: 1;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 2rem;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
            align-self: flex-start;
            padding: .75rem 1rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.18);
            font-size: .82rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .brand-mark {
            width: 54px;
            height: 54px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.18);
            font-size: 1.25rem;
        }

        .brand-copy {
            max-width: 560px;
        }

        .brand-title {
            margin: 1.35rem 0 1rem;
            font-size: clamp(2.35rem, 2rem + 1.8vw, 4.15rem);
            line-height: 1.02;
            letter-spacing: -.05em;
            font-weight: 800;
        }

        .brand-title span {
            display: block;
            color: rgba(255, 255, 255, 0.76);
        }

        .brand-description {
            max-width: 500px;
            margin: 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 1rem;
            line-height: 1.8;
        }

        .brand-decor {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
            max-width: 560px;
        }

        .decor-card,
        .decor-stat {
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(10px);
        }

        .decor-card {
            padding: 1rem 1.05rem;
            min-height: 120px;
        }

        .decor-icon {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.18);
            margin-bottom: .95rem;
        }

        .decor-card-title {
            margin: 0 0 .35rem;
            font-size: .95rem;
            font-weight: 700;
        }

        .decor-card-text {
            margin: 0;
            color: rgba(255, 255, 255, 0.74);
            font-size: .82rem;
            line-height: 1.6;
        }

        .decor-stat {
            grid-column: span 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.15rem 1.25rem;
        }

        .decor-stat strong {
            display: block;
            font-size: 1.75rem;
            line-height: 1;
            margin-bottom: .35rem;
        }

        .decor-stat span {
            color: rgba(255, 255, 255, 0.72);
            font-size: .85rem;
        }

        .orbit {
            position: absolute;
            inset: auto 48px 52px auto;
            width: 118px;
            height: 118px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.28);
            opacity: .9;
        }

        .orbit::before,
        .orbit::after {
            content: '';
            position: absolute;
            border-radius: 50%;
        }

        .orbit::before {
            inset: 17px;
            border: 1px dashed rgba(255, 255, 255, 0.24);
        }

        .orbit::after {
            width: 14px;
            height: 14px;
            top: 14px;
            left: 50%;
            margin-left: -7px;
            background: #fff;
            box-shadow: 0 0 0 8px rgba(255, 255, 255, 0.12);
        }

        .login-panel {
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
        }

        .login-panel-inner {
            width: 100%;
            max-width: 430px;
        }

        .login-card {
            background: #fff;
            border: 1px solid rgba(229, 231, 235, 0.92);
            border-radius: 28px;
            box-shadow: var(--shadow-card);
            padding: 2rem;
        }

        .login-kicker {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            padding: .45rem .75rem;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.08);
            color: var(--color-primary);
            font-size: .76rem;
            font-weight: 700;
        }

        .login-title {
            margin: 1.1rem 0 .5rem;
            font-size: 1.95rem;
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .login-subtitle {
            margin: 0 0 1.6rem;
            color: var(--color-text-secondary);
            line-height: 1.7;
            font-size: .95rem;
        }

        .form-label {
            color: var(--color-text-primary);
            font-size: .86rem;
            font-weight: 700;
            margin-bottom: .5rem;
        }

        .form-control {
            min-height: 52px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--color-border);
            padding: .8rem 1rem;
            color: var(--color-text-primary);
            background: #F9FBFF;
        }

        .form-control:focus {
            border-color: var(--color-primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.14);
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .form-control {
            padding-left: 3rem;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            color: #94A3B8;
            font-size: .95rem;
            pointer-events: none;
        }

        .btn-login {
            min-height: 54px;
            width: 100%;
            border: none;
            border-radius: var(--radius-sm);
            background: var(--gradient-primary);
            color: #fff;
            font-weight: 700;
            box-shadow: 0 18px 30px rgba(37, 99, 235, 0.24);
        }

        .btn-login:hover {
            color: #fff;
            filter: brightness(1.03);
        }

        .credential-box {
            margin-top: 1.25rem;
            padding: 1rem 1.05rem;
            border-radius: 18px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
        }

        .credential-label {
            display: block;
            margin-bottom: .65rem;
            color: var(--color-text-primary);
            font-size: .8rem;
            font-weight: 700;
        }

        .credential-item {
            display: flex;
            align-items: flex-start;
            gap: .7rem;
            color: var(--color-text-secondary);
            font-size: .82rem;
        }

        .credential-item + .credential-item {
            margin-top: .55rem;
        }

        .credential-item i {
            color: var(--color-primary);
            margin-top: .15rem;
        }

        @media (max-width: 991.98px) {
            body {
                padding: 16px;
            }

            .login-shell {
                min-height: auto;
                grid-template-columns: 1fr;
            }

            .login-brand,
            .login-panel {
                padding: 2rem;
            }

            .brand-decor {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .decor-stat {
                grid-column: span 2;
            }
        }

        @media (max-width: 575.98px) {
            body {
                padding: 12px;
            }

            .login-shell {
                border-radius: 26px;
            }

            .login-brand,
            .login-panel {
                padding: 1.35rem;
            }

            .login-card {
                padding: 1.35rem;
                border-radius: 22px;
            }

            .brand-title {
                font-size: 2.3rem;
            }

            .brand-decor {
                grid-template-columns: 1fr;
            }

            .decor-stat {
                grid-column: span 1;
                flex-direction: column;
                align-items: flex-start;
            }

            .orbit,
            .brand-description {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="login-shell">
        <section class="login-brand">
            <div class="brand-grid">
                <div>
                    <div class="brand-badge">
                        <span class="brand-mark"><i class="fas fa-layer-group"></i></span>
                        Operasional Digital
                    </div>
                    <div class="brand-copy">
                        <h1 class="brand-title">
                            Operasional<br>
                            <span>Andelin Aja</span>
                        </h1>
                        <p class="brand-description">
                            Satu ruang kerja untuk mengatur penjadwalan, tugas, pengajuan, dan ritme operasional tim secara lebih tertata dan cepat.
                        </p>
                    </div>
                </div>

                <div class="brand-decor">
                    <div class="decor-card">
                        <div class="decor-icon"><i class="fas fa-calendar-check"></i></div>
                        <p class="decor-card-title">Jadwal Terkelola</p>
                        <p class="decor-card-text">Pantau ritme kerja harian dengan susunan yang rapi dan mudah dibaca.</p>
                    </div>
                    <div class="decor-card">
                        <div class="decor-icon"><i class="fas fa-users"></i></div>
                        <p class="decor-card-title">Tim Terhubung</p>
                        <p class="decor-card-text">Kelola peran admin dan karyawan dalam satu alur operasional.</p>
                    </div>
                    <div class="decor-stat">
                        <div>
                            <strong>1 Dashboard</strong>
                            <span>Akses tugas, jadwal, dan pengajuan dari satu sistem operasional.</span>
                        </div>
                        <div class="decor-icon"><i class="fas fa-arrow-trend-up"></i></div>
                    </div>
                </div>
            </div>
            <div class="orbit"></div>
        </section>

        <section class="login-panel">
            <div class="login-panel-inner">
                <div class="login-card">
                    <span class="login-kicker"><i class="fas fa-lock"></i> Akses Sistem</span>
                    <h2 class="login-title">Masuk ke akun Anda</h2>
                    <p class="login-subtitle">Gunakan email dan password terdaftar untuk masuk ke sistem operasional Andelin Aja.</p>

                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-wrap">
                                <span class="input-icon"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan email" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <div class="input-wrap">
                                <span class="input-icon"><i class="fas fa-key"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                            </div>
                        </div>
                        <button class="btn-login" type="submit">
                            <i class="fas fa-right-to-bracket me-2"></i> Masuk
                        </button>
                    </form>

                    <div class="credential-box">
                        <span class="credential-label">Akun demo</span>
                        <div class="credential-item">
                            <i class="fas fa-user-shield"></i>
                            <span>Admin: <strong>admin@andelin.com</strong> / <strong>password</strong></span>
                        </div>
                        <div class="credential-item">
                            <i class="fas fa-user"></i>
                            <span>Karyawan: <strong>karyawan1@andelin.com</strong> / <strong>password</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if($errors->any())
    <script>
        Swal.fire({ icon: 'error', title: 'Validasi gagal', text: '{{ $errors->first() }}' });
    </script>
    @endif
    @if(session('error'))
    <script>
        Swal.fire({ icon: 'error', title: 'Login gagal', text: '{{ session('error') }}' });
    </script>
    @endif
</body>
</html>