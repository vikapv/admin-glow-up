@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3>Просмотр бренда</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        <div class="card p-4 text-center">

            <h2 class="mb-3">{{ $brand->name }}</h2>

            @if($brand->logo)
                <img src="{{ asset($brand->logo) }}"
                     style="width:200px;height:200px;object-fit:cover;border-radius:10px;">
            @else
                <div style="width:200px;height:200px;background:#ddd;
                            display:flex;align-items:center;justify-content:center;
                            border-radius:10px;">
                    Нет изображения
                </div>
            @endif

            <hr>

            <a href="{{ route('admin.brands.index') }}"
               class="btn btn-secondary mt-3">
                Назад
            </a>

        </div>

    </div>
</div>
@endsection