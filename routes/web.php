<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Models\Product;
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
Route::resource('products',ProductController::class);

// route::get('/products/{id}',[ProductController::class, 'show']);
Route::resource('home',PageController::class);
Route::resource('user',UserController::class);

// route::get('singup',function(){
// return view('banhang.singup');
// })->name('singup');
Route::get('login',function(){
return view('banhang.login');
})->name('login');

Route::get('about',function(){
return view('banhang.about');
})->name('about');

Route::get('contact',function(){
return view('banhang.contact');
})->name('contact');

// Route::get('checkout',function(){
// return view('banhang.checkout');
// })->name('checkout');

Route::get('product_type/{type}', [PageController::class, 'getLoaisp'])->name('banhang.product_type');

Route::get('add_to_cart/{id}', [PageController::class, 'addToCart'])->name('themgiohang');
Route::get('dele_to_cart/{id}', [PageController::class, 'deleToCart'])->name('xoagiohang');

// Route::get('product',function(){
//         return view('admin.sanpham.show_sanpham');
//         })->name('products.index ');

// ROute::get('product', [ProductController::class, 'index2'])->name('Product');
// ROute::get('product', [ProductController::class, 'getProduct'])->name('Pr');
Route::get('Category', [ProductController::class, 'listCategory'])->name('Category');
Route::get('category', [ProductController::class, 'createCate'])->name('CreateDM');
Route::post('category', [ProductController::class, 'storeCate'])->name('AddDM');
Route::get('edit_danhmuc/{id}', [ProductController::class, 'editCategory'])->name('EditDM');
Route::get('detroy', [ProductController::class, 'deleCategory']);   
Route::get('UpdateCategory/{id}', [ProductController::class, 'updateCategory'])->name('UpdateDM');

ROute::get('product', [ProductController::class, 'index'])->name('Product');
Route::get('addproduct', [ProductController::class, 'create'])->name('CrProduct');
Route::get('Product', [ProductController::class, 'store'])->name('AddProduct');
Route::get('UpdateProduct/{id}', [ProductController::class, 'update'])->name('UpdateSP');
Route::get('edit_sanpham/{id}', [ProductController::class, 'edit'])->name('Edit');
Route::get('detroySP', [ProductController::class, 'destroy']);   

Route::post('dat-hang', [PageController::class, 'postCheckout'])->name('dathang');
Route::get('dat-hang', [PageController::class, 'getCheckout'])->name('Dathang');


Route::get('singup',[PageController::class,'getSingup'])->name('singup');
Route::post('singup',[PageController::class,'postSignup'])->name('postsingup');
Route::get('getlogin',[PageController::class,'getLogin'])->name('getlogin');
Route::post('postlogin',[PageController::class,'postLogin'])->name('postlogin');

Route::get('admin_home', [PageController::class, 'getAdminHome'])->name('admin_home');
// Route::get('admin_home2', function(){
//         return view('admin.master');
// });
Route::get('login',[PageController::class,'getLoginAdmin'])->name('Login');
Route::post('postLogin',[PageController::class,'postLoginAdmin'])->name('postLoginAdmin')->middleware('adminlogin');      
Route::get('detroy', [UserController::class, 'destroy']);   
Route::get('user',[PageController::class,'getUser'])->name('User');

Route::get('test', [UserController::class, 'update'])->name('UserP');

//email
Route::post('input-email',[PageController::class,'postInputEmail'])->name('postInputEmail');

// Route::get('UserP', function(){
//         return view('admin.user.index');
// });

