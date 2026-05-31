@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="fw-bold">Пользователи</h3>
        <p class="text-muted mb-0">Управление покупателями маркетплейса</p>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    {{-- МЕТРИКИ --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Всего пользователей</p>
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
                    <p class="text-muted small mb-1">Забаненных</p>
                    <h4 class="fw-bold mb-0 text-danger">{{ $stats['banned'] }}</h4>
                </div>
            </div>
        </div>

    </div>

    {{-- ФИЛЬТРЫ --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-center">

                <div class="col-md-6">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Поиск по имени или email..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Все пользователи</option>
                        <option value="active"
                            {{ request('status') == 'active' ? 'selected' : '' }}>
                            Активные
                        </option>
                        <option value="banned"
                            {{ request('status') == 'banned' ? 'selected' : '' }}>
                            Забаненные
                        </option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary w-100">Найти</button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.users.index') }}"
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

    {{-- ТАБЛИЦА --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" style="width:60px;">#</th>
                            <th>Пользователь</th>
                            <th>Email</th>
                            <th style="width:110px;">Статус</th>
                            <th>Дата регистрации</th>
                            <th style="width:160px;">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="{{ $user->status === 'banned' ? 'table-danger' : '' }}">

                                <td class="ps-3 text-muted">{{ $user->id }}</td>

                                {{-- Аватар + имя --}}
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:36px;height:36px;border-radius:50%;
                                                    background:#e9ecef;display:flex;flex-shrink:0;
                                                    align-items:center;justify-content:center;
                                                    font-weight:600;font-size:13px;color:#555;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-bold" style="font-size:14px;">
                                            {{ $user->name }}
                                        </span>
                                    </div>
                                </td>

                                <td class="text-muted" style="font-size:14px;">
                                    {{ $user->email }}
                                </td>

                                <td>
                                    @if($user->status === 'active')
                                        <span class="badge bg-success">Активен</span>
                                    @else
                                        <span class="badge bg-danger">Забанен</span>
                                    @endif
                                </td>

                                <td class="text-muted" style="font-size:13px;">
                                    {{ $user->created_at->format('d.m.Y') }}
                                </td>

                                <td>
                                    @if($user->status === 'active')
                                        <form action="{{ route('admin.users.status', $user) }}"
                                              method="POST"
                                              onsubmit="return confirm('Забанить «{{ $user->name }}»?')">
                                            @csrf
                                            <input type="hidden" name="status" value="banned">
                                            <button class="btn btn-sm btn-outline-danger w-100">
                                                <i class="bi bi-slash-circle me-1"></i> Забанить
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.status', $user) }}"
                                              method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="active">
                                            <button class="btn btn-sm btn-outline-success w-100">
                                                <i class="bi bi-check-circle me-1"></i> Разбанить
                                            </button>
                                        </form>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-people fs-1 d-block mb-3 opacity-25"></i>
                                    <h6>Пользователи не найдены</h6>
                                    @if(request('search') || request('status'))
                                        <a href="{{ route('admin.users.index') }}"
                                           class="btn btn-sm btn-outline-secondary mt-2">
                                            Сбросить фильтры
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ПАГИНАЦИЯ --}}
        @if($users->hasPages())
            <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Показано {{ $users->firstItem() }}–{{ $users->lastItem() }}
                    из {{ $users->total() }}
                </small>
                {{ $users->withQueryString()->links() }}
            </div>
        @endif

    </div>

</div>
</div>

@endsection