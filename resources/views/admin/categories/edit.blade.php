@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-0">Редактировать категорию</h3>
            <p class="text-muted mb-0">{{ $category->name }}</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            ← Назад
        </a>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('admin.categories.update', $category) }}"
                          method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">Название категории</label>
                            <input type="text"
                                   class="form-control form-control-lg
                                          @error('name') is-invalid @enderror"
                                   name="name"
                                   value="{{ old('name', $category->name) }}"
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Инфо о товарах в категории --}}
                        @php
                            $productsCount = \App\Models\Product::where('category', $category->name)->count();
                        @endphp

                        @if($productsCount > 0)
                            <div class="alert alert-warning py-2 mb-4">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                В этой категории {{ $productsCount }} товаров.
                                При переименовании товары останутся со старым названием категории.
                            </div>
                        @endif

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-1"></i> Сохранить
                            </button>
                            <a href="{{ route('admin.categories.index') }}"
                               class="btn btn-outline-secondary">
                                Отмена
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

@endsection