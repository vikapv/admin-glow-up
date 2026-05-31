@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="fw-bold">Поддержка</h3>
        <p class="text-muted mb-0">Обращения пользователей</p>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    {{-- МЕТРИКИ --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Всего</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Новых</p>
                    <h4 class="fw-bold mb-0 text-danger">{{ $stats['new'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">В работе</p>
                    <h4 class="fw-bold mb-0 text-warning">{{ $stats['in_progress'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Решено</p>
                    <h4 class="fw-bold mb-0 text-success">{{ $stats['resolved'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- ФИЛЬТРЫ --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control"
                           placeholder="Поиск по email или теме..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Все обращения</option>
                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Новые</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>В работе</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Решённые</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary w-100">Найти</button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.support.index') }}" class="btn btn-outline-secondary">✕</a>
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
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Email</th>
                        <th>Тема</th>
                        <th class="text-center">Статус</th>
                        <th>Дата</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td class="ps-3 text-muted">{{ $ticket->id }}</td>
                        <td>{{ $ticket->email }}</td>
                        <td class="fw-bold">{{ $ticket->subject }}</td>
                        <td class="text-center">
                            @if($ticket->status === 'new')
                                <span class="badge bg-danger">Новое</span>
                            @elseif($ticket->status === 'in_progress')
                                <span class="badge bg-warning text-dark">В работе</span>
                            @else
                                <span class="badge bg-success">Решено</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.support.show', $ticket) }}"
                               class="btn btn-sm btn-outline-primary">
                                Открыть →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-headset fs-1 d-block mb-3 opacity-25"></i>
                            <h6>Обращений пока нет</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tickets->hasPages())
        <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Показано {{ $tickets->firstItem() }}–{{ $tickets->lastItem() }}
                из {{ $tickets->total() }}
            </small>
            {{ $tickets->withQueryString()->links() }}
        </div>
        @endif
    </div>

</div>
</div>
@endsection