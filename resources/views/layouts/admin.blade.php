<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Glow-Up Панель управления</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
<div class="app-wrapper">

    <!-- Navbar -->
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <!-- Sidebar toggle -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
            </ul>
            <!-- User menu -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/user2-160x160.jpg') }}"
                             class="user-image rounded-circle shadow" alt="Пользователь"/>
                        <span class="d-none d-md-inline">Glow-Up Админ</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                        <li class="user-header text-bg-primary">
                            <img src="{{ asset('assets/img/user2-160x160.jpg') }}"
                                 class="rounded-circle shadow" alt="Пользователь"/>
                            <p>
                                Glow-Up Админ - Веб-разработчик
                                <small>Участник с нояб. 2023</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <a href="#" class="btn btn-default btn-flat">Профиль</a>
                            <a href="#" class="btn btn-default btn-flat float-end">Выйти</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
            <a href="#" class="brand-link">
                <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="Glow-Up Logo"
                     class="brand-image opacity-75 shadow"/>
                <span class="brand-text fw-light">Glow-Up</span>
            </a>
        </div>
        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation">
                    <li class="nav-header">МЕНЮ</li>

                    <li class="nav-item">
                        <a href="{{ url('admin/dashboard') }}" class="nav-link">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Главная</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/products') }}" class="nav-link">
                            <i class="nav-icon bi bi-box-seam"></i>
                            <p>Товары</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/categories') }}" class="nav-link">
                            <i class="nav-icon bi bi-tags"></i>
                             <p>Категории</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/brands') }}" class="nav-link">
                            <i class="nav-icon bi bi-tags"></i>
                            <p>Бренды</p>
                        </a>
                    </li>

                    <li class="nav-item">
                    <a href="{{ url('admin/users') }}" class="nav-link">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Пользователи</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/orders') }}" class="nav-link">
                        <i class="nav-icon bi bi-receipt"></i>
                        <p>Заказы</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/reviews') }}" class="nav-link">
                        <i class="nav-icon bi bi-chat-left-text"></i>
                        <p>Отзывы</p>
                    </a>
                </li>


                </ul>
            </nav>
        </div>
    </aside>

    <!-- Main content -->
    <main class="app-main">
        @yield('content') <!-- Сюда вставляются страницы dashboard/products -->
    </main>

    <!-- Footer -->
    <footer class="app-footer">
        <strong>&copy; 2014-2025&nbsp;<a href="https://adminlte.io" class="text-decoration-none">Glow-Up</a>.</strong>
        Все права защищены.
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/js/adminlte.js') }}"></script>

</body>
</html>
