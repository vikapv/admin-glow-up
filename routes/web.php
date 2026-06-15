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
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SupportTicketController;

/*
|--------------------------------------------------------------------------
| ПУБЛИЧНЫЕ МАРШРУТЫ — вход/выход (без авторизации)
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ЗАЩИЩЁННЫЕ МАРШРУТЫ — только для авторизованных
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('auth:admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    /*
    |----------------------------------------------------------------------
    | PRODUCTS
    |----------------------------------------------------------------------
    */
    Route::get('/products', [ProductController::class, 'index'])
        ->name('admin.products.index');

    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->name('admin.products.show');

    Route::post('/products/{product}/delete', [ProductController::class, 'destroy'])
        ->name('admin.products.delete');

    /*
    |----------------------------------------------------------------------
    | CATEGORIES
    |----------------------------------------------------------------------
    */
    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('admin.categories.index');

    Route::get('/categories/create', [CategoryController::class, 'create'])
        ->name('admin.categories.create');

    Route::post('/categories', [CategoryController::class, 'store'])
        ->name('admin.categories.store');

    Route::get('/categories/edit/{category}', [CategoryController::class, 'edit'])
        ->name('admin.categories.edit');

    Route::post('/categories/update/{category}', [CategoryController::class, 'update'])
        ->name('admin.categories.update');

    Route::post('/categories/delete/{category}', [CategoryController::class, 'destroy'])
        ->name('admin.categories.delete');

    /*
    |----------------------------------------------------------------------
    | BRANDS
    |----------------------------------------------------------------------
    */
    Route::get('/brands', [BrandController::class, 'index'])
        ->name('admin.brands.index');

    Route::get('/brands/{brand}', [BrandController::class, 'show'])
        ->name('admin.brands.show');

    /*
    |----------------------------------------------------------------------
    | USERS (покупатели)
    |----------------------------------------------------------------------
    */
    Route::get('/users', [AdminUserController::class, 'index'])
        ->name('admin.users.index');

      Route::post('/users/{user}/status', [AdminUserController::class, 'updateStatus'])
        ->name('admin.users.status');

    /*
    |----------------------------------------------------------------------
    | ORDERS
    |----------------------------------------------------------------------
    */
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('admin.orders.index');

    Route::get('/orders/show/{order}', [OrderController::class, 'show'])
        ->name('admin.orders.show');

    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('admin.orders.status');

    /*
    |----------------------------------------------------------------------
    | REVIEWS
    |----------------------------------------------------------------------
    */
    Route::get('/reviews', [ReviewController::class, 'index'])
        ->name('admin.reviews.index');

    Route::get('/reviews/product/{product}', [ReviewController::class, 'show'])
        ->name('admin.reviews.show');

    Route::post('/reviews/delete/{review}', [ReviewController::class, 'destroy'])
        ->name('admin.reviews.delete');

    /*
    |----------------------------------------------------------------------
    | PROMOTIONS
    |----------------------------------------------------------------------
    */
    Route::get('/promotions', [PromotionController::class, 'index'])
        ->name('admin.promotions.index');

    Route::get('/promotions/create', [PromotionController::class, 'create'])
        ->name('admin.promotions.create');

    Route::post('/promotions', [PromotionController::class, 'store'])
        ->name('admin.promotions.store');

    Route::get('/promotions/edit/{promotion}', [PromotionController::class, 'edit'])
        ->name('admin.promotions.edit');

    Route::put('/promotions/update/{promotion}', [PromotionController::class, 'update'])
        ->name('admin.promotions.update');

    Route::post('/promotions/delete/{promotion}', [PromotionController::class, 'destroy'])
        ->name('admin.promotions.delete');

    /*
    |----------------------------------------------------------------------
    | PARTNERS
    |----------------------------------------------------------------------
    */
    Route::get('/partners', [PartnerRequestController::class, 'index'])
        ->name('admin.partners.index');

    Route::get('/partners/{id}', [PartnerRequestController::class, 'show'])
    ->name('admin.partners.show');

    Route::post('/partners/{id}/approve', [PartnerRequestController::class, 'approve'])
    ->name('admin.partners.approve');

    Route::post('/partners/{id}/reject', [PartnerRequestController::class, 'reject'])
    ->name('admin.partners.reject');

    Route::post('/partners/{id}/delete', [PartnerRequestController::class, 'destroy'])
    ->name('admin.partners.delete');

    /*
    |----------------------------------------------------------------------
    | PROMOCODES
    |----------------------------------------------------------------------
    */
    Route::get('/promocodes', [PromoCodeController::class, 'index'])
        ->name('admin.promocodes.index');

    Route::post('/promocodes', [PromoCodeController::class, 'store'])
        ->name('admin.promocodes.store');

    Route::post('/promocodes/{promoCode}/toggle', [PromoCodeController::class, 'toggleActive'])
        ->name('admin.promocodes.toggle');

    Route::post('/promocodes/{promoCode}/delete', [PromoCodeController::class, 'destroy'])
        ->name('admin.promocodes.delete');


    /*
    |----------------------------------------------------------------------
    | Support
    |----------------------------------------------------------------------
    */

    Route::get('/support', [SupportTicketController::class, 'index'])
    ->name('admin.support.index');

    Route::get('/support/{ticket}', [SupportTicketController::class, 'show'])
    ->name('admin.support.show');

    Route::post('/support/{ticket}/reply', [SupportTicketController::class, 'reply'])
    ->name('admin.support.reply');

    Route::post('/support/{ticket}/delete', [SupportTicketController::class, 'destroy'])
    ->name('admin.support.delete');
});