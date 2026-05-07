<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\ShopController;
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


Route::get('/register', [AuthController::class, 'RegisterPage'])->name('auth.register.page');
Route::get('/login', [AuthController::class, 'LoginPage'])->name('auth.login.page');

Route::get('/shop', [ShopController::class, 'ShopPage'])->name('shop.page');
Route::get('/single_product', [ShopController::class, 'SingleProductPage'])->name('single.product.page');

// ADMIN ROUTES
Route::get('/admin/dashboard', [DashboardController::class, 'DashboardPage'])->name('admin.dashboard');
