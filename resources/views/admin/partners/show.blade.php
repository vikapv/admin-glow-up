@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h3>{{ $partner->name }}</h3>

    @if($partner->logo)
        <img src="{{ asset($partner->logo) }}" style="height:200px;object-fit:cover">
    @endif

    <p><strong>Email:</strong> {{ $partner->email }}</p>
    <p><strong>Описание:</strong> {{ $partner->description }}</p>

    <p><strong>Статус:</strong>
        @if($partner->status == 'pending')
            На рассмотрении
        @elseif($partner->status == 'approved')
            Принят
        @else
            Отклонён
        @endif
    </p>

    {{-- КНОПКИ --}}
    @if($partner->status == 'pending')
        <form action="{{ route('admin.partners.approve', $partner) }}" method="POST">
            @csrf
            <button class="btn btn-success">Принять</button>
        </form>

        <form action="{{ route('admin.partners.reject', $partner) }}" method="POST" class="mt-2">
            @csrf
            <button class="btn btn-danger">Отклонить</button>
        </form>
    @endif

    <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary mt-3">Назад</a>
</div>
@endsection