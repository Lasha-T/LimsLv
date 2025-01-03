<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\AccountingController;


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

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route::get('/products', [ProductController::class, 'menu'])->name('products.menu');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    // Route::get('/products/index', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::post('/orders/{orderId}/update', [OrderController::class, 'updateOrderStatus'])->name('order.updateStatus');

    Route::get('/purchases/create', [PurchasesController::class, 'create'])->name('purchases.create');
    Route::post('/purchases/store', [PurchasesController::class, 'store'])->name('purchases.store');
    // Route::get('/purchases/index', [PurchasesController::class, 'index'])->name('purchases.index');

    // Route::get('/accounting', [AccountingController::class, 'index'])->name('accounting.index');
    // Route::get('/accounting/select-product', [AccountingController::class, 'selectProduct'])->name('accounting.select-product');
    // Route::get('/accounting/by-product', [AccountingController::class, 'byProductView'])->name('accounting.by-product');
});

// Admin and Guest shared Routes
Route::middleware(['auth', 'role:admin,adminguest'])->group(function () {
    Route::get('/products', [ProductController::class, 'menu'])->name('products.menu');
    Route::get('/products/index', [ProductController::class, 'index'])->name('products.index');

    Route::get('/purchases/index', [PurchasesController::class, 'index'])->name('purchases.index');

    Route::get('/accounting', [AccountingController::class, 'index'])->name('accounting.index');
    Route::get('/accounting/select-product', [AccountingController::class, 'selectProduct'])->name('accounting.select-product');
    Route::get('/accounting/by-product', [AccountingController::class, 'byProductView'])->name('accounting.by-product');
});

// Customer only Routes
Route::middleware(['auth', 'role:customer'])->group(function () {

});

// Shared Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/orders/active', [OrderController::class, 'activeOrders'])->name('orders.active');
    Route::get('/orders/finished', [OrderController::class, 'finishedOrders'])->name('orders.finished');
    Route::get('/orders/canceled', [OrderController::class, 'canceledOrders'])->name('orders.canceled');
    
    Route::get('/orders/{order}', [OrderController::class, 'showOrderDetails'])->name('orders.showDetails');

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
