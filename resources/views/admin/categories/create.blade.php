@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-0">Новая категория</h3>
            <p class="text-muted mb-0">Добавление категории товаров</p>
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

                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">Название категории</label>
                            <input type="text"
                                   class="form-control form-control-lg
                                          @error('name') is-invalid @enderror"
                                   name="name"
                                   placeholder="Например: Сыворотки, Тоники..."
                                   value="{{ old('name') }}"
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Название будет отображаться в каталоге товаров
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary px-4">
                                <i class="bi bi-plus-circle me-1"></i> Добавить
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