@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3>Панель управления</h3>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    {{-- ПОИСК БРЕНДА --}}
    <form method="GET" class="mb-4">
        <select name="brand" class="form-control" onchange="this.form.submit()">
            <option value="">Выберите бренд</option>

            @foreach($brands as $brand)
                <option value="{{ $brand->name }}"
                    {{ $selectedBrand == $brand->name ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
            @endforeach

        </select>
    </form>

    {{-- СТАТИСТИКА --}}
    @if($stats)

        <div class="row g-3">

            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <p>Товары</p>
                    <h3>{{ $stats['products_count'] }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <p>Заказы</p>
                    <h3>{{ $stats['orders_count'] }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <p>Сумма заказов</p>
                    <h3>{{ $stats['total_sum'] }} ₸</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <p>Средняя цена</p>
                    <h3>{{ round($stats['average_price']) }} ₸</h3>
                </div>
            </div>

        </div>

    @else

        <div class="text-muted">
            Выберите бренд чтобы увидеть аналитику
        </div>

    @endif

</div>
</div>

@endsection