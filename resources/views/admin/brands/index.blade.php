@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="fw-bold">Бренды</h3>
        <p class="text-muted mb-0">Одобренные партнёры маркетплейса</p>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    {{-- МЕТРИКИ --}}
    <div class="row g-3 mb-4">

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Всего брендов</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">С логотипом</p>
                    <h4 class="fw-bold mb-0">{{ $stats['with_logo'] }}</h4>
                </div>
            </div>
        </div>

    </div>

    {{-- ПОИСК --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" class="d-flex gap-2">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Поиск бренда..."
                       value="{{ request('search') }}">
                <button class="btn btn-primary px-4">Найти</button>
                @if(request('search'))
                    <a href="{{ route('admin.brands.index') }}"
                       class="btn btn-outline-secondary">
                        ✕
                    </a>
                @endif
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

    {{-- КАРТОЧКИ --}}
    <div class="row g-4">
        @forelse($brands as $brand)
            <div class="col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column align-items-center text-center">

                        {{-- Лого --}}
                        <div class="mb-3">
                            @if($brand->logo)
                                <img src="http://127.0.0.1:8001/storage/{{ $brand->logo }}"
                                     style="width:90px;height:90px;object-fit:cover;
                                            border-radius:14px;">
                            @else
                                <div style="width:90px;height:90px;border-radius:14px;
                                            background:#e9ecef;display:flex;
                                            align-items:center;justify-content:center;
                                            font-size:26px;font-weight:700;color:#6c757d;">
                                    {{ strtoupper(substr($brand->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>

                        {{-- Название --}}
                        <h6 class="fw-bold mb-1">{{ $brand->name }}</h6>

                        {{-- Партнёр --}}
                        @if($brand->partner)
                            <p class="text-muted mb-2" style="font-size:12px;">
                                <i class="bi bi-person-check me-1"></i>
                                {{ $brand->partner->email }}
                            </p>
                        @endif

                        <span class="badge bg-success mb-3">Активный бренд</span>

                        {{-- Дата --}}
                        <p class="text-muted mb-3" style="font-size:11px;">
                            Добавлен: {{ $brand->created_at->format('d.m.Y') }}
                        </p>

                        <div class="mt-auto w-100">
                            <a href="{{ route('admin.brands.show', $brand) }}"
                               class="btn btn-outline-primary btn-sm w-100">
                                Подробнее →
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                <i class="bi bi-award fs-1 d-block mb-3 opacity-25"></i>
                <h5>Брендов пока нет</h5>
                <p>Они появятся после одобрения заявок партнёров</p>
                <a href="{{ route('admin.partners.index') }}"
                   class="btn btn-outline-primary mt-2">
                    Перейти к заявкам →
                </a>
            </div>
        @endforelse
    </div>

    {{-- ПАГИНАЦИЯ --}}
    @if($brands->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <small class="text-muted">
                Показано {{ $brands->firstItem() }}–{{ $brands->lastItem() }}
                из {{ $brands->total() }}
            </small>
            {{ $brands->withQueryString()->links() }}
        </div>
    @endif

</div>
</div>

@endsection