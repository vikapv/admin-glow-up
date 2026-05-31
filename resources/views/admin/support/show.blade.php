@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-0">Обращение #{{ $ticket->id }}</h3>
            <p class="text-muted mb-0">{{ $ticket->email }}</p>
        </div>
        <a href="{{ route('admin.support.index') }}" class="btn btn-outline-secondary">← Назад</a>
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

    <div class="row g-4">

        {{-- ЛЕВАЯ КОЛОНКА --}}
        <div class="col-md-8">

            {{-- Сообщение --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold mb-0">Сообщение от пользователя</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-3">
                        <tr>
                            <td class="text-muted" style="width:100px;">Email</td>
                            <td>{{ $ticket->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Тема</td>
                            <td class="fw-bold">{{ $ticket->subject }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Дата</td>
                            <td>{{ $ticket->created_at->format('d.m.Y в H:i') }}</td>
                        </tr>
                    </table>

                    <div class="bg-light rounded p-3" style="line-height:1.7;">
                        {{ $ticket->message }}
                    </div>

                    @if($ticket->attachment)
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $ticket->attachment) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-paperclip me-1"></i> Открыть вложение
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Форма ответа --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold mb-0">Ответ администратора</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.support.reply', $ticket) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <textarea name="admin_reply"
                                      class="form-control"
                                      rows="5"
                                      placeholder="Напишите ответ пользователю...">{{ old('admin_reply', $ticket->admin_reply) }}</textarea>
                        </div>

                        <div class="d-flex gap-2 align-items-center">
                            <select name="status" class="form-select" style="width:200px;">
                                <option value="new" {{ $ticket->status === 'new' ? 'selected' : '' }}>Новое</option>
                                <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>В работе</option>
                                <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Решено</option>
                            </select>
                            <button class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Сохранить ответ
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>

        {{-- ПРАВАЯ КОЛОНКА --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold mb-0">Статус</h6>
                </div>
                <div class="card-body">
                    @if($ticket->status === 'new')
                        <span class="badge bg-danger fs-6">Новое</span>
                    @elseif($ticket->status === 'in_progress')
                        <span class="badge bg-warning text-dark fs-6">В работе</span>
                    @else
                        <span class="badge bg-success fs-6">Решено</span>
                    @endif

                    <hr>

                    <form action="{{ route('admin.support.delete', $ticket) }}"
                          method="POST"
                          onsubmit="return confirm('Удалить обращение?')">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm w-100">
                            <i class="bi bi-trash me-1"></i> Удалить обращение
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
</div>
@endsection