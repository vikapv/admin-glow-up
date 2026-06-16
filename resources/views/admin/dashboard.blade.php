@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="fw-bold">Главная</h3>
        <p class="text-muted mb-0">Добро пожаловать в панель управления Glow-Up</p>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    {{-- ГЛОБАЛЬНЫЕ МЕТРИКИ --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small">Всего заказов</span>
                        <span class="bg-primary bg-opacity-10 text-primary rounded p-1">
                            <i class="bi bi-receipt fs-5"></i>
                        </span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $globalStats['total_orders'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small">Выручка</span>
                        <span class="bg-success bg-opacity-10 text-success rounded p-1">
                            <i class="bi bi-currency-exchange fs-5"></i>
                        </span>
                    </div>
                    <h3 class="fw-bold mb-0">
                        {{ number_format($globalStats['total_revenue'], 0, '.', ' ') }} ₸
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small">Пользователи</span>
                        <span class="bg-info bg-opacity-10 text-info rounded p-1">
                            <i class="bi bi-people fs-5"></i>
                        </span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $globalStats['total_users'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small">Заявки партнёров</span>
                        <span class="bg-warning bg-opacity-10 text-warning rounded p-1">
                            <i class="bi bi-person-plus fs-5"></i>
                        </span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $globalStats['pending_partners'] }}</h3>
                    @if($globalStats['pending_partners'] > 0)
                        <small class="text-warning">ожидают решения</small>
                    @else
                        <small class="text-muted">нет новых</small>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- ПОСЛЕДНИЕ ЗАКАЗЫ + ОЖИДАЮЩИЕ ПАРТНЁРЫ --}}
    <div class="row g-3 mb-4">

        {{-- Последние заказы --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-3">
                    <h6 class="fw-bold mb-0">Последние заказы</h6>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">
                        Все заказы
                    </a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Товаров</th>
                                <th>Сумма</th>
                                <th>Статус</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td class="ps-3 fw-bold">#{{ $order->id }}</td>
                                <td>{{ $order->items->count() }}</td>
                                <td>{{ number_format($order->total_price, 0, '.', ' ') }} ₸</td>
                                <td>
                                    @if($order->status === 'completed')
                                        <span class="badge bg-success">Завершён</span>
                                    @elseif($order->status === 'processing')
                                        <span class="badge bg-warning text-dark">В обработке</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        →
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Заказов пока нет
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Ожидающие партнёры --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-3">
                    <h6 class="fw-bold mb-0">Заявки партнёров</h6>
                    <a href="{{ route('admin.partners.index') }}" class="btn btn-sm btn-outline-primary">
                        Все заявки
                    </a>
                </div>
                <div class="card-body">
                    @forelse($pendingPartners as $partner)
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            @if($partner->logo)
                                <img src="http://127.0.0.1:8001/storage/{{ $partner->logo }}"
                                     style="width:38px;height:38px;object-fit:cover;border-radius:8px;">
                            @else
                                <div style="width:38px;height:38px;background:#f1f1f1;
                                            border-radius:8px;display:flex;
                                            align-items:center;justify-content:center;
                                            font-weight:600;font-size:14px;color:#888;">
                                    {{ strtoupper(substr($partner->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <p class="mb-0 fw-bold small">{{ $partner->name }}</p>
                                <p class="mb-0 text-muted" style="font-size:11px;">
                                    {{ $partner->email }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('admin.partners.show', $partner) }}"
                           class="btn btn-sm btn-outline-primary">
                            Просмотр
                        </a>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        <i class="bi bi-check-circle fs-4 d-block mb-1"></i>
                        Новых заявок нет
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    {{-- АНАЛИТИКА БРЕНДОВ --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 pt-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Аналитика по брендам</h6>
                <form method="GET" class="d-flex gap-2">
                    <input type="text"
                           name="search"
                           class="form-control form-control-sm"
                           placeholder="Поиск бренда..."
                           value="{{ request('search') }}"
                           style="width: 200px;">
                    <button class="btn btn-sm btn-primary">Найти</button>
                    @if(request('search'))
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                            Сбросить
                        </a>
                    @endif
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Бренд</th>
                            <th class="text-center">Товары</th>
                            <th class="text-center">Заказы</th>
                            <th class="text-center">Сумма заказов</th>
                            <th class="text-center">Средняя цена</th>
                            <th class="text-center">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-bold">{{ $item['brand'] }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {{ $item['products_count'] }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    {{ $item['orders_count'] }}
                                </span>
                            </td>
                            <td class="text-center fw-bold">
                                {{ number_format($item['total_sum'], 0, '.', ' ') }} ₸
                            </td>
                            <td class="text-center text-muted">
                                {{ round($item['average_price']) }} ₸
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.brands.show', $item['id']) }}"
                                class="btn btn-sm btn-outline-secondary">
                                    Подробнее
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Бренды не найдены
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</div>

@endsection