@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-0">Категории</h3>
            <p class="text-muted mb-0">Управление категориями товаров</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Добавить категорию
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
                    <p class="text-muted small mb-1">Всего категорий</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">С товарами</p>
                    <h4 class="fw-bold mb-0 text-success">{{ $stats['with_products'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1">Пустых</p>
                    <h4 class="fw-bold mb-0 text-warning">{{ $stats['empty'] }}</h4>
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ПОИСК --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" class="d-flex gap-2">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Поиск по названию..."
                       value="{{ request('search') }}">
                <button class="btn btn-primary px-4">Найти</button>
                @if(request('search'))
                    <a href="{{ route('admin.categories.index') }}"
                       class="btn btn-outline-secondary">
                        ✕
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- ТАБЛИЦА --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width:60px;">#</th>
                        <th>Название категории</th>
                        <th class="text-center" style="width:120px;">Товаров</th>
                        <th class="text-center" style="width:80px;">Статус</th>
                        <th style="width:180px;">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="ps-3 text-muted">{{ $category->id }}</td>

                            <td>
                                <span class="fw-bold">{{ $category->name }}</span>
                            </td>

                            <td class="text-center">
                                @if($category->products_count > 0)
                                    <a href="{{ route('admin.products.index', ['category' => $category->name]) }}"
                                       class="badge bg-primary bg-opacity-10 text-primary
                                              text-decoration-none">
                                        {{ $category->products_count }}
                                    </a>
                                @else
                                    <span class="text-muted small">0</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if($category->products_count > 0)
                                    <span class="badge bg-success">Активна</span>
                                @else
                                    <span class="badge bg-warning text-dark">Пустая</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('admin.categories.delete', $category) }}"
                                          method="POST"
                                          onsubmit="return confirm('Удалить категорию «{{ $category->name }}»?')">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger"
                                                {{ $category->products_count > 0 ? 'disabled' : '' }}
                                                title="{{ $category->products_count > 0 ? 'Нельзя удалить — есть товары' : 'Удалить' }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-tags fs-1 d-block mb-3 opacity-25"></i>
                                <h6>Категорий не найдено</h6>
                                @if(request('search'))
                                    <a href="{{ route('admin.categories.index') }}"
                                       class="btn btn-sm btn-outline-secondary mt-2">
                                        Сбросить поиск
                                    </a>
                                @else
                                    <a href="{{ route('admin.categories.create') }}"
                                       class="btn btn-sm btn-primary mt-2">
                                        Добавить первую категорию
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ПАГИНАЦИЯ --}}
        @if($categories->hasPages())
            <div class="card-footer bg-transparent
                        d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Показано {{ $categories->firstItem() }}–{{ $categories->lastItem() }}
                    из {{ $categories->total() }}
                </small>
                {{ $categories->withQueryString()->links() }}
            </div>
        @endif

    </div>

</div>
</div>

@endsection