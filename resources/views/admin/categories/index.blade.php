@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h3>Категории</h3>
        <a href="{{ url('admin/categories/create') }}" class="btn btn-primary">
            Добавить категорию
        </a>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Название категории</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Уход за лицом</td>
                    <td>
                        <a href="{{ url('admin/categories/edit/1') }}"
                           class="btn btn-sm btn-warning">
                            Редактировать
                        </a>
                        <a href="{{ url('admin/categories') }}" class="btn btn-sm btn-danger">Удалить</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
