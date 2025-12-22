<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Glow-Up | Вход в админку</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap и иконки -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.css') }}">
</head>
<body class="login-page bg-body-secondary">

<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h1 class="mb-0"><b>Glow-Up</b> Админ</h1>
        </div>
        <div class="card-body login-card-body">
            <p class="login-box-msg">Войдите, чтобы начать сеанс</p>

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Пароль" required>
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Запомнить меня</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary w-100">Войти</button>
                    </div>
                </div>
            </form>

            <p class="mb-1">
                <a href="#">Забыли пароль?</a>
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
