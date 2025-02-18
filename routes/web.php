<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassifyController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/trang-chu', [HomeController::class, 'index'])->name('trang-chu');


## trang sản phẩm

Route::get('/san-pham', [ProductController::class, 'show_product'])->name('san-pham');

## phân loại lọc 
Route::get('/phan-loai/{phanloai_id}', [CategoryProduct::class, 'show_phanloai_loc'])->name('phan-loai');

## hiển thị sản phẩm theo danh mục home
Route::get('/danh-muc/{danhmuc_id}', [CategoryProduct::class, 'show_danhmuc_home'])->name('danh-muc');
Route::get('/xem-san-pham/{sanpham_id}', [ProductController::class, 'show_chitiet_sanpham'])->name('xem-san-pham');

## hiển thị sản phẩm theo thuong hieu home
Route::get('/thuong-hieu/{hang_id}', [BrandProduct::class, 'show_thuonghieu_home'])->name('thuong-hieu');

## tìm kiếm sản phẩm trên home
Route::post('/Search', [HomeController::class, 'Search'])->name('Search');

## Giỏ hàng
Route::post('/save-cart', [CartController::class, 'save_cart'])->name('save-cart');
Route::get('/show-cart', [CartController::class, 'show_cart'])->name('show-cart');
Route::get('/delete-to-cart/{rowID}', [CartController::class, 'delete_to_cart'])->name('delete-to-cart');
Route::post('/update-cart-qty', [CartController::class, 'update_cart_qty'])->name('update-cart-qty');


## login-thanh toán
Route::get('/login-checkout', [CheckOutController::class, 'login_checkout'])->name('login-checkout');
Route::get('/logout-checkout', [CheckOutController::class, 'logout_checkout'])->name('logout-checkout');

Route::get('/checkout', [CheckOutController::class, 'checkout'])->name('checkout');
Route::post('/save-checkout', [CheckOutController::class, 'save_checkout'])->name('save-checkout');
Route::get('/payment', [CheckOutController::class, 'payment'])->name('payment');
## user
Route::post('/login-khachhang', [CheckOutController::class, 'login_khachhang'])->name('login-khachhang');
Route::post('/dangky-khachhang', [CheckOutController::class, 'dangky_khachhang'])->name('dangky-khachhang');

## admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin'); ## đăng nhập admin
Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');
Route::post('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');


//  Test:

// ADMIN:
Route::get('/login', [HomeController::class, 'login'])->name('login');

##ClassifyProduct
Route::get('/add-classify-product', [ClassifyController::class, 'add_classify_product'])->name('add-classify');
Route::get('/all-classify-product', [ClassifyController::class, 'all_classify_product'])->name('all-classify');


Route::post('/save-classify-product', [ClassifyController::class, 'save_classify_product'])->name('save-classify');
Route::get('/edit-classify-product/{classify_id}', [ClassifyController::class, 'edit_classify_product'])->name('edit-classify');
Route::post('/update-classify-product/{classify_id}', [ClassifyController::class, 'update_classify_product'])->name('update-classify');
Route::get('/delete-classify-product/{classify_id}', [ClassifyController::class, 'delete_classify_product'])->name('delete-classify');

Route::get('/search-classify-product', [ClassifyController::class, 'search_classify_product'])->name('search-classify');
## CategoryProduct

Route::get('/add-category-product', [CategoryProduct::class, 'add_category_product'])->name('add-category');
Route::get('/all-category-product', [CategoryProduct::class, 'all_category_product'])->name('all-category');

Route::post('/save-category-product', [CategoryProduct::class, 'save_category_product'])->name('save-category');
Route::get('/edit-category-product/{category_id}', [CategoryProduct::class, 'edit_category_product'])->name('edit-category');
Route::post('/update-category-product/{category_id}', [CategoryProduct::class, 'update_category_product'])->name('update-category');
Route::get('/delete-category-product/{category_id}', [CategoryProduct::class, 'delete_category_product'])->name('delete-category');

Route::get('/unactive-category-product/{category_id}', [CategoryProduct::class, 'unactive_category_product'])->name('unactive-category');
Route::get('/active-category-product/{category_id}', [CategoryProduct::class, 'active_category_product'])->name('active-category');


## Brand_product
Route::get('/add-brand-product', [BrandProduct::class, 'add_brand_product'])->name('add-brand');
Route::get('/all-brand-product', [BrandProduct::class, 'all_brand_product'])->name('all-brand');

Route::post('/save-brand', [BrandProduct::class, 'save_brand_product'])->name('save-brand');
Route::get('/edit-brand-product/{brand_id}', [BrandProduct::class, 'edit_brand_product'])->name('edit-brand');
Route::post('/update-brand-product/{brand_id}', [BrandProduct::class, 'update_brand_product'])->name('update-brand');
Route::get('/delete-brand-product/{brand_id}', [BrandProduct::class, 'delete_brand_product'])->name('delete-brand');

Route::get('/unactive-brand-product/{brand_id}', [BrandProduct::class, 'unactive_brand_product'])->name('unactive-brand');
Route::get('/active-brand-product/{brand_id}', [BrandProduct::class, 'active_brand_product'])->name('active-brand');


## product
Route::get('/add-product', [ProductController::class, 'add_product'])->name('add-product');
Route::get('/all-product', [ProductController::class, 'all_product'])->name('all-product');

Route::post('/save-product', [ProductController::class, 'save_product'])->name('save-product');
Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product'])->name('edit-product');
Route::post('/update-product/{product_id}', [ProductController::class, 'update_product'])->name('update-product');
Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product'])->name('delete-product');

Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product'])->name('unactive-product');
Route::get('/active-product/{product_id}', [ProductController::class, 'active_product'])->name('active-product');

Route::get('/edit-hdsd-product/{product_id}', [ProductController::class, 'edit_hdsd_product'])->name('edit-hdsd-product');
Route::post('/update-hdsd-product/{product_id}', [ProductController::class, 'update_hdsd_product'])->name('update-hdsd-product');

## orders
Route::get('/manage-orders', [CheckOutController::class, 'manage_orders'])->name('manage-orders');
Route::get('/view-order/{order_id}', [CheckOutController::class, 'view_order'])->name('view-order');
Route::get('/delete-order/{order_id}', [CheckOutController::class, 'manage_orders'])->name('delete-order');

# chien