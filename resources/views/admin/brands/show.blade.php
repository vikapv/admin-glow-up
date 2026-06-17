@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-0">{{ $brand->name }}</h3>
            <p class="text-muted mb-0">Страница бренда</p>
        </div>
        <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary">
            ← Назад
        </a>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    <div class="row g-4">

        {{-- ЛЕВАЯ КОЛОНКА --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm mb-3 text-center">
                <div class="card-body py-4">
                    @if($brand->logo)
                        <img src="http://127.0.0.1:8001/storage/{{ $brand->logo }}"
                             style="width:130px;height:130px;object-fit:cover;
                                    border-radius:16px;margin-bottom:16px;">
                    @else
                        <div style="width:130px;height:130px;border-radius:16px;
                                    background:#e9ecef;display:flex;
                                    align-items:center;justify-content:center;
                                    font-size:38px;font-weight:700;color:#6c757d;
                                    margin:0 auto 16px;">
                            {{ strtoupper(substr($brand->name, 0, 2)) }}
                        </div>
                    @endif
                    <h5 class="fw-bold mb-2">{{ $brand->name }}</h5>
                    <span class="badge bg-success">Активный бренд</span>
                </div>
            </div>

            @if($brand->partner)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-transparent border-0 pt-3">
                        <h6 class="fw-bold mb-0">Партнёр</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm mb-0">
                            <tr>
                                <td class="text-muted">Название</td>
                                <td class="fw-bold">{{ $brand->partner->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email</td>
                                <td>
                                    <a href="mailto:{{ $brand->partner->email }}"
                                       class="text-decoration-none small">
                                        {{ $brand->partner->email }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Статус</td>
                                <td><span class="badge bg-success">Принят</span></td>
                            </tr>
                        </table>
                        <div class="mt-3">
                            <a href="{{ route('admin.partners.show', $brand->partner->id) }}"
                               class="btn btn-sm btn-outline-primary w-100">
                                Открыть заявку →
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold mb-0">Детали</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr>
                            <td class="text-muted">Добавлен</td>
                            <td>{{ \Carbon\Carbon::parse($brand->created_at)->format('d.m.Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Обновлён</td>
                            <td>{{ \Carbon\Carbon::parse($brand->updated_at)->format('d.m.Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>

        {{-- ПРАВАЯ КОЛОНКА --}}
        <div class="col-md-8">

            <div class="row g-3 mb-3">
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-3">
                            <p class="text-muted small mb-1">Товаров</p>
                            <h4 class="fw-bold mb-0">{{ $brandStats['products_count'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-3">
                            <p class="text-muted small mb-1">Заказов</p>
                            <h4 class="fw-bold mb-0">{{ $brandStats['orders_count'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-3">
                            <p class="text-muted small mb-1">Выручка</p>
                            <h5 class="fw-bold mb-0">
                                {{ number_format($brandStats['total_sum'], 0, '.', ' ') }} ₸
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-3">
                            <p class="text-muted small mb-1">Средняя цена</p>
                            <h5 class="fw-bold mb-0">
                                {{ number_format($brandStats['avg_price'], 0, '.', ' ') }} ₸
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3
                            d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">
                        Товары бренда
                        <span class="badge bg-secondary ms-1">{{ $brandStats['products_count'] }}</span>
                    </h6>
                    @if($brandStats['products_count'] > 0)
                        <a href="{{ route('admin.products.index', ['brand' => $brand->name]) }}"
                           class="btn btn-sm btn-outline-primary">
                            Все товары →
                        </a>
                    @endif
                </div>
                <div class="card-body p-0">

                    @if($products->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-box-seam fs-2 d-block mb-2 opacity-25"></i>
                            <p class="mb-0">Товаров пока нет</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3" style="width:60px;"></th>
                                        <th>Название</th>
                                        <th>Категория</th>
                                        <th class="text-end">Цена</th>
                                        <th class="text-center">Отзывы</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td class="ps-3">
                                                @if($product->image)
    <img src="http://127.0.0.1:8001/storage/{{ $product->image }}"
         style="width:40px;height:40px;
                object-fit:cover;border-radius:8px;">
                                                @else
                                                    <div style="width:40px;height:40px;
                                                                background:#f5f5f5;border-radius:8px;
                                                                display:flex;align-items:center;
                                                                justify-content:center;
                                                                font-size:10px;color:#aaa;">
                                                        нет
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="fw-bold" style="font-size:14px;">
                                                {{ $product->title }}
                                                @if($product->discount)
                                                    <span class="badge bg-danger ms-1"
                                                          style="font-size:10px;">
                                                        -{{ $product->discount }}%
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border"
                                                      style="font-size:11px;">
                                                    {{ $product->category }}
                                                </span>
                                            </td>
                                            <td class="text-end fw-bold">
                                                {{ number_format($product->price, 0, '.', ' ') }} ₸
                                            </td>
                                            <td class="text-center">
                                                @if($product->reviews_count > 0)
                                                    <span class="badge bg-secondary">
                                                        {{ $product->reviews_count }}
                                                    </span>
                                                @else
                                                    <span class="text-muted small">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.products.show', $product->id) }}"
                                                   class="btn btn-sm btn-outline-secondary">→</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($brandStats['products_count'] > 6)
                            <div class="p-3 text-center border-top">
                                <a href="{{ route('admin.products.index', ['brand' => $brand->name]) }}"
                                   class="text-muted small">
                                    Показано 6 из {{ $brandStats['products_count'] }} товаров →
                                </a>
                            </div>
                        @endif
                    @endif

                </div>
            </div>

        </div>

    </div>

</div>
</div>

@endsection