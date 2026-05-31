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

            <!-- Правая часть navbar -->
            <ul class="navbar-nav ms-auto align-items-center gap-1">

                @php
                    $pendingCount = \App\Models\PartnerRequest::where('status', 'pending')->count();
                    $newOrdersCount = \App\Models\Order::where('status', 'processing')->count();
                @endphp

                {{-- Уведомление: новые заявки партнёров --}}
                <li class="nav-item">
                    <a href="{{ url('admin/partners') }}"
                       class="nav-link position-relative"
                       title="Заявки партнёров">
                        <i class="bi bi-person-plus fs-5"></i>
                        @if($pendingCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle
                                         badge rounded-pill bg-warning text-dark"
                                  style="font-size:9px;">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>
                </li>

                {{-- Уведомление: заказы в обработке --}}
                <li class="nav-item">
                    <a href="{{ url('admin/orders') }}"
                       class="nav-link position-relative"
                       title="Заказы в обработке">
                        <i class="bi bi-receipt fs-5"></i>
                        @if($newOrdersCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle
                                         badge rounded-pill bg-danger"
                                  style="font-size:9px;">
                                {{ $newOrdersCount }}
                            </span>
                        @endif
                    </a>
                </li>

                <!-- User menu -->
                <li class="nav-item dropdown user-menu ms-2">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="https://avatars.mds.yandex.net/i?id=097544486dc9cf50ecad5c17f1e7596680b1d0b4-2463541-images-thumbs&n=13"
                             class="user-image rounded-circle shadow"
                             alt="Пользователь"/>
                        <span class="d-none d-md-inline">Glow-Up Админ</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-2" style="min-width: 200px;">

    <li>
        <a href="{{ route('admin.logout') }}"
           class="btn btn-danger w-100">
            <i class="bi bi-box-arrow-right"></i>
            Выйти
        </a>
    </li>

</ul>
                </li>

            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
            <a href="{{ url('admin/dashboard') }}" class="brand-link">
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
                        <a href="{{ url('admin/dashboard') }}"
                           class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Главная</p>
                        </a>
                    </li>

                    <li class="nav-header">КАТАЛОГ</li>

                    <li class="nav-item">
                        <a href="{{ url('admin/categories') }}"
                           class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-tags"></i>
                            <p>Категории</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/brands') }}"
                           class="nav-link {{ request()->is('admin/brands*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-award"></i>
                            <p>Бренды</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/products') }}"
                           class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-box-seam"></i>
                            <p>Товары</p>
                        </a>
                    </li>

                    <li class="nav-header">ПРОДАЖИ</li>

                    <li class="nav-item">
                        <a href="{{ url('admin/orders') }}"
                           class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-receipt"></i>
                            <p>
                                Заказы
                                @if($newOrdersCount > 0)
                                    <span class="badge bg-danger ms-auto">
                                        {{ $newOrdersCount }}
                                    </span>
                                @endif
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/promotions') }}"
                           class="nav-link {{ request()->is('admin/promotions*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-gift"></i>
                            <p>Акции</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/promocodes') }}"
                           class="nav-link {{ request()->is('admin/promocodes*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-ticket-perforated"></i>
                            <p>Промокоды</p>
                        </a>
                    </li>

                    <li class="nav-header">ПОЛЬЗОВАТЕЛИ</li>

                    <li class="nav-item">
                        <a href="{{ url('admin/users') }}"
                           class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-people"></i>
                            <p>Пользователи</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('admin/partners') }}"
                           class="nav-link {{ request()->is('admin/partners*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-plus"></i>
                            <p>
                                Партнёры
                                @if($pendingCount > 0)
                                    <span class="badge bg-warning text-dark ms-auto">
                                        {{ $pendingCount }}
                                    </span>
                                @endif
                            </p>
                        </a>
                    </li>

                    <li class="nav-header">ДОПОЛНИТЕЛЬНО</li>

                    <li class="nav-item">
                        <a href="{{ url('admin/reviews') }}"
                           class="nav-link {{ request()->is('admin/reviews*') ? 'active' : '' }}">
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

        {{-- Глобальные flash --}}
        @if(session('success') || session('error'))
            <div class="container-fluid pt-3 px-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-0">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-0">
                        <i class="bi bi-exclamation-circle me-1"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="app-footer">
        <strong>&copy; {{ date('Y') }}&nbsp;<span class="text-decoration-none">Glow-Up</span>.</strong>
        Все права защищены.
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/js/adminlte.js') }}"></script>

{{-- Автозакрытие flash через 4 секунды --}}
<script>
    setTimeout(() => {
        document.querySelectorAll('.alert.fade.show').forEach(el => {
            bootstrap.Alert.getOrCreateInstance(el).close();
        });
    }, 4000);
</script>

</body>
</html>