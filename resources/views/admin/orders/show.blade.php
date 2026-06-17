@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-0">Заказ #{{ $order->id }}</h3>
            <p class="text-muted mb-0">
                {{ $order->created_at->format('d.m.Y в H:i') }}
            </p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            ← Назад к заказам
        </a>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- ЛЕВАЯ КОЛОНКА --}}
        <div class="col-md-4">

            {{-- Информация о заказе --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold mb-0">Информация о заказе</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr>
                            <td class="text-muted">Номер</td>
                            <td class="fw-bold">#{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Сумма</td>
                            <td class="fw-bold">
                                {{ number_format($order->total_price, 0, '.', ' ') }} ₸
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Товаров</td>
                            <td>{{ $order->items->count() }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Дата</td>
                            <td>{{ $order->created_at->format('d.m.Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Статус</td>
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
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Пользователь --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold mb-0">Покупатель</h6>
                </div>
                <div class="card-body">
                    @if($order->user)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div style="width:44px;height:44px;border-radius:50%;
                                        background:#e9ecef;display:flex;flex-shrink:0;
                                        align-items:center;justify-content:center;
                                        font-weight:700;font-size:16px;color:#555;">
                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="fw-bold mb-0">{{ $order->user->name }}</p>
                                <p class="text-muted small mb-0">
                                    ID #{{ $order->user->id }}
                                </p>
                            </div>
                        </div>
                        <table class="table table-sm mb-0">
                            <tr>
                                <td class="text-muted">Email</td>
                                <td>
                                    <a href="mailto:{{ $order->user->email }}"
                                       class="text-decoration-none small">
                                        {{ $order->user->email }}
                                    </a>
                                </td>
                            </tr>
                            @if($order->user->phone)
                            <tr>
                                <td class="text-muted">Телефон</td>
                                <td class="small">{{ $order->user->phone }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-muted">Статус</td>
                                <td>
                                    @if($order->user->status === 'active')
                                        <span class="badge bg-success">Активен</span>
                                    @else
                                        <span class="badge bg-danger">Забанен</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Регистрация</td>
                                <td class="small">
                                    {{ $order->user->created_at->format('d.m.Y') }}
                                </td>
                            </tr>
                        </table>
                    @else
                        <p class="text-muted mb-0">
                            <i class="bi bi-person-x me-1"></i>
                            Пользователь удалён или не найден
                        </p>
                    @endif
                </div>
            </div>

            {{-- Смена статуса --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold mb-0">Сменить статус</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                        @csrf
                        <select name="status" class="form-select mb-3">
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
                        <button class="btn btn-primary w-100">
                            Сохранить статус
                        </button>
                    </form>
                </div>
            </div>

        </div>

        {{-- ПРАВАЯ КОЛОНКА: товары --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold mb-0">
                        Товары в заказе
                        <span class="badge bg-secondary ms-1">
                            {{ $order->items->count() }}
                        </span>
                    </h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3" style="width:60px;"></th>
                                <th>Товар</th>
                                <th>Бренд</th>
                                <th class="text-center">Кол-во</th>
                                <th class="text-end pe-3">Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="ps-3">
                                    @if($item->image)
                                        <img src="http://127.0.0.1:8001/storage/{{ $item->image }}"
                                             style="width:44px;height:44px;
                                                    object-fit:cover;border-radius:8px;">
                                    @else
                                        <div style="width:44px;height:44px;background:#f5f5f5;
                                                    border-radius:8px;display:flex;
                                                    align-items:center;justify-content:center;
                                                    font-size:10px;color:#aaa;">
                                            нет
                                        </div>
                                    @endif
                                </td>
                                <td class="fw-bold">{{ $item->title }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $item->brand }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">
                                        × {{ $item->quantity }}
                                    </span>
                                </td>
                                <td class="text-end pe-3 fw-bold">
                                    {{ number_format($item->price * $item->quantity, 0, '.', ' ') }} ₸
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end fw-bold pe-3 py-3">
                                    Итого:
                                </td>
                                <td class="text-end fw-bold pe-3 py-3 fs-5">
                                    {{ number_format($order->total_price, 0, '.', ' ') }} ₸
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
</div>

@endsection