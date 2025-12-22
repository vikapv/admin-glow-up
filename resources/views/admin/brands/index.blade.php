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
        <div class="row g-3 justify-content-center">

            {{-- Бренд 1 --}}
            <div class="col-md-4">
                <div class="card shadow-sm p-2">
                    <h6 class="text-center mb-2 fw-bold">Brand A</h6>

                    <div class="text-center mb-2">
                        <div
                            style="
                                width:150px;
                                height:150px;
                                background-color:#ddd;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-weight:bold;
                                color:#555;
                                margin:0 auto;
                                border-radius:5px;
                            "
                        >
                            Логотип
                        </div>
                    </div>

                    <div class="d-flex gap-1 justify-content-center mt-2">
                        <a href="{{ url('admin/brands/edit/1') }}" class="btn btn-sm btn-warning">
                            Редактировать
                        </a>
                        <a href="#" class="btn btn-sm btn-danger">
                            Удалить
                        </a>
                    </div>
                </div>
            </div>

            {{-- Бренд 2 --}}
            <div class="col-md-4">
                <div class="card shadow-sm p-2">
                    <h6 class="text-center mb-2 fw-bold">Brand B</h6>

                    <div class="text-center mb-2">
                        <div
                            style="
                                width:150px;
                                height:150px;
                                background-color:#ddd;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-weight:bold;
                                color:#555;
                                margin:0 auto;
                                border-radius:5px;
                            "
                        >
                            Логотип
                        </div>
                    </div>

                    <div class="d-flex gap-1 justify-content-center mt-2">
                        <a href="{{ url('admin/brands/edit/2') }}" class="btn btn-sm btn-warning">
                            Редактировать
                        </a>
                        <a href="#" class="btn btn-sm btn-danger">
                            Удалить
                        </a>
                    </div>
                </div>
            </div>

            {{-- Бренд 3 --}}
            <div class="col-md-4">
                <div class="card shadow-sm p-2">
                    <h6 class="text-center mb-2 fw-bold">Brand C</h6>

                    <div class="text-center mb-2">
                        <div
                            style="
                                width:150px;
                                height:150px;
                                background-color:#ddd;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-weight:bold;
                                color:#555;
                                margin:0 auto;
                                border-radius:5px;
                            "
                        >
                            Логотип
                        </div>
                    </div>

                    <div class="d-flex gap-1 justify-content-center mt-2">
                        <a href="{{ url('admin/brands/edit/3') }}" class="btn btn-sm btn-warning">
                            Редактировать
                        </a>
                        <a href="#" class="btn btn-sm btn-danger">
                            Удалить
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
