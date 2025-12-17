@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3>Добавить бренд</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Название бренда</label>
                    <input type="text" class="form-control" placeholder="Введите название бренда">
                </div>
                <div class="mb-3">
                    <label class="form-label">Логотип</label>
                    <input type="file" class="form-control">
                </div>

                <a href="{{ url('admin/brands') }}" class="btn btn-secondary">Назад</a>
                <a href="{{ url('admin/brands') }}" class="btn btn-primary">Сохранить</a>
            </div>
        </div>
    </div>
</div>
@endsection
