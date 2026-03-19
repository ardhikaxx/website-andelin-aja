<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ANDELIN AJA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary: #3B82F6;
            --color-primary-dark: #2563EB;
            --color-secondary: #6366F1;
            --color-bg-main: #F5F7FB;
            --color-bg-card: #FFFFFF;
            --color-text-primary: #111827;
            --color-text-secondary: #6B7280;
            --color-border: #E5E7EB;
            --radius-lg: 20px;
            --radius-md: 16px;
            --radius-sm: 10px;
            --shadow-soft: 0 10px 25px rgba(0, 0, 0, 0.05);
            --gradient-primary: linear-gradient(135deg, #3B82F6, #6366F1);
        }
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        body {
            min-height: 100vh;
            background: radial-gradient(circle at top left, rgba(59, 130, 246, 0.15), transparent 35%), var(--color-bg-main);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            background: var(--color-bg-card);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
            overflow: hidden;
        }
        .login-header {
            background: var(--gradient-primary);
            color: #fff;
            padding: 2rem;
        }
        .form-control {
            border-radius: var(--radius-sm);
            border: 1px solid var(--color-border);
            padding: .75rem 1rem;
        }
        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        .btn-login {
            background: var(--color-primary);
            color: #fff;
            border-radius: var(--radius-sm);
            padding: .75rem 1rem;
            border: none;
            width: 100%;
        }
        .btn-login:hover { background: var(--color-primary-dark); }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h3 class="mb-2">ANDELIN AJA</h3>
            <p class="mb-0">Sistem Cerdas Penjadwalan Karyawan Berbasis Algoritma Greedy</p>
        </div>
        <div class="p-4">
            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn-login">
                    <i class="fas fa-right-to-bracket me-2"></i> Masuk
                </button>
            </form>

            <div class="mt-4 small" style="color: var(--color-text-secondary);">
                <div>Admin: admin@andelin.com / password</div>
                <div>Karyawan: karyawan1@andelin.com / password</div>
            </div>
        </div>
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
