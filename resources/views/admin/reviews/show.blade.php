@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3>Детали отзыва #{{ $id }}</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="row">

                    {{-- Левая часть: информация --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <span class="text-muted">Пользователь</span>
                            <h6 class="fw-bold">Иван Иванов</h6>
                        </div>

                        <div class="mb-3">
                            <span class="text-muted">Товар</span>
                            <h6 class="fw-bold">Товар 1</h6>
                        </div>

                        <div class="mb-3">
                            <span class="text-muted">Отзыв</span>
                            <div class="border rounded p-3 mt-1 bg-light">
                                Очень понравилось!
                            </div>
                        </div>
                    </div>

                    {{-- Правая часть: фото товара --}}
                    <div class="col-md-6 text-center">
                        <span class="text-muted d-block mb-2">Фото товара</span>

                        <div
                            style="
                                width:200px;
                                height:200px;
                                background-color:#ddd;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-weight:bold;
                                color:#555;
                                margin:0 auto;
                                border-radius:8px;
                            "
                        >
                            Фото
                        </div>
                    </div>

                </div>

                <div class="mt-4">
                    <a href="{{ url('admin/reviews') }}" class="btn btn-secondary">
                        Назад к списку
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
