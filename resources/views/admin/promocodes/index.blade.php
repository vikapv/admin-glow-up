@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="fw-bold">Промокоды</h3>
        <p class="text-muted mb-0">Управление скидочными кодами</p>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    {{-- МЕТРИКИ --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Всего промокодов</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Активных</p>
                    <h4 class="fw-bold mb-0 text-success">{{ $stats['active'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Отключённых</p>
                    <h4 class="fw-bold mb-0 text-danger">{{ $stats['inactive'] }}</h4>
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

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- ФОРМА СОЗДАНИЯ --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold mb-0">Новый промокод</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.promocodes.store') }}">
                        @csrf
                        <input type="hidden" name="is_active" value="1">

                        <div class="mb-3">
                            <label class="form-label small text-muted">Код</label>
                            <input type="text"
                                   name="code"
                                   class="form-control @error('code') is-invalid @enderror"
                                   placeholder="SUMMER20"
                                   value="{{ old('code') }}"
                                   style="text-transform:uppercase;"
                                   required>
                            <div class="form-text">Код автоматически переводится в верхний регистр</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Скидка (%)</label>
                            <div class="input-group">
                                <input type="number"
                                       name="discount"
                                       class="form-control"
                                       placeholder="10"
                                       min="1"
                                       max="100"
                                       value="{{ old('discount') }}"
                                       required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-muted">
                                Лимит использований
                                <span class="text-muted">(необязательно)</span>
                            </label>
                            <input type="number"
                                   name="limit"
                                   class="form-control"
                                   placeholder="Без ограничений"
                                   min="1"
                                   value="{{ old('limit') }}">
                            <div class="form-text">Оставь пустым для неограниченного использования</div>
                        </div>

                        <button class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle me-1"></i> Создать промокод
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ТАБЛИЦА ПРОМОКОДОВ --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold mb-0">
                        Список промокодов
                        <span class="badge bg-secondary ms-1">{{ $stats['total'] }}</span>
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Код</th>
                                    <th class="text-center">Скидка</th>
                                    <th class="text-center">Лимит</th>
                                    <th class="text-center">Статус</th>
                                    <th class="text-center">Создан</th>
                                    <th class="text-center" style="width:130px;">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($promos as $promo)
                                    <tr class="{{ !$promo->is_active ? 'text-muted' : '' }}">

                                        {{-- Код --}}
                                        <td class="ps-3">
                                            <span class="fw-bold font-monospace"
                                                  style="font-size:15px;
                                                         letter-spacing:1px;">
                                                {{ $promo->code }}
                                            </span>
                                        </td>

                                        {{-- Скидка --}}
                                        <td class="text-center">
                                            <span class="badge bg-danger bg-opacity-10
                                                         text-danger fw-bold"
                                                  style="font-size:13px;">
                                                -{{ $promo->discount }}%
                                            </span>
                                        </td>

                                        {{-- Лимит --}}
                                        <td class="text-center">
                                            @if($promo->limit)
                                                <span class="badge bg-secondary">
                                                    {{ $promo->limit }} раз
                                                </span>
                                            @else
                                                <span class="text-muted small">∞</span>
                                            @endif
                                        </td>

                                        {{-- Статус --}}
                                        <td class="text-center">
                                            @if($promo->is_active)
                                                <span class="badge bg-success">Активен</span>
                                            @else
                                                <span class="badge bg-danger">Отключён</span>
                                            @endif
                                        </td>

                                        {{-- Дата --}}
                                        <td class="text-center text-muted"
                                            style="font-size:12px;">
                                            {{ $promo->created_at->format('d.m.Y') }}
                                        </td>

                                        {{-- Действия --}}
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">

                                                {{-- Вкл/Выкл --}}
                                                <form action="{{ route('admin.promocodes.toggle', $promo) }}"
                                                      method="POST">
                                                    @csrf
                                                    @if($promo->is_active)
                                                        <button class="btn btn-sm btn-outline-warning"
                                                                title="Отключить">
                                                            <i class="bi bi-pause-circle"></i>
                                                        </button>
                                                    @else
                                                        <button class="btn btn-sm btn-outline-success"
                                                                title="Активировать">
                                                            <i class="bi bi-play-circle"></i>
                                                        </button>
                                                    @endif
                                                </form>

                                                {{-- Удалить --}}
                                                <form action="{{ route('admin.promocodes.delete', $promo) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Удалить промокод «{{ $promo->code }}»?')">
                                                    @csrf
                                                    <button class="btn btn-sm btn-outline-danger"
                                                            title="Удалить">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="bi bi-ticket-perforated fs-1
                                                       d-block mb-3 opacity-25"></i>
                                            <h6>Промокодов пока нет</h6>
                                            <p class="small">
                                                Создай первый промокод с помощью формы слева
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ПАГИНАЦИЯ --}}
                @if($promos->hasPages())
                    <div class="card-footer bg-transparent
                                d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Показано {{ $promos->firstItem() }}–{{ $promos->lastItem() }}
                            из {{ $promos->total() }}
                        </small>
                        {{ $promos->withQueryString()->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>

</div>
</div>

@endsection