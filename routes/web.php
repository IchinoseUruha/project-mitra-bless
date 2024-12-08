<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CheckoutController;


Auth::routes();

Route::get('/about', function () {
    return view('about');
});


Route::get('/order-history', [OrderController::class, 'index'])->name('order.history')->middleware('auth');
Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.details')->middleware('auth');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');
Route::get('/product/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');

//details
Route::post('/product/{id}/increase', [ProductController::class, 'increaseQuantity'])->name('product.increase');
Route::post('/product/{id}/decrease', [ProductController::class, 'decreaseQuantity'])->name('product.decrease');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_items'])->name('cart.add');
Route::put('/cart/increase-quantity/{rowId}', [CartController::class, 'increase_quantity'])->name('cart.quantity.increase');
Route::put('/cart/decrease-quantity/{rowId}', [CartController::class, 'decrease_quantity'])->name('cart.quantity.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_item'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear_cart'])->name('cart.clear');


Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});

// Pindahkan ini SEBELUM middleware admin
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout/direct', [CheckoutController::class, 'directCheckout'])->name('checkout.direct');
    
    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('order.history');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.details');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
    Route::post('/orders/{id}/confirm', [OrderController::class, 'confirm'])->name('order.confirm');
});


Route::middleware(['auth', AuthAdmin::class])->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    //brand
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add', [AdminController::class, 'add_brand'])->name('admin.brand.add');
    Route::post('/admin/brand/store', [AdminController::class, 'brand_store'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brand.edit');
    Route::put('/admin/brand/update', [AdminController::class, 'brand_update'])->name('admin.brand.update');
    Route::delete('/admin/brand/{id}/delete', [AdminController::class, 'brand_delete'])->name('admin.brand.delete');

    //category
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'add_category'])->name('admin.category.add');
    Route::post('/admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('/admin/category/edit/{id}', [AdminController::class, 'category_edit'])->name('admin.category.edit');
    Route::put('/admin/category/update', [AdminController::class, 'category_update'])->name('admin.category.update');
    Route::delete('/admin/category/{id}/delete', [AdminController::class, 'category_delete'])->name('admin.category.delete');

    //products
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/add', [AdminController::class, 'add_product'])->name('admin.product.add'); 
    Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    Route::get('/admin/product/edit/{id}', [AdminController::class, 'product_edit'])->name('admin.product.edit');
    Route::put('/admin/product/update', [AdminController::class, 'product_update'])->name('admin.product.update');
    Route::delete('/admin/product/{id}/delete', [AdminController::class, 'product_delete'])->name('admin.product.delete');


});