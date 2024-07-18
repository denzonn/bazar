<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/product', [BerandaController::class, 'index'])->name('product');

    Route::get('/cart', [BerandaController::class, 'cart'])->name('cart');
    Route::post('/cart/add/{id}', [BerandaController::class, 'addToCart'])->name('addToCart');

    Route::put('/update-cart-item/{itemId}', [BerandaController::class, 'updateCartItem'])->name('update.cart.item');

    Route::post('checkout', [BerandaController::class, 'checkout'])->name('checkout');
});

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('transaction', TransactionController::class);

    Route::get('transaction/detail/{id}', [TransactionController::class, 'detailTransaction'])->name('detailTransaction');
    Route::get('transaction/detail/paid/{id}', [TransactionController::class, 'paidTransaction'])->name('paidTransaction');

    Route::get('get-category', [CategoryController::class, 'getData'])->name('categoryData');
    Route::get('get-product', [ProductController::class, 'getData'])->name('productData');
    Route::get('get-transaction', [TransactionController::class, 'getData'])->name('transactionData');
});

Route::get('menu', [MenuController::class, 'index'])->name('menu');

require __DIR__ . '/auth.php';
