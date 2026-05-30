@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="fw-bold">Заказы</h3>
        <p class="text-muted mb-0">Управление заказами маркетплейса</p>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    {{-- МЕТРИКИ --}}
    <div class="row g-3 mb-4">

        <div class="col-md-2 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Всего заказов</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total_orders'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">В обработке</p>
                    <h4 class="fw-bold mb-0 text-warning">{{ $stats['processing'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Завершённых</p>
                    <h4 class="fw-bold mb-0 text-success">{{ $stats['completed'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Товаров продано</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total_items'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Общая выручка</p>
                    <h4 class="fw-bold mb-0">
                        {{ number_format($stats['total_sum'], 0, '.', ' ') }} ₸
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Средний чек</p>
                    <h4 class="fw-bold mb-0">
                        {{ number_format(round($stats['avg_order']), 0, '.', ' ') }} ₸
                    </h4>
                </div>
            </div>
        </div>

    </div>

    {{-- ФИЛЬТРЫ --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-center">

                <div class="col-md-4">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Поиск по номеру заказа..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Все статусы</option>
                        <option value="processing"
                            {{ request('status') == 'processing' ? 'selected' : '' }}>
                            В обработке
                        </option>
                        <option value="completed"
                            {{ request('status') == 'completed' ? 'selected' : '' }}>
                            Завершённые
                        </option>
                        <option value="cancelled"
                            {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                            Отменённые
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="brand" class="form-select" onchange="this.form.submit()">
                        <option value="">Все бренды</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->name }}"
                                {{ request('brand') == $brand->name ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary w-100">Найти</button>
                    @if(request('search') || request('status') || request('brand'))
                        <a href="{{ route('admin.orders.index') }}"
                           class="btn btn-outline-secondary">
                            ✕
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ТАБЛИЦА ЗАКАЗОВ --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Товары</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Дата</th>
                            <th>Сменить статус</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-3 fw-bold text-muted">#{{ $order->id }}</td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @foreach($order->items->take(3) as $item)
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}"
                                                 style="width:32px;height:32px;object-fit:cover;
                                                        border-radius:6px;border:1px solid #eee;">
                                        @else
                                            <div style="width:32px;height:32px;background:#f1f1f1;
                                                        border-radius:6px;display:flex;
                                                        align-items:center;justify-content:center;
                                                        font-size:10px;color:#999;">
                                                нет
                                            </div>
                                        @endif
                                    @endforeach
                                    @if($order->items->count() > 3)
                                        <span class="text-muted small">
                                            +{{ $order->items->count() - 3 }}
                                        </span>
                                    @endif
                                </div>
                                <small class="text-muted">
                                    {{ $order->items->count() }}
                                    {{ trans_choice('товар|товара|товаров', $order->items->count()) }}
                                </small>
                            </td>

                            <td class="fw-bold">
                                {{ number_format($order->total_price, 0, '.', ' ') }} ₸
                            </td>

                            <td>
                                @if($order->status === 'completed')
                                    <span class="badge bg-success">Завершён</span>
                                @elseif($order->status === 'processing')
                                    <span class="badge bg-warning text-dark">В обработке</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="badge bg-danger">Отменён</span>
                                @else
                                    <span class="badge bg-secondary">{{ $order->status }}</span>
                                @endif
                            </td>

                            <td class="text-muted small">
                                {{ $order->created_at->format('d.m.Y') }}<br>
                                <span style="font-size:11px;">
                                    {{ $order->created_at->format('H:i') }}
                                </span>
                            </td>

                            <td>
                                <form action="{{ route('admin.orders.status', $order) }}"
                                      method="POST" class="d-flex gap-1">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm"
                                            style="width:140px;">
                                        <option value="processing"
                                            {{ $order->status === 'processing' ? 'selected' : '' }}>
                                            В обработке
                                        </option>
                                        <option value="completed"
                                            {{ $order->status === 'completed' ? 'selected' : '' }}>
                                            Завершён
                                        </option>
                                        <option value="cancelled"
                                            {{ $order->status === 'cancelled' ? 'selected' : '' }}>
                                            Отменён
                                        </option>
                                    </select>
                                    <button class="btn btn-sm btn-outline-primary">
                                        ✓
                                    </button>
                                </form>
                            </td>

                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    Детали →
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Заказов не найдено
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ПАГИНАЦИЯ --}}
        @if($orders->hasPages())
        <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Показано {{ $orders->firstItem() }}–{{ $orders->lastItem() }}
                из {{ $orders->total() }}
            </small>
            {{ $orders->withQueryString()->links() }}
        </div>
        @endif

    </div>

</div>
</div>

@endsection