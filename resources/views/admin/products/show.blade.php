@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-0">{{ $product->title }}</h3>
            <p class="text-muted mb-0">
                {{ $product->brand }} · {{ $product->category }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.index') }}"
               class="btn btn-outline-secondary">
                ← Назад
            </a>
            <form action="{{ route('admin.products.delete', $product) }}"
                  method="POST"
                  onsubmit="return confirm('Удалить «{{ $product->title }}»?')">
                @csrf
                <button class="btn btn-outline-danger">
                    <i class="bi bi-trash me-1"></i> Удалить
                </button>
            </form>
        </div>
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

        {{-- ЛЕВАЯ КОЛОНКА: фото --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             class="card-img-top"
                             style="border-radius:12px;object-fit:cover;
                                    max-height:320px;width:100%;">
                    @else
                        <div style="height:280px;background:#f5f5f5;
                                    border-radius:12px;display:flex;
                                    align-items:center;justify-content:center;
                                    color:#aaa;">
                            <div class="text-center">
                                <i class="bi bi-image fs-1 d-block mb-2 opacity-25"></i>
                                Нет фото
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ПРАВАЯ КОЛОНКА: детали + отзывы --}}
        <div class="col-md-8">

            {{-- Детали товара --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold mb-0">Информация о товаре</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr>
                            <td class="text-muted" style="width:130px;">Название</td>
                            <td class="fw-bold">{{ $product->title }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Бренд</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $product->brand }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Категория</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $product->category }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Цена</td>
                            <td class="fw-bold">
                                {{ number_format($product->price, 0, '.', ' ') }} ₸
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Скидка</td>
                            <td>
                                @if($product->discount)
                                    <span class="badge bg-danger">
                                        -{{ $product->discount }}%
                                    </span>
                                    <span class="text-success ms-2 fw-bold">
                                        {{ number_format(
                                            $product->price * (1 - $product->discount / 100),
                                            0, '.', ' '
                                        ) }} ₸
                                    </span>
                                    <span class="text-muted small ms-1">
                                        (цена со скидкой)
                                    </span>
                                @else
                                    <span class="text-muted">Нет скидки</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Отзывов</td>
                            <td>
                                {{ $product->reviews->count() }}
                                @if($product->reviews->count() > 0)
                                    <a href="{{ route('admin.reviews.show', $product) }}"
                                       class="btn btn-sm btn-outline-primary ms-2"
                                       style="font-size:11px;padding:2px 8px;">
                                        Смотреть →
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Добавлен</td>
                            <td>{{ $product->created_at->format('d.m.Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Последние отзывы --}}
            @if($product->reviews->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 pt-3 d-flex justify-content-between">
                        <h6 class="fw-bold mb-0">
                            Последние отзывы
                            <span class="badge bg-secondary ms-1">
                                {{ $product->reviews->count() }}
                            </span>
                        </h6>
                        <a href="{{ route('admin.reviews.show', $product) }}"
                           class="btn btn-sm btn-outline-primary">
                            Все отзывы →
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @foreach($product->reviews->take(3) as $review)
                            <div class="d-flex gap-3 p-3
                                {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div style="width:36px;height:36px;border-radius:50%;
                                            background:#e9ecef;display:flex;flex-shrink:0;
                                            align-items:center;justify-content:center;
                                            font-weight:600;font-size:13px;color:#666;">
                                    {{ strtoupper(substr($review->user_name, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-bold small">
                                            {{ $review->user_name }}
                                        </span>
                                        <span class="text-muted"
                                              style="font-size:11px;">
                                            {{ $review->created_at->format('d.m.Y') }}
                                        </span>
                                    </div>
                                    <p class="text-muted mb-0"
                                       style="font-size:13px;line-height:1.5;">
                                        {{ Str::limit($review->content, 120) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>
</div>

@endsection