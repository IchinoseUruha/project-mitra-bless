<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthKasir;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KasirController;use App\Models\User;
use Illuminate\Http\Request;


Auth::routes();

Route::get('/about', function () {
    return view('about');
})->name('about');


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
    Route::get('/account-detail', [UserController::class, 'detailAccount'])->name('user.detail');
    Route::put('/account-detail/update', [UserController::class, 'updateAccount'])->name('user.update-account');
});

// Pindahkan ini SEBELUM middleware admin
Route::middleware(['auth'])->group(function () {
     // Checkout routes
     Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
     Route::post('/checkout/direct', [CheckoutController::class, 'directCheckout'])->name('checkout.direct');
     Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

//orders
Route::middleware(['auth'])->group(function () {
    Route::get('/order/details', [OrderController::class, 'show'])->name('order.details');
    Route::post('/order/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
    Route::post('/order/upload-bukti/{id}', [OrderController::class, 'uploadBukti'])->name('order.upload-bukti');
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

    //daftar pemesanan
    Route::get('/admin/daftar-pemesanan', [AdminController::class, 'showDaftarPemesanan'])->name('admin.pemesanan');

    //daftar customer
    Route::get('/admin/daftar-customer',[AdminController::class, 'showDaftarCustomer'])->name('admin.customer');


});

Route::middleware(['auth', AuthKasir::class])->group(function(){
    Route::get('/kasir', [KasirController::class, 'showKasir'])->name('kasir.index');
    Route::get('/kasir/daftar-pemesanan', [KasirController::class, 'showDaftarPemesanan'])->name('kasir.pemesanan');
    Route::get('/kasir/daftar-pemesanan-offline',[KasirController::class, 'showOrderOffline'])->name('kasir.pemesanan.offline');
    Route::get('/kasir/daftar-pemesanan/updateStatus/{id}', [OrderController::class, 'updateStatus'])->name('kasir.orderitem.updateStatus');
    Route::get('/kasir/order/{id}/detail', [OrderController::class, 'getOrderDetail'])->name('kasir.order.detail');
    Route::post('/kasir/pemesanan/{id}  /cancel', [KasirController::class, 'cancelOrder'])->name(name: 'kasir.pemesanan.cancel');
    Route::get('/kasir/order', [KasirController::class, 'showOrder'])->name('kasir.order');
    Route::get('/kasir/search', [KasirController::class, 'searchProducts'])->name('kasir.search');
    Route::post('/kasir/process-offline-order', [KasirController::class, 'processOfflineOrder'])->name('kasir.process-offline-order');
    Route::get('/kasir/invoice/offline/{id}/download', [InvoiceController::class, 'downloadOfflineInvoice'])->name('kasir.invoice.offline.download');
    Route::get('/kasir/invoice/online/{id}/download', [InvoiceController::class, 'downloadOnlineInvoice'])->name('kasir.invoice.online.download');
    Route::get('/kasir/search-customer-emails', function (Request $request) {
        $query = $request->input('query');
        return User::where('email', 'LIKE', "%{$query}%")
                   ->whereIn('utype', ['customer_r', 'customer_b'])
                   ->select('id', 'email')
                   ->limit(5)
                   ->get();
    })->name('search.customer.emails');
});