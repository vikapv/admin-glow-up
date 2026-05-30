@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3>{{ $product->title }}</h3>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    <div class="card mb-4">
        <div class="card-body">

            <h4>{{ $product->title }}</h4>

            <p>
                <b>Бренд:</b>
                {{ $product->brand }}
            </p>

            <p>
                <b>Всего отзывов:</b>
                {{ $product->reviews->count() }}
            </p>

        </div>
    </div>

    @foreach($product->reviews as $review)

    <div class="card mb-3">

        <div class="card-body">

            <h6>
                {{ $review->user_name }}
            </h6>

            <p>
                {{ $review->content }}
            </p>

            <form
                action="{{ route('admin.reviews.delete', $review) }}"
                method="POST"
            >
                @csrf

                <button
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Удалить отзыв?')"
                >
                    Удалить отзыв
                </button>

            </form>

        </div>

    </div>

@endforeach

<div class="mt-4">
    <a href="{{ route('admin.reviews.index') }}"
       class="btn btn-secondary">
        ← Назад к отзывам
    </a>
</div>

</div>
</div>

@endsection