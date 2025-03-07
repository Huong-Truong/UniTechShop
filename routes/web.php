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
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BaoHanhController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\FileController;
// use App\Http\Controllers\CheckOutController;



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


## Thêm dịch vụ của sản phẩm vào giỏ hàng
Route::post('/add-service-cart', [CartController::class, 'add_service_cart'])->name('add-service-cart');

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


## đặt hàng
Route::post('/order-place', [CheckOutController::class, 'order_place'])->name('order-place');
## admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin'); ## đăng nhập admin
Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');
Route::post('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');


//trang lien he
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');


//  Test:

// Send mail
Route::get('/send-mail', [HomeController::class, 'send_mail'])->name('send-mail');
Route::post('/send-order',[HomeController::class, 'send_order'])->name('send-order');


//  Cổng thanh toán
// routes/web.php
Route::get('vnpay_payment', [CheckOutController::class, 'vnpay_payment'])->name('vnpay_payment');
Route::get('vnpay_return', [CheckOutController::class, 'return'])->name('vnpay.return');

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

Route::post('/import-classify', [ClassifyController::class, 'import_classify'])->name('import-classify');



## CategoryProduct

Route::get('/add-category-product', [CategoryProduct::class, 'add_category_product'])->name('add-category');
Route::get('/all-category-product', [CategoryProduct::class, 'all_category_product'])->name('all-category');

Route::post('/save-category-product', [CategoryProduct::class, 'save_category_product'])->name('save-category');
Route::get('/edit-category-product/{category_id}', [CategoryProduct::class, 'edit_category_product'])->name('edit-category');
Route::post('/update-category-product/{category_id}', [CategoryProduct::class, 'update_category_product'])->name('update-category');
Route::get('/delete-category-product/{category_id}', [CategoryProduct::class, 'delete_category_product'])->name('delete-category');

Route::get('/unactive-category-product/{category_id}', [CategoryProduct::class, 'unactive_category_product'])->name('unactive-category');
Route::get('/active-category-product/{category_id}', [CategoryProduct::class, 'active_category_product'])->name('active-category');

Route::post('/import-category', [CategoryProduct::class, 'import_category'])->name('import-category');

## Brand_product
Route::get('/add-brand-product', [BrandProduct::class, 'add_brand_product'])->name('add-brand');
Route::get('/all-brand-product', [BrandProduct::class, 'all_brand_product'])->name('all-brand');

Route::post('/save-brand', [BrandProduct::class, 'save_brand_product'])->name('save-brand');
Route::get('/edit-brand-product/{brand_id}', [BrandProduct::class, 'edit_brand_product'])->name('edit-brand');
Route::post('/update-brand-product/{brand_id}', [BrandProduct::class, 'update_brand_product'])->name('update-brand');
Route::get('/delete-brand-product/{brand_id}', [BrandProduct::class, 'delete_brand_product'])->name('delete-brand');

Route::get('/unactive-brand-product/{brand_id}', [BrandProduct::class, 'unactive_brand_product'])->name('unactive-brand');
Route::get('/active-brand-product/{brand_id}', [BrandProduct::class, 'active_brand_product'])->name('active-brand');

Route::post('/import-brand', [BrandProduct::class, 'import_brand'])->name('import-brand');


## product
Route::get('/add-product', [ProductController::class, 'add_product'])->name('add-product');
Route::get('/all-product', [ProductController::class, 'all_product'])->name('all-product');

Route::post('/save-product', [ProductController::class, 'save_product'])->name('save-product');
Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product'])->name('edit-product');
Route::post('/update-product/{product_id}', [ProductController::class, 'update_product'])->name('update-product');
Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product'])->name('delete-product');

Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product'])->name('unactive-product');
Route::get('/active-product/{product_id}', [ProductController::class, 'active_product'])->name('active-product');

Route::get('/edit-other-info-product/{product_id}', [ProductController::class, 'edit_other_info_product'])->name('edit-other-info-product');
Route::post('/update-other-info-product/{product_id}', [ProductController::class, 'update_other_info_product'])->name('update-other-info-product');

Route::get('/fil-by-cate', [ProductController::class, 'filter_by_cate'])->name('fill-by-cate');
Route::get('/fil-by-brand', [ProductController::class, 'filter_by_brand'])->name('fill-by-brand');

Route::get('/search-product', [ProductController::class, 'search_product'])->name('search-product');
Route::post('/import-product', [ProductController::class, 'import_product'])->name('import-product');

