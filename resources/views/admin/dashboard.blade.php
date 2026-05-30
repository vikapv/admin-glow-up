@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3>Аналитика брендов</h3>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    {{-- 🔎 SEARCH --}}
    <form method="GET" class="mb-4">

        <div class="input-group">

            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Поиск бренда..."
                value="{{ request('search') }}"
            >

            <button class="btn btn-primary">
                Найти
            </button>

        </div>

    </form>

    {{-- 📊 CARDS --}}
    <div class="row g-3">

        @forelse($data as $item)

            <div class="col-md-6 col-lg-4">

                <div class="card shadow-sm p-3 h-100">

                    <h4 class="mb-3">{{ $item['brand'] }}</h4>

                    <div class="row">

                        <div class="col-6">
                            <p class="text-muted">Товары</p>
                            <h5>{{ $item['products_count'] }}</h5>
                        </div>

                        <div class="col-6">
                            <p class="text-muted">Заказы</p>
                            <h5>{{ $item['orders_count'] }}</h5>
                        </div>

                        <div class="col-6 mt-3">
                            <p class="text-muted">Сумма заказов</p>
                            <h5>{{ $item['total_sum'] }} ₸</h5>
                        </div>

                        <div class="col-6 mt-3">
                            <p class="text-muted">Средняя цена</p>
                            <h5>{{ round($item['average_price']) }} ₸</h5>
                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12 text-center text-muted">
                Бренды не найдены
            </div>

        @endforelse

    </div>

</div>
</div>

@endsection