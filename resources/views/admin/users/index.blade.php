@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h3>Пользователи</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th style="width: 60px">#</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th style="width: 120px">Статус</th>
                    <th style="width: 220px">Действия</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    <tr class="{{ $user->status === 'banned' ? 'table-danger' : '' }}">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        <td>
                            @if($user->status === 'active')
                                <span class="badge bg-success">Активен</span>
                            @else
                                <span class="badge bg-danger">Забанен</span>
                            @endif
                        </td>

                        <td class="d-flex gap-2">

                            {{-- Забанить --}}
                            @if($user->status === 'active')
                                <form action="{{ route('admin.users.status', $user) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="banned">
                                    <button class="btn btn-sm btn-danger">
                                        Забанить
                                    </button>
                                </form>
                            @endif

                            {{-- Разбанить --}}
                            @if($user->status === 'banned')
                                <form action="{{ route('admin.users.status', $user) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="active">
                                    <button class="btn btn-sm btn-success">
                                        Разбанить
                                    </button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Пользователи не найдены
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection
