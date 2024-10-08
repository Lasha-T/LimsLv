<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect('/shop');
});

Route::prefix('shop')->group(function () {
    Route::get('/', [ShopController::class, 'home'])->name('shop.home');
    Route::get('/products', [ShopController::class, 'products'])->name('shop.products');
});

Route::get('/product/{id}', [ShopController::class, 'showProduct'])->name('shop.showProduct');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/products', [ProductController::class, 'menu'])->name('products.menu');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/index', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/orders', [ProductController::class, 'showOrders'])->name('admin.orders');
    Route::post('/orders/{orderId}/update', [ProductController::class, 'updateOrderStatus'])->name('admin.orders.update');

    Route::prefix('shop')->group(function () {
        Route::get('/cart', [CartController::class, 'viewCart'])->name('shop.cart'); 
        Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('shop.cart.add'); 
        Route::post('/cart/remove/{productId}', [CartController::class, 'removeFromCart'])->name('shop.cart.remove');
        Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('shop.cart.update');
        Route::post('/checkout', [CartController::class, 'checkoutPage'])->name('cart.checkout'); 
        Route::post('/checkout/payment/confirm', [CartController::class, 'confirmPayment'])->name('cart.confirmPayment');
        Route::post('/checkout/payment/discard', [CartController::class, 'discardOrder'])->name('cart.discardOrder');
        Route::get('/orders',[CartController::class, 'myOrders'])->name('shop.orders');
    });

});

require __DIR__.'/auth.php';
