@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h3>Бренды</h3>
        <a href="{{ url('admin/brands/create') }}" class="btn btn-primary">
            Добавить бренд
        </a>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Название бренда</th>
                    <th>Логотип</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Бренд 1</td>
                    <td>Логотип</td>
                    <td>
                        <a href="{{ url('admin/brands/edit/1') }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <a href="#" class="btn btn-sm btn-danger">Удалить</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
