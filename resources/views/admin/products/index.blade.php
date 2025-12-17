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
        <div class="row g-3 justify-content-center">

            {{-- Товар 1 --}}
            <div class="col-md-4">
                <div class="card shadow-sm p-2">
                    <h6 class="text-center mb-2 fw-bold">Товар 1</h6>
                    <div class="text-center mb-2">
                        <div style="width:150px; height:150px; background-color:#ddd; display:flex; align-items:center; justify-content:center; font-weight:bold; color:#555; margin:0 auto; border-radius:5px;">
                            Фото
                        </div>
                    </div>
                    <p class="mb-1 small"><strong>Категория:</strong> Уход за лицом</p>
                    <p class="mb-1 small"><strong>Бренд:</strong> Brand A</p>
                    <p class="mb-1 small"><strong>Цена:</strong> 10 000 тг</p>
                    <p class="mb-1 small"><strong>Акция / Скидка:</strong> Нет акции</p>
                    <div class="d-flex gap-1 mt-2 justify-content-center">
                        <a href="{{ url('admin/products/edit/1') }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <a href="{{ url('admin/products') }}" class="btn btn-sm btn-danger">Удалить</a>
                    </div>
                </div>
            </div>

            {{-- Товар 2 --}}
            <div class="col-md-4">
                <div class="card shadow-sm p-2">
                    <h6 class="text-center mb-2 fw-bold">Товар 2</h6>
                    <div class="text-center mb-2">
                        <div style="width:150px; height:150px; background-color:#ddd; display:flex; align-items:center; justify-content:center; font-weight:bold; color:#555; margin:0 auto; border-radius:5px;">
                            Фото
                        </div>
                    </div>
                    <p class="mb-1 small"><strong>Категория:</strong> Уход за телом</p>
                    <p class="mb-1 small"><strong>Бренд:</strong> Brand B</p>
                    <p class="mb-1 small"><strong>Цена:</strong> 15 000 тг</p>
                    <p class="mb-1 small"><strong>Акция / Скидка:</strong> Летняя акция - 10%</p>
                    <div class="d-flex gap-1 mt-2 justify-content-center">
                        <a href="{{ url('admin/products/edit/2') }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <a href="{{ url('admin/products') }}" class="btn btn-sm btn-danger">Удалить</a>
                    </div>
                </div>
            </div>

            {{-- Товар 3 --}}
            <div class="col-md-4">
                <div class="card shadow-sm p-2">
                    <h6 class="text-center mb-2 fw-bold">Товар 3</h6>
                    <div class="text-center mb-2">
                        <div style="width:150px; height:150px; background-color:#ddd; display:flex; align-items:center; justify-content:center; font-weight:bold; color:#555; margin:0 auto; border-radius:5px;">
                            Фото
                        </div>
                    </div>
                    <p class="mb-1 small"><strong>Категория:</strong> Уход за телом</p>
                    <p class="mb-1 small"><strong>Бренд:</strong> Brand C</p>
                    <p class="mb-1 small"><strong>Цена:</strong> 18 000 тг</p>
                    <p class="mb-1 small"><strong>Акция / Скидка:</strong> Летняя акция - 15%</p>
                    <div class="d-flex gap-1 mt-2 justify-content-center">
                        <a href="{{ url('admin/products/edit/3') }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <a href="{{ url('admin/products') }}" class="btn btn-sm btn-danger">Удалить</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
