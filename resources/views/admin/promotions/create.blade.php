@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-0">Новая акция</h3>
            <p class="text-muted mb-0">Добавление промоакции</p>
        </div>
        <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-secondary">
            ← Назад
        </a>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.promotions.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Название акции</label>
                            <input type="text"
                                   name="title"
                                   class="form-control form-control-lg
                                          @error('title') is-invalid @enderror"
                                   placeholder="Например: Летняя распродажа"
                                   value="{{ old('title') }}"
                                   autofocus>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Описание</label>
                            <textarea name="description"
                                      class="form-control
                                             @error('description') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Опишите условия акции...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Скидка (%)</label>
                            <div class="input-group">
                                <input type="number"
                                       name="discount"
                                       class="form-control form-control-lg
                                              @error('discount') is-invalid @enderror"
                                       placeholder="10"
                                       min="1"
                                       max="100"
                                       value="{{ old('discount') }}">
                                <span class="input-group-text fs-5">%</span>
                            </div>
                            @error('discount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="form-text">От 1 до 100%</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Категория</label>

                            <select name="category" class="form-select">
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary px-4">
                                <i class="bi bi-plus-circle me-1"></i> Создать акцию
                            </button>
                            <a href="{{ route('admin.promotions.index') }}"
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