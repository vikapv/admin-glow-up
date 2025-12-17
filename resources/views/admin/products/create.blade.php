@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3>Добавить товар</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <form action="#" method="POST">
            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Категория</label>
                <select class="form-select">
                    <option>Выберите категорию</option>
                    <option>Уход за лицом</option>
                    <option>Уход за телом</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Бренд</label>
                <select class="form-select">
                    <option>Выберите бренд</option>
                    <option>Brand A</option>
                    <option>Brand B</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Фото</label>
                <input type="file" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Цена</label>
                <input type="number" class="form-control">
            </div>

            <a href="{{ url('admin/products') }}" class="btn btn-primary">Добавить</a>
        </form>
    </div>
</div>
@endsection
