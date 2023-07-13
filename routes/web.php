<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;

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

Route::get('/', function () {
    return view('welcome');
});



Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(ProductController::class)->group(function() {
    Route::get('/productsList', 'productsList')->name('productsList');
    Route::get('/create', 'create')->name('createProduct');
   
});

Route::controller(CategoryController::class)->group(function() {
    Route::get('/category', 'categoryIndex')->name('category');
    Route::get('/category/create', 'create')->name('categoryCreate');
    Route::post('/category/store', 'store')->name('category-store');
   
});


Route::get('/shopping-cart', [ProductController::class, 'productCart'])->name('shopping.cart');
Route::get('/product/{id}', [ProductController::class, 'addProducttoCart'])->name('addProduct.to.cart');
Route::patch('/update-shopping-cart', [ProductController::class, 'updateCart'])->name('update.sopping.cart');
Route::delete('/delete-cart-product', [ProductController::class, 'deleteProduct'])->name('delete.cart.product');


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});	


