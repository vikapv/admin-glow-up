<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/products', function () {
        return view('admin.products.index');
    });

    Route::get('/products/create', function () {
        return view('admin.products.create');
    });

    Route::get('/products/edit/{id}', function ($id) {
        return view('admin.products.edit', ['id' => $id]);
    });

    Route::get('/categories', fn () => view('admin.categories.index'));
    Route::get('/categories/create', fn () => view('admin.categories.create'));
     Route::get('/categories/edit/{id}', function ($id) {
        return view('admin.categories.edit');
    });

     Route::get('/brands', function () {
        return view('admin.brands.index');
    });
    Route::get('/brands/create', function () {
        return view('admin.brands.create');
    });
    Route::get('/brands/edit/{id}', function ($id) {
        return view('admin.brands.edit', ['id' => $id]);
    });

     Route::get('/users', function () { 
        return view('admin.users.index'); 
    });

    Route::get('/orders', function () {
        return view('admin.orders.index');
    })->name('admin.orders');

    Route::get('/orders/show/{id}', function ($id) {
        return view('admin.orders.show', ['id' => $id]);
    })->name('admin.orders.show');


    Route::get('/reviews', function () {
        return view('admin.reviews.index');
    })->name('admin.reviews');

    Route::get('/reviews/show/{id}', function ($id) {
        return view('admin.reviews.show', ['id' => $id]);
    })->name('admin.reviews.show');

    
});
