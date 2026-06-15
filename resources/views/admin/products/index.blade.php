@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="fw-bold">Товары</h3>
        <p class="text-muted mb-0">Каталог товаров маркетплейса</p>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    {{-- МЕТРИКИ --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Всего товаров</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Со скидкой</p>
                    <h4 class="fw-bold mb-0 text-success">{{ $stats['with_discount'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Средняя цена</p>
                    <h4 class="fw-bold mb-0">
                        {{ number_format($stats['avg_price'], 0, '.', ' ') }} ₸
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Всего отзывов</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total_reviews'] }}</h4>
                </div>
            </div>
        </div>

    </div>

    {{-- ФИЛЬТРЫ --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-center">

                <div class="col-md-3">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Поиск по названию..."
                           value="{{ request('search') }}">
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

                <div class="col-md-2">
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}"
                                {{ request('category') == $category->name ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="">Новые</option>
                        <option value="price_asc"
                            {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                            Цена ↑
                        </option>
                        <option value="price_desc"
                            {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                            Цена ↓
                        </option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary w-100">Найти</button>
                    @if(request('search') || request('brand') || request('category') || request('sort'))
                        <a href="{{ route('admin.products.index') }}"
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

    {{-- ТОВАРЫ --}}
    <div class="row g-3">
        @forelse($products as $product)
            <div class="col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm h-100">

                    {{-- Картинка --}}
                    <div class="position-relative">
                        @if(!empty($product->image))
                            <img src="http://127.0.0.1:8001/storage/{{ $product->image }}"
                                 class="card-img-top"
                                 style="height:180px;object-fit:cover;">
                        @else
                            <div style="height:180px;background:#f5f5f5;
                                        display:flex;align-items:center;
                                        justify-content:center;color:#aaa;
                                        font-size:13px;">
                                <div class="text-center">
                                    <i class="bi bi-image fs-2 d-block mb-1 opacity-25"></i>
                                    Нет фото
                                </div>
                            </div>
                        @endif

                        {{-- Бейдж скидки --}}
                        @if(!empty($product->discount) && $product->discount > 0)
                            <span class="badge bg-danger position-absolute"
                                  style="top:8px;left:8px;font-size:12px;">
                                -{{ $product->discount }}%
                            </span>
                        @endif

                        {{-- Бейдж отзывов --}}
                        @if(!empty($product->reviews_count) && $product->reviews_count > 0)
                            <span class="badge bg-dark bg-opacity-50 position-absolute"
                                  style="top:8px;right:8px;font-size:11px;">
                                <i class="bi bi-chat-left-text"></i>
                                {{ $product->reviews_count }}
                            </span>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column">

                        <h6 class="fw-bold mb-1" style="font-size:14px;line-height:1.4;">
                            {{ $product->title }}
                        </h6>

                        <div class="d-flex gap-1 flex-wrap mb-2">
                            <span class="badge bg-light text-dark border"
                                  style="font-size:11px;">
                                {{ $product->brand }}
                            </span>
                            <span class="badge bg-light text-dark border"
                                  style="font-size:11px;">
                                {{ $product->category }}
                            </span>
                        </div>

                        <div class="mt-auto">
                            {{-- Цена --}}
                            <div class="d-flex align-items-baseline gap-2 mb-3">
                                @if(!empty($product->discount) && $product->discount > 0)
                                    <span class="fw-bold fs-6">
                                        {{ number_format($product->final_price, 0, '.', ' ') }} ₸
                                    </span>
                                    <span class="text-muted small text-decoration-line-through">
                                        {{ number_format($product->price, 0, '.', ' ') }} ₸
                                    </span>
                                @else
                                    <span class="fw-bold fs-6">
                                        {{ number_format($product->price, 0, '.', ' ') }} ₸
                                    </span>
                                @endif
                            </div>

                            {{-- Кнопки --}}
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.products.show', $product->id) }}"
                                   class="btn btn-outline-primary btn-sm flex-grow-1">
                                    Детали
                                </a>
                                <form action="{{ route('admin.products.delete', $product->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Удалить «{{ $product->title }}»?')">
                                    @csrf
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                <i class="bi bi-box-seam fs-1 d-block mb-3 opacity-25"></i>
                <h5>Товаров не найдено</h5>
                <p>Попробуй изменить фильтры или добавь товары через партнёров</p>
            </div>
        @endforelse
    </div>

    
  {{-- ПАГИНАЦИЯ --}}
@if($products->total() > 12)
    <div class="d-flex justify-content-between align-items-center mt-4">
        <small class="text-muted">
            Показано {{ $products->firstItem() }}–{{ $products->lastItem() }}
            из {{ $products->total() }}
        </small>
        {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
@endif

</div>
</div>

@endsection