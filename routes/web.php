<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\PartnerRequestController;



/*
|--------------------------------------------------------------------------
| AUTH (LOGIN)
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
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

    Route::get('/brands', [BrandController::class, 'index'])->name('admin.brands.index');
    Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('admin.brands.show');


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
    Route::get('/orders', [OrderController::class, 'index'])
    ->name('admin.orders.index');
    
    Route::get('/orders/show/{order}', [OrderController::class, 'show'])
    ->name('admin.orders.show');

    /*
    |--------------------------------------------------------------------------
    | REVIEWS
    |--------------------------------------------------------------------------
    */
    Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])
    ->name('admin.reviews.index');
    
    Route::get('/reviews/show/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'show'])
    ->name('admin.reviews.show');

    /*
    |--------------------------------------------------------------------------
    | PROMOTIONS
    |--------------------------------------------------------------------------
    */
      Route::get('/promotions', [PromotionController::class, 'index'])->name('admin.promotions.index');
    Route::get('/promotions/create', [PromotionController::class, 'create'])->name('admin.promotions.create');
    Route::post('/promotions', [PromotionController::class, 'store'])->name('admin.promotions.store');
    Route::get('/promotions/edit/{promotion}', [PromotionController::class, 'edit'])->name('admin.promotions.edit');
    Route::put('/promotions/update/{promotion}', [PromotionController::class, 'update'])->name('admin.promotions.update');
    Route::post('/promotions/delete/{promotion}', [PromotionController::class, 'destroy'])->name('admin.promotions.delete');

    Route::get('/partners', [PartnerRequestController::class, 'index'])->name('admin.partners.index');
    Route::get('/partners/{partner}', [PartnerRequestController::class, 'show'])->name('admin.partners.show');

    Route::post('/partners/{partner}/approve', [PartnerRequestController::class, 'approve'])->name('admin.partners.approve');
    Route::post('/partners/{partner}/reject', [PartnerRequestController::class, 'reject'])->name('admin.partners.reject');
    Route::post('/partners/{partner}/delete', [PartnerRequestController::class, 'destroy'])->name('admin.partners.delete');

});
