<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

//Auth
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);

Route::get('login_customer', [AuthController::class, 'login_customer']);
Route::post('login_customer', [AuthController::class, 'login_customer_action']);
Route::get('logout_customer', [AuthController::class, 'logout_customer']);

Route::get('register_customer', [AuthController::class, 'register_customer']);
Route::post('register_customer', [AuthController::class, 'register_customer_action']);

//kategori
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/subkategori', [SubcategoryController::class, 'list']);
Route::get('/kategori', [CategoryController::class, 'list']);
Route::get('/slider', [SliderController::class, 'list']);
Route::get('/produk', [ProductController::class, 'list']);
Route::get('/testimoni', [TestimoniController::class, 'list']);
Route::get('/payment', [PaymentController::class, 'list']);

Route::get('/pesanan/baru', [OrderController::class, 'list']);
Route::get('/pesanan/dikonfirmasi', [OrderController::class, 'dikonfirmasi_list']);
Route::get('/pesanan/dikemas', [OrderController::class, 'dikemas_list']);
Route::get('/pesanan/dikirim', [OrderController::class, 'dikirim_list']);
Route::get('/pesanan/diterima', [OrderController::class, 'diterima_list']);
Route::get('/pesanan/selesai', [OrderController::class, 'selesai_list']);
Route::get('/pesanan/selesai', [OrderController::class, 'selesai_list']);

Route::get('/tentang', [TentangController::class, 'index']);
Route::post('/tentang/{about}', [TentangController::class, 'update']);

Route::get('/laporan', [ReportController::class, 'index']);

//Home
Route::get('/', [HomeController::class, 'index']);
Route::get('/products/{category}', [HomeController::class, 'products']);
Route::get('/product/{id}', [HomeController::class, 'product']);
Route::get('/cart', [HomeController::class, 'cart']);
Route::get('/checkout', [HomeController::class, 'checkout']);
Route::get('/orders', [HomeController::class, 'orders']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/faq', [HomeController::class, 'faq']);

Route::post('/add_to_cart', [HomeController::class, 'add_to_cart']);
Route::get('/delete_from_cart/{cart}', [HomeController::class, 'delete_from_cart']);
Route::get('/get_kota/{id}', [HomeController::class, 'get_kota']);
Route::get('/get_ongkir/{destination}/{weight}', [HomeController::class, 'get_ongkir']);
Route::post('/checkout_orders', [HomeController::class, 'checkout_orders']);
Route::post('/payments', [HomeController::class, 'payments']);
Route::post('/pesanan_selesai/{order}', [HomeController::class, 'pesanan_selesai']);

Route::prefix("wh/")->group(function () {
    require __DIR__ . '/webhook.php';
});
