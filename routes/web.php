<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ClientController;
use \App\Http\Controllers\CategoriesController;
use \App\Http\Controllers\SlidersController;
use \App\Http\Controllers\ProductsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ClientController::class, 'home'])->name('home');
Route::get('/shop', [ClientController::class, 'shop'])->name('shop');
Route::get('/addToCart/{id}', [ClientController::class, 'addToCart'])->name('addtocart');
Route::put('/cart/updateqty/{id}', [ClientController::class, 'updateQty'])->name('updateqty');
Route::get('/cart/removeproduct/{id}', [ClientController::class, 'removeProduct'])->name('removeproduct');
Route::view('/cart', 'client.cart')->name('cart');
Route::get('/checkout', [ClientController::class, 'checkout'])->name('checkout');

Route::view('/register', 'client.register')->name('register');
Route::view('/signin', 'client.signin')->name('signin');

Route::view('/admin', 'admin.home')->name('adminhome');
Route::view('/admin/addCategory', 'admin.addCategory')->name('addcategory');
Route::view('/admin/addSlider', 'admin.addSlider')->name('addslider');
Route::view('/admin/sliders', 'admin.sliders')->name('sliders');
Route::view('/admin/products', 'admin.products')->name('products');
Route::view('/admin/orders', 'admin.orders')->name('orders');

// Categories controller
Route::post('/admin/saveCategory', [CategoriesController::class, 'saveCategory'])->name('savecategory');
Route::get('/admin/categories', [CategoriesController::class, 'showCategories'])->name('categories');
Route::delete('/admin/deleteCategory/{id}', [CategoriesController::class, 'deleteCategory'])->name('deletecategory');
Route::get('/admin/editCategory/{id}', [CategoriesController::class, 'editCategory'])->name('editcategory');
Route::put('/admin/updateCategory/{id}', [CategoriesController::class, 'updateCategory'])->name('updatecategory');

// Sliders controller
Route::post('/admin/saveSlider', [SlidersController::class, 'saveSlider'])->name('saveslider');
Route::get('/admin/sliders', [SlidersController::class, 'showSliders'])->name('sliders');
Route::delete('/admin/deleteSlider/{id}', [SlidersController::class, 'deleteSlider'])->name('deleteslider');
Route::get('/admin/editSlider/{id}', [SlidersController::class, 'editSlider'])->name('editslider');
Route::put('/admin/updateSlider/{id}', [SlidersController::class, 'updateSlider'])->name('updateslider');
Route::put('/admin/unactivateSlider/{id}', [SlidersController::class, 'unactivateSlider'])->name('unactivateslider');
Route::put('/admin/activateSlider/{id}', [SlidersController::class, 'activateSlider'])->name('activateslider');

// Products controller
Route::get('admin/addProduct', [ProductsController::class, 'addProduct'])->name('addproduct');
Route::post('/admin/saveProduct', [ProductsController::class, 'saveProduct'])->name('saveproduct');
Route::get('/admin/products', [ProductsController::class, 'showProducts'])->name('products');
Route::delete('/admin/deleteProduct/{id}', [ProductsController::class, 'deleteProduct'])->name('deleteproduct');
Route::get('/admin/editProduct/{id}', [ProductsController::class, 'editProduct'])->name('editproduct');
Route::put('/admin/updateProduct/{id}', [ProductsController::class, 'updateProduct'])->name('updateproduct');
Route::put('/admin/unactivateProduct/{id}', [ProductsController::class, 'unactivateProduct'])->name('unactivateproduct');
Route::put('/admin/activateProduct/{id}', [ProductsController::class, 'activateProduct'])->name('activateproduct');