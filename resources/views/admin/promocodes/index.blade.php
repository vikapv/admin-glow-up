@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3>Промокоды</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        {{-- ФОРМА --}}
        <form method="POST" action="{{ route('admin.promocodes.store') }}" class="mb-4">
    @csrf

    <input type="hidden" name="is_active" value="1">

    <div class="row g-2">

        <div class="col-md-3">
            <input type="text" name="code" class="form-control" placeholder="Код" required>
        </div>

        <div class="col-md-3">
            <input type="number" name="discount" class="form-control" placeholder="Скидка %" required>
        </div>

        <div class="col-md-3">
            <input type="number" name="limit" class="form-control" placeholder="Лимит">
        </div>

        <div class="col-md-3">
            <button class="btn btn-primary w-100">Добавить</button>
        </div>

    </div>
</form>

        {{-- СПИСОК --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Код</th>
                    <th>Скидка</th>
                    <th>Лимит</th>
                    <th>Статус</th>
                    <th>Действие</th>
                </tr>
            </thead>

            <tbody>
                @foreach($promos as $promo)
                    <tr>
                        <td>{{ $promo->code }}</td>
                        <td>{{ $promo->discount }}%</td>
                        <td>{{ $promo->limit ?? '∞' }}</td>
                        <td>
                            @if($promo->is_active)
                                <span class="badge bg-success">Активен</span>
                            @else
                                <span class="badge bg-danger">Отключен</span>
                            @endif
                        </td>

                        <td>
                            <form action="{{ route('admin.promocodes.delete', $promo) }}"
                                  method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>
@endsection