@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3>Отзывы</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Пользователь</th>
                    <th>Товар</th>
                    <th>Отзыв</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Иван Иванов</td>
                    <td>Товар 1</td>
                    <td>Очень понравилось!</td>
                    <td>
                        <a href="{{ url('admin/reviews/show/1') }}" class="btn btn-sm btn-info">Просмотр</a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Мария Петрова</td>
                    <td>Товар 2</td>
                    <td>Не соответствует описанию.</td>
                    <td>
                        <a href="{{ url('admin/reviews/show/2') }}" class="btn btn-sm btn-info">Просмотр</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
