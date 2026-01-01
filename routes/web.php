<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN)
|--------------------------------------------------------------------------
*/

// Первая страница — логин
Route::get('/', [AuthController::class, 'showLoginForm'])->name('admin.login');

// Отправка формы логина
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');

// Выход
Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');


/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | PRODUCTS (через контроллер)
    |--------------------------------------------------------------------------
    */
     Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/edit/{product}', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::post('/products/update/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::post('/products/delete/{product}', [ProductController::class, 'destroy'])->name('admin.products.delete');

    
    /*
    |--------------------------------------------------------------------------
    | CATEGORIES
    |--------------------------------------------------------------------------
    */
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/edit/{category}', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::post('/categories/update/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::post('/categories/delete/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.delete');


    /*
    |--------------------------------------------------------------------------
    | BRANDS
    |--------------------------------------------------------------------------
    */
    // Список брендов
    Route::get('/brands', [BrandController::class, 'index'])->name('admin.brands.index');

    // Форма создания
    Route::get('/brands/create', [BrandController::class, 'create'])->name('admin.brands.create');

    // Сохранение нового бренда
    Route::post('/brands', [BrandController::class, 'store'])->name('admin.brands.store');

    // Форма редактирования
    Route::get('/brands/edit/{brand}', [BrandController::class, 'edit'])->name('admin.brands.edit');

    // Обновление бренда
    Route::post('/brands/update/{brand}', [BrandController::class, 'update'])->name('admin.brands.update');

    // Удаление бренда
    Route::post('/brands/delete/{brand}', [BrandController::class, 'destroy'])->name('admin.brands.delete');


    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */
    
   Route::get('/users', [AdminUserController::class, 'index'])
        ->name('admin.users.index');

    Route::post('/users/{adminUser}/status', [AdminUserController::class, 'updateStatus'])
        ->name('admin.users.status');

        
    /*
    |--------------------------------------------------------------------------
    | ORDERS
    |--------------------------------------------------------------------------
    */
    Route::get('/orders', fn () => view('admin.orders.index'))
        ->name('admin.orders');

    Route::get('/orders/show/{id}', fn ($id) => view('admin.orders.show'))
        ->name('admin.orders.show');


    /*
    |--------------------------------------------------------------------------
    | REVIEWS
    |--------------------------------------------------------------------------
    */
    Route::get('/reviews', fn () => view('admin.reviews.index'))
        ->name('admin.reviews');

    Route::get('/reviews/show/{id}', fn ($id) => view('admin.reviews.show'))
        ->name('admin.reviews.show');


    /*
    |--------------------------------------------------------------------------
    | PROMOTIONS
    |--------------------------------------------------------------------------
    */
    Route::get('/promotions', fn () => view('admin.promotions.index'))
        ->name('admin.promotions');

    Route::get('/promotions/create', fn () => view('admin.promotions.create'))
        ->name('admin.promotions.create');

    Route::get('/promotions/edit/{id}', fn ($id) => view('admin.promotions.edit'))
        ->name('admin.promotions.edit');

});