## Gallery 
Route::get('/add-gallery/{product_id}', [GalleryController::class, 'add_gallery'])->name('add-gallery');
Route::post('/select-gallery', [GalleryController::class, 'select_gallery'])->name('select-gallery');
Route::post('/insert-gallery/{product_id}', [GalleryController::class, 'insert_gallery'])->name('insert-gallery');
Route::post('/update-gallery', [GalleryController::class, 'update_gallery'])->name('update-gallery');
Route::post('/delete-gallery', [GalleryController::class, 'delete_gallery'])->name('delete-gallery');

## Sales
Route::get('/all-sales', [SalesController::class, 'all_sales'])->name('all-sales');
Route::get('/add-sales', [SalesController::class, 'add_sales'])->name('add-sales');
Route::get('/delete-sales/{sale_id}', [SalesController::class, 'delete_sales'])->name('delete-sales');
Route::post('/save-sales', [SalesController::class, 'save_sales'])->name('save-sales');
Route::get('/set-sale/{product_id}', [SalesController::class, 'set_sale'])->name('set-sale');
Route::post('/save-set-sale/{product_id}', [SalesController::class, 'save_set_sale'])->name('save-set-sale');

## BaoHanh
Route::get('/all-baohanh', [BaoHanhController::class, 'all_baohanh'])->name('all-baohanh');
Route::get('/add-baohanh', [BaoHanhController::class, 'add_baohanh'])->name('add-baohanh');
Route::get('/delete-baohanh/{baohanh_id}', [BaoHanhController::class, 'delete_baohanh'])->name('delete-baohanh');
Route::post('/save-baohanh', [BaoHanhController::class, 'save_baohanh'])->name('save-baohanh');
# Route::get('/set-baohanh/{product_id}', [BaoHanhController::class, 'set_sale'])->name('set-sale');
# Route::post('/save-set-baohanh/{product_id}', [BaoHanhController::class, 'save_set_sale'])->name('save-set-sale');


## Service
Route::get('/all-service', [ServiceController::class, 'all_service'])->name('all-service');
Route::get('/add-service', [ServiceController::class, 'add_service'])->name('add-service');
Route::get('/delete-service/{service_id}', [ServiceController::class, 'delete_service'])->name('delete-service');
Route::post('/save-service', [ServiceController::class, 'save_service'])->name('save-service');
# Route::get('/set-service/{product_id}', [ServiceController::class, 'set_service'])->name('set-service');
Route::post('/save-set-service/{product_id}', [ServiceController::class, 'save_set_service'])->name('save-set-service');

## orders
Route::get('/manage-orders', [CheckOutController::class, 'manage_orders'])->name('manage-orders');
Route::get('/view-order/{donhang_id}', [CheckOutController::class, 'view_order'])->name('view-order');
Route::get('/delete-order/{donhang_id}', [CheckOutController::class, 'manage_orders'])->name('delete-order');
## cập nhật trang thái đơn hàng
Route::get('/update-status', [CheckOutController::class, 'update_status'])->name('update-status');

# chien

// Quen MK
Route::get('/forgot-pass', [HomeController::class, 'forgot_pass'])->name('forgot-pass');
Route::post('/review-pass', [HomeController::class, 'review_pass'])->name('review-pass');
Route::post('/send-contact', [HomeController::class, 'send_contact'])->name('send-contact');

// Nha cung cap
Route::get('/all-nhacungcap', [NhaCungCapController::class, 'all_nhacungcap'])->name('all-nhacungcap');
Route::get('/add-nhacungcap', [NhaCungCapController::class, 'add_nhacungcap'])->name('add-nhacungcap');
Route::get('/delete-nhacungcap/{nhacungcap_id}', [NhaCungCapController::class, 'delete_nhacungcap'])->name('delete-nhacungcap');
Route::post('/save-nhacungcap', [NhaCungCapController::class, 'save_nhacungcap'])->name('save-nhacungcap');
Route::get('/edit-nhacungcap/{nhacungcap_id}', [NhaCungCapController::class, 'edit_nhacungcap'])->name('edit-nhacungcap');
Route::post('/update-nhacungcap/{nhacungcap_id}', [NhaCungCapController::class, 'update_nhacungcap'])->name('update-nhacungcap');

// Storage
Route::get('/store-product', [StorageController::class, 'store'])->name('store-product');
Route::get('/fill-kho', [StorageController::class, 'fill_kho'])->name('fill-kho');
Route::get('/search-kho', [StorageController::class, 'search_kho'])->name('search-kho');

// File
Route::get('/download-classify', [FileController::class, 'download_classify'])->name('file-classify');
Route::get('/download-cate', [FileController::class, 'download_cate'])->name('file-cate');
Route::get('/download-brand', [FileController::class, 'download_brand'])->name('file-brand');
Route::get('/download-product', [FileController::class, 'download_product'])->name('file-product');
