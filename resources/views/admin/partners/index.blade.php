@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="fw-bold">Партнёры</h3>
        <p class="text-muted mb-0">Заявки на подключение к маркетплейсу</p>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    {{-- МЕТРИКИ --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Всего заявок</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">На рассмотрении</p>
                    <h4 class="fw-bold mb-0 text-warning">{{ $stats['pending'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Принятых</p>
                    <h4 class="fw-bold mb-0 text-success">{{ $stats['approved'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Отклонённых</p>
                    <h4 class="fw-bold mb-0 text-danger">{{ $stats['rejected'] }}</h4>
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
                           placeholder="Поиск по названию или email..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-4">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="" {{ request('status') === null || request('status') === '' ? 'selected' : '' }}>
                            Все заявки
                        </option>
                        <option value="pending"
                            {{ request('status') == 'pending' ? 'selected' : '' }}>
                            На рассмотрении
                        </option>
                        <option value="approved"
                            {{ request('status') == 'approved' ? 'selected' : '' }}>
                            Принятые
                        </option>
                        <option value="rejected"
                            {{ request('status') == 'rejected' ? 'selected' : '' }}>
                            Отклонённые
                        </option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary w-100">Найти</button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.partners.index') }}"
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- КАРТОЧКИ --}}
    <div class="row g-4">
        @forelse($requests as $partner)
            <div class="col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">

                        <div class="text-center mb-3">
                            @if(!empty($partner->logo))
                                <img src="http://127.0.0.1:8001/storage/{{ $partner->logo }}"
                                     style="width:80px;height:80px;object-fit:cover;
                                            border-radius:12px;">
                            @else
                                <div style="width:80px;height:80px;border-radius:12px;
                                            background:#e9ecef;display:flex;
                                            align-items:center;justify-content:center;
                                            font-size:24px;font-weight:700;color:#6c757d;
                                            margin:0 auto;">
                                    {{ strtoupper(substr($partner->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>

                        <h6 class="fw-bold text-center mb-1">{{ $partner->name }}</h6>

                        <p class="text-center text-muted small mb-2">
                            {{ $partner->email }}
                        </p>

                        <div class="text-center mb-3">
                            @if($partner->status == 'pending')
                                <span class="badge bg-warning text-dark">На рассмотрении</span>
                            @elseif($partner->status == 'approved')
                                <span class="badge bg-success">Принят</span>
                            @else
                                <span class="badge bg-danger">Отклонён</span>
                            @endif
                        </div>

                        <p class="text-center text-muted mb-3" style="font-size:11px;">
                            Подано: {{ \Carbon\Carbon::parse($partner->created_at)->format('d.m.Y') }}
                        </p>

                        @if($partner->status == 'pending')
                            <div class="row g-1 mb-2">
                                <div class="col-6">
                                    <form action="{{ route('admin.partners.approve', $partner->id) }}"
                                          method="POST">
                                        @csrf
                                        <button class="btn btn-success btn-sm w-100">
                                            ✓ Принять
                                        </button>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <form action="{{ route('admin.partners.reject', $partner->id) }}"
                                          method="POST">
                                        @csrf
                                        <button class="btn btn-warning btn-sm w-100 text-dark">
                                            ✕ Откл.
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @elseif($partner->status == 'approved')
                            <div class="mb-2">
                                <form action="{{ route('admin.partners.reject', $partner->id) }}"
                                      method="POST">
                                    @csrf
                                    <button class="btn btn-outline-danger btn-sm w-100">
                                        ✕ Отклонить
                                    </button>
                                </form>
                            </div>
                        @elseif($partner->status == 'rejected')
                            <div class="mb-2">
                                <form action="{{ route('admin.partners.approve', $partner->id) }}"
                                      method="POST">
                                    @csrf
                                    <button class="btn btn-outline-success btn-sm w-100">
                                        ✓ Принять снова
                                    </button>
                                </form>
                            </div>
                        @endif

                        <div class="mt-auto d-grid gap-2">
                            <a href="{{ route('admin.partners.show', $partner->id) }}"
                               class="btn btn-outline-primary btn-sm">
                                Подробнее →
                            </a>
                            <form action="{{ route('admin.partners.delete', $partner->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Удалить заявку «{{ $partner->name }}»?')">
                                @csrf
                                <button class="btn btn-outline-danger btn-sm w-100">
                                    <i class="bi bi-trash"></i> Удалить
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                <i class="bi bi-person-plus fs-1 d-block mb-3 opacity-25"></i>
                <h5>Заявок пока нет</h5>
                <p>Здесь появятся заявки от партнёров на подключение к маркетплейсу</p>
            </div>
        @endforelse
    </div>

    {{-- ПАГИНАЦИЯ --}}
    @if($requests->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <small class="text-muted">
                Показано {{ $requests->firstItem() }}–{{ $requests->lastItem() }}
                из {{ $requests->total() }}
            </small>
            {{ $requests->links('pagination::bootstrap-5') }}
        </div>
    @endif

</div>
</div>

@endsection