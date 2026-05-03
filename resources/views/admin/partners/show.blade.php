@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="fw-bold">Просмотр партнёра</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="col-md-7">

                <div class="card border-0 shadow-lg p-4 text-center">

                    {{-- LOGO --}}
                    <div class="mb-3">
                        @if($partner->logo)
                            <img src="{{ asset($partner->logo) }}"
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
                    <h3 class="fw-bold">{{ $partner->name }}</h3>

                    {{-- STATUS --}}
                    <div class="mb-3">
                        @if($partner->status == 'pending')
                            <span class="badge bg-warning text-dark">На рассмотрении</span>
                        @elseif($partner->status == 'approved')
                            <span class="badge bg-success">Принят</span>
                        @else
                            <span class="badge bg-danger">Отклонён</span>
                        @endif
                    </div>

                    <hr>

                    {{-- INFO --}}
                    <p><b>Email:</b> {{ $partner->email }}</p>
                    <p><b>Описание:</b> {{ $partner->description }}</p>

                    <hr>

                    {{-- ACTIONS --}}
                    @if($partner->status == 'pending')

                        <form action="{{ route('admin.partners.approve', $partner) }}"
                              method="POST" class="mb-2">
                            @csrf
                            <button class="btn btn-success w-100">
                                Принять
                            </button>
                        </form>

                        <form action="{{ route('admin.partners.reject', $partner) }}"
                              method="POST">
                            @csrf
                            <button class="btn btn-danger w-100">
                                Отклонить
                            </button>
                        </form>

                    @endif

                    <a href="{{ route('admin.partners.index') }}"
                       class="btn btn-secondary mt-3">
                        ← Назад
                    </a>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection