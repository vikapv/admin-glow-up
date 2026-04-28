@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="fw-bold">Бренды</h3>
        <p class="text-muted">Список всех одобренных брендов партнёров</p>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        <div class="row g-4">

            @forelse($brands as $brand)
                <div class="col-md-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body text-center">

                            {{-- LOGO --}}
                            <div class="mb-3">
                                @if($brand->logo)
                                    <img src="{{ asset($brand->logo) }}"
                                         style="width:120px;height:120px;object-fit:cover;border-radius:12px;">
                                @else
                                    <div style="width:120px;height:120px;
                                                background:#f1f1f1;
                                                display:flex;
                                                align-items:center;
                                                justify-content:center;
                                                border-radius:12px;
                                                margin:0 auto;">
                                        Нет фото
                                    </div>
                                @endif
                            </div>

                            {{-- NAME --}}
                            <h5 class="fw-bold mb-2">{{ $brand->name }}</h5>

                            <span class="badge bg-success mb-3">
                                Active Brand
                            </span>

                            {{-- BUTTON --}}
                            <div>
                                <a href="{{ route('admin.brands.show', $brand->id) }}"
                                   class="btn btn-primary btn-sm px-4">
                                    Просмотр
                                </a>
                            </div>

                        </div>

                    </div>

                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <h5>Брендов пока нет</h5>
                    <p>Они появятся после одобрения партнёров</p>
                </div>
            @endforelse

        </div>

    </div>
</div>
@endsection