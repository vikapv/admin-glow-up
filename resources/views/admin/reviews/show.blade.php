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
                    <img src="http://127.0.0.1:8001/storage/{{ $product->image }}"
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

        {{-- Тулбар: поиск + сортировка --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body py-3">
                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" id="reviewSearch" class="form-control border-start-0"
                                   placeholder="Поиск по автору или тексту отзыва...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select id="reviewSort" class="form-select">
                            <option value="newest">Сначала новые</option>
                            <option value="oldest">Сначала старые</option>
                            <option value="name">По имени автора</option>
                        </select>
                    </div>
                    <div class="col-md-3 text-md-end">
                        <small class="text-muted" id="reviewCount">
                            Показано {{ $product->reviews->count() }} из {{ $product->reviews->count() }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Список отзывов --}}
        <div class="row g-3" id="reviewsContainer">
            @php
                $avatarPalette = [
                    ['bg' => '#FDE7E9', 'fg' => '#C2435A'],
                    ['bg' => '#E5F0FF', 'fg' => '#3768C2'],
                    ['bg' => '#E6F7EC', 'fg' => '#2E9156'],
                    ['bg' => '#FFF4DE', 'fg' => '#B8862E'],
                    ['bg' => '#F1E9FF', 'fg' => '#7A4FCE'],
                    ['bg' => '#E2F8F6', 'fg' => '#1E9C92'],
                    ['bg' => '#FFE9F3', 'fg' => '#C24690'],
                    ['bg' => '#EAEDFB', 'fg' => '#5563C1'],
                ];
            @endphp
            @foreach($product->reviews as $review)
                @php
                    $colorIndex = crc32($review->user_name) % count($avatarPalette);
                    $avatarColor = $avatarPalette[$colorIndex];
                    $isNew = $review->created_at->diffInHours(now()) <= 48;
                    $searchPayload = mb_strtolower($review->user_name . ' ' . $review->content);
                @endphp
                <div class="col-md-6 review-item"
                     data-search="{{ $searchPayload }}"
                     data-date="{{ $review->created_at->timestamp }}"
                     data-name="{{ mb_strtolower($review->user_name) }}">
                    <div class="card border-0 shadow-sm h-100 review-card">
                        <div class="card-body">

                            {{-- Шапка отзыва --}}
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:38px;height:38px;border-radius:50%;
                                                background:{{ $avatarColor['bg'] }};display:flex;
                                                align-items:center;justify-content:center;
                                                font-weight:600;font-size:14px;color:{{ $avatarColor['fg'] }};
                                                flex-shrink:0;">
                                        {{ strtoupper(substr($review->user_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="fw-bold mb-0 small d-flex align-items-center gap-2">
                                            {{ $review->user_name }}
                                            @if($isNew)
                                                <span class="badge bg-success-subtle text-success border border-success-subtle"
                                                      style="font-size:10px;">
                                                    Новый
                                                </span>
                                            @endif
                                        </p>
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
                            <div class="position-relative">
                                <i class="bi bi-quote text-muted opacity-25"
                                   style="font-size:22px;line-height:1;"></i>
                                <p class="mb-1 text-muted review-text" style="font-size:14px;line-height:1.6;">
                                    {{ $review->content }}
                                </p>
                                <a href="#" class="small read-more-toggle d-none">Читать полностью</a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Пустой результат поиска --}}
        <div class="col-12 text-center text-muted py-5 d-none" id="noResultsMessage">
            <i class="bi bi-search fs-1 d-block mb-3 opacity-25"></i>
            <h5>Ничего не найдено</h5>
            <p>Попробуй изменить запрос</p>
        </div>

    @endif

</div>
</div>

<style>
    .review-text {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .review-text.expanded {
        -webkit-line-clamp: unset;
        overflow: visible;
    }
    .review-card {
        transition: box-shadow .15s ease, transform .15s ease;
    }
    .review-card:hover {
        box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.08) !important;
        transform: translateY(-2px);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('reviewsContainer');
    if (!container) return;

    const searchInput = document.getElementById('reviewSearch');
    const sortSelect = document.getElementById('reviewSort');
    const countEl = document.getElementById('reviewCount');
    const noResultsMessage = document.getElementById('noResultsMessage');

    function getItems() {
        return Array.from(container.querySelectorAll('.review-item'));
    }

    function applyFilters() {
        const query = searchInput.value.trim().toLowerCase();
        const items = getItems();
        let visible = 0;

        items.forEach(function (item) {
            const matches = item.dataset.search.includes(query);
            item.style.display = matches ? '' : 'none';
            if (matches) visible++;
        });

        countEl.textContent = 'Показано ' + visible + ' из ' + items.length;
        noResultsMessage.classList.toggle('d-none', visible !== 0);
    }

    function applySort() {
        const value = sortSelect.value;
        const items = getItems();

        items.sort(function (a, b) {
            if (value === 'oldest') return a.dataset.date - b.dataset.date;
            if (value === 'name') return a.dataset.name.localeCompare(b.dataset.name, 'ru');
            return b.dataset.date - a.dataset.date;
        });

        items.forEach(function (item) { container.appendChild(item); });
    }

    function setupReadMore() {
        document.querySelectorAll('.review-text').forEach(function (textEl) {
            const toggle = textEl.nextElementSibling;
            if (!toggle) return;

            if (textEl.scrollHeight > textEl.clientHeight + 2) {
                toggle.classList.remove('d-none');
                toggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    const expanded = textEl.classList.toggle('expanded');
                    toggle.textContent = expanded ? 'Свернуть' : 'Читать полностью';
                });
            }
        });
    }

    searchInput.addEventListener('input', applyFilters);
    sortSelect.addEventListener('change', applySort);

    setupReadMore();
});
</script>

@endsection