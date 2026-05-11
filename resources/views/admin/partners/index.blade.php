@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="fw-bold">Партнёры</h3>
        <p class="text-muted">Заявки на подключение партнёров</p>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        {{-- уведомления --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- ФИЛЬТР ПО СТАТУСУ --}}
        <form method="GET" class="mb-4">
            <select name="status"
                    class="form-select"
                    onchange="this.form.submit()">

                <option value="">Все партнёры</option>

                <option value="pending"
                    {{ request('status') == 'pending' ? 'selected' : '' }}>
                    На рассмотрении
                </option>

                <option value="approved"
                    {{ request('status') == 'approved' ? 'selected' : '' }}>
                    Принятые
                </option>

                <option value="rejected"
                    {{ request('status') == 'rejected' ? 'selected' : '' }}>
                    Отклонённые
                </option>

            </select>
        </form>

        <div class="row g-4">

            @forelse($requests as $partner)
                <div class="col-md-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body text-center">

                            {{-- LOGO --}}
                            <div class="mb-3">
                                @if($partner->logo)
                                    <img src="{{ asset($partner->logo) }}"
                                         style="width:120px;height:120px;object-fit:cover;border-radius:12px;">
                                @else
                                    <div style="
                                        width:120px;
                                        height:120px;
                                        background:#f1f1f1;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        border-radius:12px;
                                        margin:0 auto;
                                    ">
                                        Нет фото
                                    </div>
                                @endif
                            </div>

                            {{-- NAME --}}
                            <h5 class="fw-bold mb-2">{{ $partner->name }}</h5>

                            {{-- STATUS --}}
                            @if($partner->status == 'pending')
                                <span class="badge bg-warning text-dark mb-3">
                                    На рассмотрении
                                </span>

                            @elseif($partner->status == 'approved')
                                <span class="badge bg-success mb-3">
                                    Принят
                                </span>

                            @else
                                <span class="badge bg-danger mb-3">
                                    Отклонён
                                </span>
                            @endif

                            {{-- BUTTONS --}}
                            <div class="d-grid gap-2">

                                <a href="{{ route('admin.partners.show', $partner) }}"
                                   class="btn btn-primary btn-sm">
                                    Просмотр
                                </a>

                                <form action="{{ route('admin.partners.delete', $partner) }}"
                                      method="POST">
                                    @csrf

                                    <button class="btn btn-outline-danger btn-sm w-100">
                                        Удалить
                                    </button>
                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            @empty
                <div class="col-12 text-center text-muted py-5">
                    <h5>Заявок пока нет</h5>
                </div>
            @endforelse

        </div>

    </div>
</div>
@endsection