@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3>Добавить категорию</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Название категории</label>
                        <input type="text"
                               class="form-control"
                               name="name"
                               placeholder="Введите название категории">
                    </div>

                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Назад</a>
                    <button class="btn btn-primary">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
