@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3>Редактировать категорию</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Название категории</label>
                    <input
                        type="text"
                        class="form-control"
                        value="Уход за лицом"
                    >
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ url('admin/categories') }}"
                       class="btn btn-secondary">
                        Назад
                    </a>

                    <!-- ВАЖНО: это ССЫЛКА -->
                    <a href="{{ url('admin/categories') }}"
                       class="btn btn-primary">
                        Сохранить
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
