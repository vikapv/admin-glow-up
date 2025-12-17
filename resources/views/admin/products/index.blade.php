@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h3>Товары</h3>
        <a href="{{ url('admin/products/create') }}" class="btn btn-primary">Добавить товар</a>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Фото</th>
                    <th>Цена</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Товар 1</td>
                    <td>Фото</td>
                    <td>10000</td>
                    <td>
                        <a href="{{ url('admin/products/edit/1') }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <a href="{{ url('admin/products') }}" class="btn btn-sm btn-danger">Удалить</a>
                    </td>
                </tr>
               
            </tbody>
        </table>
    </div>
</div>
@endsection
