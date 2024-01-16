<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;


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
Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'customers'])->name('dashboard');
    Route::get('/customers', [App\Http\Controllers\AdminController::class, 'customers'])->name('customers');
Route::post('/customer-order/{custID}',[App\Http\Controllers\AdminController::class, 'customerOrder'])->name('cust.order');
Route::post('customerSearch', [App\Http\Controllers\AdminController::class, 'customerSearch'])->name('customerSearch');

Route::post('/orderDetail/{custID}',[App\Http\Controllers\AdminController::class, 'orderDetail'])->name('orderDetail');
Route::get('/addproducts', [App\Http\Controllers\AdminController::class, 'addproducts'])->name('addProducts');
Route::post('/addproducts', [App\Http\Controllers\AdminController::class, 'productStore'])->name('productStore');
Route::get('/showProducts', [App\Http\Controllers\AdminController::class, 'showProducts'])->name('showProducts');
Route::post('/productDetails', [App\Http\Controllers\AdminController::class, 'productDeTails'])->name('product.Details');
Route::post('/updateProducts', [App\Http\Controllers\AdminController::class, 'updateProducts'])->name('updateProducts');
Route::get('/addcategories', [App\Http\Controllers\AdminController::class, 'addCategories'])->name('addCategories');
Route::post('/addcategories', [App\Http\Controllers\AdminController::class, 'categoryStore'])->name('categoryStore');
Route::get('/showCategories', [App\Http\Controllers\AdminController::class, 'showCategories'])->name('showCategories');
Route::get('/editCategories/{id}', [App\Http\Controllers\AdminController::class, 'editCategories'])->name('editCategories');
Route::put('/updateCategory/{id}', [App\Http\Controllers\AdminController::class, 'updateCategory'])->name('updateCategory');

Route::get('/outgoing', [App\Http\Controllers\AdminController::class, 'outgoing'])->name('outgoing');
Route::get('export_pdf', [App\Http\Controllers\AdminController::class, 'export_pdf'])->name('export_pdf');
Route::post('search', [App\Http\Controllers\AdminController::class, 'search'])->name('search');
Route::get('chart', [App\Http\Controllers\AdminController::class, 'Chart'])->name('Chart');
       
});









//user page
Route::get('/index', [App\Http\Controllers\UserController::class, 'index'])->name('index');



Auth::routes();


