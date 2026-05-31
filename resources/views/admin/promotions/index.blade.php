@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-0">Акции и скидки</h3>
            <p class="text-muted mb-0">Управление промоакциями маркетплейса</p>
        </div>
        <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Добавить акцию
        </a>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    {{-- МЕТРИКИ --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Всего акций</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Макс. скидка</p>
                    <h4 class="fw-bold mb-0 text-danger">{{ $stats['max_discount'] }}%</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Средняя скидка</p>
                    <h4 class="fw-bold mb-0 text-warning">{{ $stats['avg_discount'] }}%</h4>
                </div>
            </div>
        </div>

    </div>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- КАРТОЧКИ АКЦИЙ --}}
    @forelse($promotions as $promotion)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="row align-items-center">

                    {{-- Бейдж скидки --}}
                    <div class="col-auto">
                        <div style="width:64px;height:64px;border-radius:12px;
                                    background:#fff3cd;display:flex;flex-direction:column;
                                    align-items:center;justify-content:center;">
                            <span class="fw-bold text-danger" style="font-size:20px;
                                                                      line-height:1;">
                                -{{ $promotion->discount }}%
                            </span>
                        </div>
                    </div>

                    {{-- Инфо --}}
                    <div class="col">
                        <h6 class="fw-bold mb-1">{{ $promotion->title }}</h6>
                        @if($promotion->description)
                            <p class="text-muted mb-0 small"
                               style="line-height:1.5;">
                                {{ Str::limit($promotion->description, 120) }}
                            </p>
                        @else
                            <p class="text-muted mb-0 small fst-italic">
                                Без описания
                            </p>
                        @endif
                    </div>

                    {{-- Дата --}}
                    <div class="col-auto text-center d-none d-md-block">
                        <p class="text-muted mb-0" style="font-size:11px;">Создана</p>
                        <p class="mb-0 small fw-bold">
                            {{ $promotion->created_at->format('d.m.Y') }}
                        </p>
                    </div>

                    {{-- Действия --}}
                    <div class="col-auto d-flex gap-2">
                        <a href="{{ route('admin.promotions.edit', $promotion) }}"
                           class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.promotions.delete', $promotion) }}"
                              method="POST"
                              onsubmit="return confirm('Удалить акцию «{{ $promotion->title }}»?')">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center text-muted py-5">
                <i class="bi bi-gift fs-1 d-block mb-3 opacity-25"></i>
                <h5>Акций пока нет</h5>
                <p>Создай первую акцию, чтобы привлечь покупателей</p>
                <a href="{{ route('admin.promotions.create') }}"
                   class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle me-1"></i> Добавить акцию
                </a>
            </div>
        </div>
    @endforelse

    {{-- ПАГИНАЦИЯ --}}
    @if($promotions->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">
                Показано {{ $promotions->firstItem() }}–{{ $promotions->lastItem() }}
                из {{ $promotions->total() }}
            </small>
            {{ $promotions->withQueryString()->links() }}
        </div>
    @endif

</div>
</div>

@endsection