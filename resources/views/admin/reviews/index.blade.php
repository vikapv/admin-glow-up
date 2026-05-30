@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="fw-bold">Отзывы</h3>
        <p class="text-muted mb-0">Модерация отзывов покупателей</p>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    {{-- МЕТРИКИ --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Всего отзывов</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total_reviews'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Товаров с отзывами</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total_products'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">В среднем на товар</p>
                    <h4 class="fw-bold mb-0">{{ $stats['avg_per_product'] }}</h4>
                </div>
            </div>
        </div>

    </div>

    {{-- ФИЛЬТРЫ --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-center">

                <div class="col-md-5">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Поиск по названию товара..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-4">
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

                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary w-100">Найти</button>
                    @if(request('search') || request('brand'))
                        <a href="{{ route('admin.reviews.index') }}"
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

    {{-- КАРТОЧКИ ТОВАРОВ --}}
    <div class="row g-3">
        @forelse($products as $product)
            <div class="col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">

                        {{-- Картинка товара --}}
                        <div class="text-center mb-3">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     style="width:80px;height:80px;object-fit:cover;
                                            border-radius:10px;">
                            @else
                                <div style="width:80px;height:80px;background:#f5f5f5;
                                            border-radius:10px;display:flex;
                                            align-items:center;justify-content:center;
                                            margin:0 auto;font-size:11px;color:#aaa;">
                                    нет фото
                                </div>
                            @endif
                        </div>

                        {{-- Инфо --}}
                        <h6 class="fw-bold text-center mb-1">{{ $product->title }}</h6>

                        <p class="text-center mb-3">
                            <span class="badge bg-light text-dark border small">
                                {{ $product->brand }}
                            </span>
                        </p>

                        {{-- Счётчик отзывов --}}
                        <div class="text-center mb-3 mt-auto">
                            <span class="fs-4 fw-bold">{{ $product->reviews_count }}</span>
                            <span class="text-muted small d-block">
                                {{ trans_choice('отзыв|отзыва|отзывов', $product->reviews_count) }}
                            </span>
                        </div>

                        <a href="{{ route('admin.reviews.show', $product) }}"
                           class="btn btn-primary btn-sm w-100">
                            Смотреть отзывы
                        </a>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                <i class="bi bi-chat-left-text fs-1 d-block mb-3 opacity-25"></i>
                <h5>Отзывов пока нет</h5>
                <p>Здесь появятся товары, на которые оставили отзывы</p>
            </div>
        @endforelse
    </div>

    {{-- ПАГИНАЦИЯ --}}
    @if($products->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <small class="text-muted">
                Показано {{ $products->firstItem() }}–{{ $products->lastItem() }}
                из {{ $products->total() }}
            </small>
            {{ $products->withQueryString()->links() }}
        </div>
    @endif

</div>
</div>

@endsection