@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3>Детали отзыва #{{ $id }}</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <p><strong>Пользователь:</strong> Иван Иванов</p>
                <p><strong>Товар:</strong> Товар 1</p>
                <p><strong>Отзыв:</strong> Очень понравилось!</p>

                <a href="{{ url('admin/reviews') }}" class="btn btn-secondary">Назад</a>
            </div>
        </div>
    </div>
</div>
@endsection
