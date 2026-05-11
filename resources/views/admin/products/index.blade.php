@extends('layouts.admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3>Товары</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        {{-- ФИЛЬТР --}}
        <form method="GET" class="mb-4">
            <select name="brand" class="form-control" onchange="this.form.submit()">
                <option value="">Все бренды</option>

                @foreach($brands as $brand)
                    <option value="{{ $brand->name }}"
                        {{ request('brand') == $brand->name ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </form>

        {{-- ТОВАРЫ --}}
        <div class="row g-3">

            @forelse($products as $product)
                <div class="col-md-4">
                    <div class="card shadow-sm p-3 text-center">

                        <h5 class="fw-bold">{{ $product->title }}</h5>

                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 style="width:150px;height:150px;object-fit:cover;border-radius:8px;">
                        @else
                            <div style="width:150px;height:150px;background:#eee;
                                        display:flex;align-items:center;justify-content:center;">
                                Нет фото
                            </div>
                        @endif

                        <p class="mt-2"><b>Бренд:</b> {{ $product->brand }}</p>
                        <p><b>Категория:</b> {{ $product->category }}</p>
                        <p><b>Цена:</b> {{ $product->price }} тг</p>

                        <p>
                            <b>Скидка:</b>
                            {{ $product->discount ? $product->discount . '%' : 'Нет' }}
                        </p>

                        <form action="{{ route('admin.products.delete', $product) }}"
      method="POST"
      class="mt-2">
    @csrf

    <button class="btn btn-danger btn-sm w-100">
        Удалить товар
    </button>
</form>


                    </div>
                </div>
            @empty
                <p>Товаров нет</p>
            @endforelse

        </div>

    </div>
</div>
@endsection