@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h3>Партнёры</h3>

    {{-- УВЕДОМЛЕНИЯ --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @foreach($requests as $partner)
        <div class="col-md-4">
            <div class="card p-3 text-center">

                <h5>{{ $partner->name }}</h5>

                @if($partner->logo)
                    <img src="{{ asset($partner->logo) }}" style="height:150px;object-fit:cover">
                @endif

                {{-- СТАТУС --}}
                <p class="mt-2">
                    @if($partner->status == 'pending')
                        <span class="badge bg-warning text-dark">На рассмотрении</span>
                    @elseif($partner->status == 'approved')
                        <span class="badge bg-success">Принят</span>
                    @else
                        <span class="badge bg-danger">Отклонён</span>
                    @endif
                </p>

                <a href="{{ route('admin.partners.show', $partner) }}" class="btn btn-primary btn-sm">Просмотр</a>

                <form action="{{ route('admin.partners.delete', $partner) }}" method="POST">
                    @csrf
                    <button class="btn btn-danger btn-sm mt-1">Удалить</button>
                </form>

            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection