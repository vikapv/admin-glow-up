@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3>Бренды</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row g-3">

            @forelse($brands as $brand)
                <div class="col-md-4">
                    <div class="card shadow-sm p-3 text-center">

                        <h5 class="fw-bold mb-2">{{ $brand->name }}</h5>

                        @if($brand->logo)
                            <img src="{{ asset($brand->logo) }}"
                                 style="width:150px;height:150px;object-fit:cover;border-radius:6px;">
                        @else
                            <div style="width:150px;height:150px;background:#ddd;
                                        display:flex;align-items:center;justify-content:center;
                                        border-radius:6px;">
                                Нет фото
                            </div>
                        @endif

                        <a href="{{ route('admin.brands.show', $brand->id) }}"
                           class="btn btn-primary btn-sm mt-3">
                            Просмотр
                        </a>

                    </div>
                </div>
            @empty
                <p>Брендов пока нет (ещё не одобрили партнёров)</p>
            @endforelse

        </div>
    </div>
</div>
@endsection