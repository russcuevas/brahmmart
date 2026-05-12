<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\InventoryController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\customers\CustomersDashboardController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
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


// GUEST ROUTES
Route::get('/register', [AuthController::class, 'RegisterPage'])->name('auth.register.page');
Route::post('/register', [AuthController::class, 'RegisterRequest'])->name('auth.register.request');
Route::get('/verify-email/{email}/{token}', [AuthController::class, 'VerifyEmail'])->name('auth.verify.email');
Route::get('/login', [AuthController::class, 'LoginPage'])->name('auth.login.page');
Route::post('/login', [AuthController::class, 'LoginRequest'])->name('auth.login.request');
Route::post('/logout', [AuthController::class, 'Logout'])->name('auth.logout');
Route::get('/shop', [ShopController::class, 'ShopPage'])->name('shop.page');
Route::get('/shop/product/{id}', [ShopController::class, 'SingleProductPage'])->name('single.product.page');
Route::get('/product/details/{id}', [ShopController::class, 'GetProductDetails'])->name('product.details');


// ADMIN ROUTES
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'DashboardPage'])->name('admin.dashboard.page');
    Route::get('/admin/inventory', [InventoryController::class, 'InventoryPage'])->name('admin.inventory.page');
    Route::post('/admin/inventory', [InventoryController::class, 'StoreProduct'])->name('admin.inventory.store');
    Route::put('/admin/inventory/{id}', [InventoryController::class, 'UpdateProduct'])->name('admin.inventory.update');
    Route::delete('/admin/inventory/{id}', [InventoryController::class, 'DeleteProduct'])->name('admin.inventory.delete');
});


Route::get('/cart/get', [CartController::class, 'GetCart'])->name('cart.get');

// CUSTOMER ROUTES
Route::middleware(['customer'])->group(function () {
    Route::get('/students/dashboard', [CustomersDashboardController::class, 'CustomersDashboardPage'])->name('customer.dashboard.page');
    Route::post('/cart/add', [CartController::class, 'AddToCart'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'UpdateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'RemoveItem'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'Checkout'])->name('cart.checkout');
});
