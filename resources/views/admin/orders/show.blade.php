@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3>Заказ #{{ $order->id }}</h3>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    <div class="card p-3 mb-4">

        <p><b>Статус:</b> {{ $order->status }}</p>
        <p><b>Сумма:</b> {{ $order->total_price }} ₸</p>

    </div>

    <div class="row g-3">

        @foreach($order->items as $item)

            <div class="col-md-4">

                <div class="card p-3">

                    <h5>{{ $item->title }}</h5>

                    <p>Бренд: {{ $item->brand }}</p>
                    <p>Цена: {{ $item->price }} ₸</p>
                    <p>Кол-во: {{ $item->quantity }}</p>

                </div>

            </div>

        @endforeach

    </div>

    <div class="mt-4">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-3">
    ← Назад к заказам
</a>
</div>

</div>
</div>

@endsection