<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Glow-Up | Вход в админку</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 1rem;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-logo .logo-circle {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            background: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            box-shadow: 0 8px 24px rgba(13, 110, 253, 0.3);
        }

        .login-logo .logo-circle i {
            font-size: 32px;
            color: #fff;
        }

        .login-logo h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 4px;
        }

        .login-logo p {
            color: #6c757d;
            font-size: 14px;
            margin: 0;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 32px rgba(0,0,0,0.08);
            padding: 2rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            border: 1.5px solid #e9ecef;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        .input-group-text {
            border-radius: 0 10px 10px 0;
            border: 1.5px solid #e9ecef;
            border-left: none;
            background: #f8f9fa;
            color: #6c757d;
        }

        .input-group .form-control {
            border-radius: 10px 0 0 10px;
            border-right: none;
        }

        .input-group:focus-within .form-control,
        .input-group:focus-within .input-group-text {
            border-color: #0d6efd;
        }

        .btn-login {
            border-radius: 10px;
            padding: 11px;
            font-size: 15px;
            font-weight: 600;
            background: #0d6efd;
            border: none;
            letter-spacing: 0.3px;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: #0b5ed7;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(13, 110, 253, 0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .alert-danger {
            border-radius: 10px;
            font-size: 14px;
            border: none;
            background: #fff3f3;
            color: #dc3545;
            padding: 10px 14px;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 1.25rem 0;
            color: #adb5bd;
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e9ecef;
        }

        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            color: #adb5bd;
            font-size: 12px;
        }

        /* Показ/скрытие пароля */
        .toggle-password {
            cursor: pointer;
            user-select: none;
        }

        .toggle-password:hover {
            color: #0d6efd;
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    {{-- Логотип --}}
    <div class="login-logo">
        <div class="logo-circle">
            <i class="bi bi-shop"></i>
        </div>
        <h1>Glow-Up</h1>
        <p>Панель управления маркетплейсом</p>
    </div>

    {{-- Карточка входа --}}
    <div class="login-card">

        <h5 class="fw-bold mb-1" style="font-size:18px;">Вход в систему</h5>
        <p class="text-muted mb-4" style="font-size:13px;">
            Введите данные для доступа к панели
        </p>

        {{-- Ошибка входа --}}
        @if($errors->has('login_error'))
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $errors->first('login_error') }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label fw-bold small">Email</label>
                <div class="input-group">
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="admin@glow-up.kz"
                           value="{{ old('email') }}"
                           autofocus
                           required>
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                </div>
            </div>

            {{-- Пароль --}}
            <div class="mb-4">
                <label class="form-label fw-bold small">Пароль</label>
                <div class="input-group">
                    <input type="password"
                           name="password"
                           id="passwordInput"
                           class="form-control"
                           placeholder="••••••••"
                           required>
                    <span class="input-group-text toggle-password"
                          onclick="togglePassword()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </span>
                </div>
            </div>

            {{-- Запомнить --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox"
                           class="form-check-input"
                           name="remember"
                           id="remember">
                    <label class="form-check-label small" for="remember">
                        Запомнить меня
                    </label>
                </div>
            </div>

            {{-- Кнопка --}}
            <button type="submit" class="btn btn-primary btn-login w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                Войти в панель
            </button>

        </form>

        <div class="divider">Glow-Up Admin</div>

        <p class="text-center text-muted mb-0" style="font-size:12px;">
            <i class="bi bi-shield-lock me-1"></i>
            Доступ только для авторизованных администраторов
        </p>

    </div>

    <div class="footer-text">
        &copy; {{ date('Y') }} Glow-Up · Все права защищены
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const icon  = document.getElementById('eyeIcon');

        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>

</body>
</html>