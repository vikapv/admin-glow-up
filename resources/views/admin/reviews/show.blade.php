@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-0">{{ $product->title }}</h3>
            <p class="text-muted mb-0">
                Бренд:
                <span class="badge bg-light text-dark border">{{ $product->brand }}</span>
                &nbsp;·&nbsp;
                <span class="text-muted">
                    {{ $product->reviews->count() }}
                    {{ trans_choice('отзыв|отзыва|отзывов', $product->reviews->count()) }}
                </span>
            </p>
        </div>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
            ← Назад
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

    @if($product->reviews->isEmpty())
        <div class="text-center text-muted py-5">
            <i class="bi bi-chat-left-text fs-1 d-block mb-3 opacity-25"></i>
            <h5>Отзывов пока нет</h5>
        </div>
    @else

        {{-- Карточка товара --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex align-items-center gap-4">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         style="width:64px;height:64px;object-fit:cover;border-radius:10px;">
                @else
                    <div style="width:64px;height:64px;background:#f5f5f5;
                                border-radius:10px;display:flex;
                                align-items:center;justify-content:center;
                                font-size:11px;color:#aaa;flex-shrink:0;">
                        нет фото
                    </div>
                @endif
                <div>
                    <h5 class="fw-bold mb-1">{{ $product->title }}</h5>
                    <p class="text-muted mb-0 small">
                        {{ $product->brand }} · {{ $product->price }} ₸
                        @if($product->discount)
                            · <span class="text-success">скидка {{ $product->discount }}%</span>
                        @endif
                    </p>
                </div>
                <div class="ms-auto text-center">
                    <span class="fs-3 fw-bold">{{ $product->reviews->count() }}</span>
                    <p class="text-muted small mb-0">отзывов</p>
                </div>
            </div>
        </div>

        {{-- Список отзывов --}}
        <div class="row g-3">
            @foreach($product->reviews as $review)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">

                            {{-- Шапка отзыва --}}
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:38px;height:38px;border-radius:50%;
                                                background:#e9ecef;display:flex;
                                                align-items:center;justify-content:center;
                                                font-weight:600;font-size:14px;color:#666;">
                                        {{ strtoupper(substr($review->user_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="fw-bold mb-0 small">{{ $review->user_name }}</p>
                                        <p class="text-muted mb-0" style="font-size:11px;">
                                            {{ $review->created_at->format('d.m.Y') }}
                                        </p>
                                    </div>
                                </div>

                                <form action="{{ route('admin.reviews.delete', $review) }}"
                                      method="POST"
                                      onsubmit="return confirm('Удалить этот отзыв?')">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>

                            {{-- Текст отзыва --}}
                            <p class="mb-0 text-muted" style="font-size:14px;line-height:1.6;">
                                {{ $review->content }}
                            </p>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif

</div>
</div>

@endsection