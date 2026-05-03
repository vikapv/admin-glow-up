@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="fw-bold">Просмотр бренда</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card border-0 shadow-lg p-4 text-center">

                    {{-- IMAGE --}}
                    <div class="mb-3">
                        @if($brand->logo)
                            <img src="{{ asset($brand->logo) }}"
                                 style="width:180px;height:180px;object-fit:cover;border-radius:15px;">
                        @else
                            <div style="width:180px;height:180px;
                                        background:#f1f1f1;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        border-radius:15px;
                                        margin:0 auto;">
                                Нет изображения
                            </div>
                        @endif
                    </div>

                    {{-- NAME --}}
                    <h3 class="fw-bold mb-2">{{ $brand->name }}</h3>

                    <span class="badge bg-success mb-3">
                        Approved Brand
                    </span>

                    <hr>

                    {{-- INFO --}}
                    <p class="text-muted">
                        Этот бренд создан на основе одобренной заявки партнёра.
                    </p>

                    <a href="{{ route('admin.brands.index') }}"
                       class="btn btn-secondary mt-2">
                        ← Назад
                    </a>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection