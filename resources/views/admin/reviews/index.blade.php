@extends('layouts.admin')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3>Отзывы</h3>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">

    <form method="GET" class="mb-4">
        <select
            name="brand"
            class="form-control"
            onchange="this.form.submit()"
        >
            <option value="">
                Все бренды
            </option>

            @foreach($brands as $brand)
                <option
                    value="{{ $brand->name }}"
                    {{ request('brand') == $brand->name ? 'selected' : '' }}
                >
                    {{ $brand->name }}
                </option>
            @endforeach

        </select>
    </form>

    <div class="row g-3">

        @forelse($products as $product)

            <div class="col-md-4">

                <div class="card shadow-sm p-3 text-center">

                    <h5>{{ $product->title }}</h5>

                    <p>
                        <b>Бренд:</b>
                        {{ $product->brand }}
                    </p>

                    <p>
                        <b>Отзывов:</b>
                        {{ $product->reviews_count }}
                    </p>

                    <a
                        href="{{ route('admin.reviews.show', $product) }}"
                        class="btn btn-primary"
                    >
                        Просмотр отзывов
                    </a>

                </div>

            </div>

        @empty

            <div class="text-center">
                Отзывов пока нет
            </div>

        @endforelse

    </div>

</div>
</div>

@endsection