@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-0">Редактировать акцию</h3>
            <p class="text-muted mb-0">{{ $promotion->title }}</p>
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

                    <form method="POST"
                          action="{{ route('admin.promotions.update', $promotion) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Название акции</label>
                            <input type="text"
                                   name="title"
                                   class="form-control form-control-lg
                                          @error('title') is-invalid @enderror"
                                   value="{{ old('title', $promotion->title) }}"
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
                                      rows="4">{{ old('description', $promotion->description) }}</textarea>
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
                                       min="1"
                                       max="100"
                                       value="{{ old('discount', $promotion->discount) }}">
                                <span class="input-group-text fs-5">%</span>
                            </div>
                            @error('discount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Категория</label>

                            <select name="category" class="form-select">
                                @foreach($categories as $category)
                                    <option
                                        value="{{ $category->name }}"
                                        {{ $promotion->category == $category->name ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Превью текущей акции --}}
                        <div class="alert alert-light border mb-4 py-2">
                            <small class="text-muted d-block mb-1">Текущие данные</small>
                            <span class="fw-bold">{{ $promotion->title }}</span>
                            <span class="badge bg-danger ms-2">
                                -{{ $promotion->discount }}%
                            </span>
                            <span class="text-muted small ms-2">
                                · создана {{ $promotion->created_at ? $promotion->created_at->format('d.m.Y') : '—' }}
                            </span>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-1"></i> Сохранить
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