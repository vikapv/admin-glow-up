@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-0">{{ $partner->name }}</h3>
            <p class="text-muted mb-0">Заявка партнёра · #{{ $partner->id }}</p>
        </div>
        <a href="{{ route('admin.partners.index') }}" class="btn btn-outline-secondary">
            ← Назад
        </a>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4 justify-content-center">

        {{-- ЛЕВАЯ КОЛОНКА: лого + действия --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm mb-3 text-center">
                <div class="card-body py-4">
                    @if(!empty($partner->logo))
                        <img src="http://127.0.0.1:8001/storage/{{ $partner->logo }}"
                             style="width:140px;height:140px;object-fit:cover;
                                    border-radius:16px;margin-bottom:16px;">
                    @else
                        <div style="width:140px;height:140px;border-radius:16px;
                                    background:#e9ecef;display:flex;
                                    align-items:center;justify-content:center;
                                    font-size:40px;font-weight:700;color:#6c757d;
                                    margin:0 auto 16px;">
                            {{ strtoupper(substr($partner->name, 0, 2)) }}
                        </div>
                    @endif

                    <h5 class="fw-bold mb-1">{{ $partner->name }}</h5>

                    @if($partner->status == 'pending')
                        <span class="badge bg-warning text-dark">На рассмотрении</span>
                    @elseif($partner->status == 'approved')
                        <span class="badge bg-success">Принят</span>
                    @else
                        <span class="badge bg-danger">Отклонён</span>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold mb-0">Действия</h6>
                </div>
                <div class="card-body d-grid gap-2">

                    @if($partner->status != 'approved')
                        <form action="{{ route('admin.partners.approve', $partner->id) }}"
                              method="POST">
                            @csrf
                            <button class="btn btn-success w-100">
                                <i class="bi bi-check-circle me-1"></i> Принять партнёра
                            </button>
                        </form>
                    @endif

                    @if($partner->status != 'rejected')
                        <form action="{{ route('admin.partners.reject', $partner->id) }}"
                              method="POST">
                            @csrf
                            <button class="btn btn-outline-danger w-100">
                                <i class="bi bi-x-circle me-1"></i> Отклонить заявку
                            </button>
                        </form>
                    @endif

                    @if($partner->status == 'approved')
                        <div class="alert alert-success py-2 mb-0 text-center small">
                            <i class="bi bi-check-circle me-1"></i>
                            Бренд добавлен в каталог
                        </div>
                    @endif

                    <hr class="my-1">

                    <form action="{{ route('admin.partners.delete', $partner->id) }}"
                          method="POST"
                          onsubmit="return confirm('Удалить заявку «{{ $partner->name }}»?')">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm w-100">
                            <i class="bi bi-trash me-1"></i> Удалить заявку
                        </button>
                    </form>

                </div>
            </div>

        </div>

        {{-- ПРАВАЯ КОЛОНКА: детали --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold mb-0">Информация о партнёре</h6>
                </div>
                <div class="card-body">

                    <table class="table table-sm mb-0">
                        <tr>
                            <td class="text-muted" style="width:140px;">Название</td>
                            <td class="fw-bold">{{ $partner->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td>
                                <a href="mailto:{{ $partner->email }}" class="text-decoration-none">
                                    {{ $partner->email }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Статус</td>
                            <td>
                                @if($partner->status == 'pending')
                                    <span class="badge bg-warning text-dark">На рассмотрении</span>
                                @elseif($partner->status == 'approved')
                                    <span class="badge bg-success">Принят</span>
                                @else
                                    <span class="badge bg-danger">Отклонён</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Дата подачи</td>
                            <td>{{ \Carbon\Carbon::parse($partner->created_at)->format('d.m.Y в H:i') }}</td>
                        </tr>
                        @if($partner->updated_at != $partner->created_at)
                        <tr>
                            <td class="text-muted">Обновлено</td>
                            <td>{{ \Carbon\Carbon::parse($partner->updated_at)->format('d.m.Y в H:i') }}</td>
                        </tr>
                        @endif
                    </table>

                    @if(!empty($partner->description))
                        <hr>
                        <h6 class="fw-bold mb-2">Описание компании</h6>
                        <p class="text-muted mb-0" style="line-height:1.7;">
                            {{ $partner->description }}
                        </p>
                    @endif

                </div>
            </div>

            {{-- Если принят — показываем связанный бренд --}}
            @if($partner->status == 'approved')
                @php $brand = \App\Models\Brand::where('partner_request_id', $partner->id)->first(); @endphp
                @if($brand)
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-header bg-transparent border-0 pt-3">
                            <h6 class="fw-bold mb-0">Бренд в каталоге</h6>
                        </div>
                        <div class="card-body d-flex align-items-center gap-3">
                            @if($brand->logo)
                                <img src="{{ asset($brand->logo) }}"
                                     style="width:48px;height:48px;object-fit:cover;
                                            border-radius:8px;">
                            @endif
                            <div>
                                <p class="fw-bold mb-0">{{ $brand->name }}</p>
                                <p class="text-muted small mb-0">Активный бренд</p>
                            </div>
                            <a href="{{ route('admin.brands.show', $brand) }}"
                               class="btn btn-sm btn-outline-primary ms-auto">
                                Открыть бренд →
                            </a>
                        </div>
                    </div>
                @endif
            @endif

        </div>

    </div>

</div>
</div>

@endsection