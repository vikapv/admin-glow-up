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
});
