@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3>Заказы</h3>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    {{-- 📊 STATS --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card p-3">
                <p>Всего заказов</p>
                <h4>{{ $stats['total_orders'] }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3">
                <p>Общая сумма</p>
                <h4>{{ $stats['total_sum'] }} ₸</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3">
                <p>Товаров продано</p>
                <h4>{{ $stats['total_items'] }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3">
                <p>Средний чек</p>
                <h4>{{ round($stats['avg_order']) }} ₸</h4>
            </div>
        </div>

    </div>

    {{-- 🔎 FILTER --}}
    <form method="GET" class="mb-4">

        <select name="brand" class="form-control" onchange="this.form.submit()">

            <option value="">Все бренды</option>

            @foreach($brands as $brand)
                <option value="{{ $brand->name }}"
                    {{ request('brand') == $brand->name ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
            @endforeach

        </select>

    </form>

    {{-- 📦 ORDERS --}}
    <div class="row g-3">

        @forelse($orders as $order)

            <div class="col-md-6">

                <div class="card p-3 shadow-sm">

                    <h5>Заказ #{{ $order->id }}</h5>

                    <p><b>Статус:</b> {{ $order->status }}</p>

                    <p><b>Сумма:</b> {{ $order->total_price }} ₸</p>

                    <p><b>Товаров:</b> {{ $order->items->count() }}</p>

                    <a href="{{ route('admin.orders.show', $order) }}"
                       class="btn btn-primary btn-sm">
                        Подробнее
                    </a>

                </div>

            </div>

        @empty

            <p>Заказов нет</p>

        @endforelse

    </div>

</div>
</div>

@endsection