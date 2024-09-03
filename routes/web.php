<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Frontendcontroller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Productcontroller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\SubCategorController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;

//Frontend
Route::get('/', [Frontendcontroller::class,'welcome'])->name('index');
Route::get('/dashboard', [HomeController::class,'admin_panel'])->middleware(['auth', 'verified'])->name('admin.panel');
Route::get('/user/logout', [HomeController::class,'logout'])->name('user.logout');
Route::get('/product/details/{slug}', [Frontendcontroller::class,'product_details'])->name('product.details');
Route::post('/getSizes', [Frontendcontroller::class,'getSizes']);
Route::post('/getStock', [Frontendcontroller::class,'getStock']);
Route::get('/cart', [Frontendcontroller::class,'cart'])->name('cart');
Route::get('/checkout', [Frontendcontroller::class,'checkout'])->name('checkout');
Route::get('/shop',[Frontendcontroller::class, 'shop'])->name('shop');
Route::get('/recent/views',[Frontendcontroller::class, 'recent_views'])->name('recent.views');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Users
Route::get('/user/edit', [UserController::class, 'user_edit'])->name('user.edit');
Route::post('/user/update', [UserController::class, 'user_update'])->name('user.update');
Route::post('/password/update', [UserController::class, 'password_update'])->name('password.update');
Route::post('/user/photo/update', [UserController::class, 'user_photo_update'])->name('user.photo.update');
Route::get('/user/list/', [UserController::class, 'user_list'])->name('user.list');
Route::get('/user/delete/{id}', [UserController::class, 'user_delete'])->name('user.delete');

//Categories
Route::get('/add/category', [CategoryController::class, 'add_category'])->name('add.category');
Route::post('/store/category', [CategoryController::class, 'store_category'])->name('store.category');
Route::get('/delete/category/{id}',[CategoryController::class, 'del_category'])->name('delete.category');
Route::get('/edit/category/{id}',[CategoryController::class, 'edit_category'])->name('edit.category');
Route::post('/update/category/{id}',[CategoryController::class, 'update_category'])->name('update.category');
Route::get('/trash/category/',[CategoryController::class, 'trash_category'])->name('trash.category');
Route::get('/restore/category/{id}',[CategoryController::class, 'restore_category'])->name('restore.category');
Route::get('/hard/del/category/{id}',[CategoryController::class, 'hard_del_category'])->name('hard.del.category');
Route::post('/check/delete', [CategoryController::class, 'check_delete'])->name('check.delete');
Route::post('/restore/checked', [CategoryController::class, 'restore_checked'])->name('restore.checked');
//Sub category
Route::get('/subcategory',[SubCategorController::class, 'subcategory'])->name('subcategory');
Route::post('/subcategory/store',[SubCategorController::class, 'subcategory_store'])->name('subcategory.store');
Route::get('/edit/subcategory/{id}',[SubCategorController::class, 'edit_subcategory'])->name('edit.subcategory');
Route::post('/update/subcategory/{id}',[SubCategorController::class, 'subcategory_update'])->name('subcategory.update');
Route::get('/delete/subcategory/{id}',[SubCategorController::class, 'delete_subcategory'])->name('delete.subcategory');

//Brand
Route::get('/product/brand/',[BrandController::class, 'brand'])->name('brand');
Route::post('/brand/store/',[BrandController::class, 'brand_store'])->name('brand.store');
Route::get('/brand/delete/{id}',[BrandController::class, 'brand_delete'])->name('brand.delete');

//tags
Route::get('/product/tags/',[TagController::class,'tags'])->name('tags');
Route::post('/tag/store/',[TagController::class,'tag_store'])->name('tag.store');
Route::get('/tag/delete/{id}',[TagController::class,'tag_delete'])->name('tag.delete');

//Product
Route::get('add/product/',[Productcontroller::class,'add_product'])->name('add.product');
Route::post('/getsubcategory',[Productcontroller::class,'getsubcategory']);
Route::post('/product/store',[Productcontroller::class,'product_store'])->name('product.store');
Route::get('/product/list',[Productcontroller::class,'product_list'])->name('product.list');
Route::get('/product/view/{id}',[Productcontroller::class,'product_view'])->name('product.view');
Route::get('/product/delete/{id}',[Productcontroller::class,'product_delete'])->name('product.delete');

//Variation
Route::get('/add/variation/',[InventoryController::class,'add_variation'])->name('add.variation');
Route::post('/color/store/',[InventoryController::class,'color_store'])->name('color.store');
Route::get('/color/delete/{id}',[InventoryController::class,'color_delete'])->name('color.delete');
Route::get('/size/delete/{id}',[InventoryController::class,'size_delete'])->name('size.delete');
Route::post('/size/store/',[InventoryController::class,'size_store'])->name('size.store');
Route::get('/inventory/{id}',[InventoryController::class,'inventory'])->name('inventory');
Route::post('/inventory/store/{id}',[InventoryController::class,'inventory_store'])->name('inventory.store');
Route::get('/inventory/delete/{id}',[InventoryController::class,'inventory_delete'])->name('inventory.delete');


//banner
Route::get('/add/banner',[BannerController::class,'add_banner'])->name('add.banner');
Route::post('/banner/store',[BannerController::class,'banner_store'])->name('banner.store');
Route::get('/banner/status/{id}',[BannerController::class,'banner_status'])->name('banner.status');
Route::get('/banner/delete/{id}',[BannerController::class,'banner_delete'])->name('banner.delete');

//Offer Slider
Route::get('/add/offer',[OfferController::class,'add_offer'])->name('add.offer');
Route::post('/offer/store',[OfferController::class,'offer_store'])->name('offer.store');
Route::get('/offer/status/{id}',[OfferController::class,'offer_status'])->name('offer.status');
Route::get('/offer/delete/{id}',[OfferController::class,'offer_delete'])->name('offer.delete');

//Subscribers
Route::get('/edits/subscriber/', [SubscriberController::class,'edit_subscriber'])->name('edit.subscriber');
Route::post('update/subscribertext/{id}', [SubscriberController::class,'subtext_update'])->name('subtext.update');
Route::post('store/subscriber/', [SubscriberController::class,'subscriber_store'])->name('subscriber.store');
Route::get('/delete/subscriber/{id}', [SubscriberController::class,'subscriber_delete'])->name('subscriber.delete');

//Customer
Route::get('/customer/login',[CustomerAuthController::class,'customer_login'])->name('customer.login');
Route::get('/customer/register',[CustomerAuthController::class,'customer_register'])->name('customer.register');
Route::post('/customer/store',[CustomerAuthController::class,'customer_store'])->name('customer.store');
Route::post('/customerlogin',[CustomerAuthController::class,'customerlogin'])->name('customerlogin');
Route::get('/customer/logout',[CustomerAuthController::class,'customer_logout'])->name('customer.logout');
Route::get('/customer/profile',[CustomerController::class,'customer_profile'])->name('customer.profile')->middleware
('customer_login_check');
Route::post('/customer/info/update',[CustomerController::class,'customer_update'])->name('customer.info.update');
Route::get('/my/order',[CustomerController::class,'my_order'])->name('my.order');
Route::get('/download/invoice/{id}',[CustomerController::class,'download_invoice'])->name('download.invoice');
//email verify
Route::get('/customer/mail/verify{token}',[CustomerController::class,'customer_mail_verify'])->name('customer.mail.verify');
Route::get('/mail/verify/req',[CustomerAuthController::class,'mail_verify_req'])->name('mail.verify.req');
Route::post('/mail/verify/req/send',[CustomerAuthController::class,'mail_verify_req_send'])->name('mail.verify.req.send');

//Cart
Route::post('/add/to/cart/{product_id}', [CartController::class, 'add_cart'])->name('add.cart');
Route::get('/cart/remove/{cart_id}', [CartController::class, 'cart_remove'])->name('cart.remove');
Route::post('/cart/update/', [CartController::class, 'cart_update'])->name('cart.update');


//Coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/coupon/store', [CouponController::class, 'coupon_store'])->name('coupon.store');
Route::get('/coupon/delete/{id}', [CouponController::class, 'coupon_del'])->name('coupon.del');

//checkout
Route::post('/getCity', [CheckoutController::class, 'getCity']);
Route::post('/order/confirm', [CheckoutController::class, 'order_confirm'])->name('order.confirm');
Route::get('/order/success', [CheckoutController::class, 'order_success'])->name('order.success');


// SSLCOMMERZ Start
Route::get('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

//stripe
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe')->name('stripe');
    Route::post('stripe/{id}', 'stripePost')->name('stripe.post');
});


//orders
Route::get('/orders',[OrderController::class, 'orders'] )->name('orders');
Route::post('/change/order/status/{id}',[OrderController::class, 'change_order_status'] )->name('change.order.status');
Route::post('/review/store{product_id}',[OrderController::class, 'review_store'] )->name('review.store');


//Password Reset
Route::get('/pass/reset/req',[CustomerController::class, 'pass_reset_req'] )->name('pass.reset.req');
Route::post('/pass/reset/req/send',[CustomerController::class, 'pass_reset_req_send'] )->name('pass.reset.req.send');
Route::get('/pass/reset/form/{token}',[CustomerController::class, 'pass_reset_form'] )->name('pass.reset.form');
Route::post('/pass/reset/update/{token}',[CustomerController::class, 'pass_reset_update'] )->name('pass.reset.update');

//Role Manager
Route::get('/role/manager/',[RoleController::class, 'role_manager'])->name('role.manager');
Route::post('/permission/store/',[RoleController::class, 'permission_store'])->name('permission.store');
Route::post('/add/role/',[RoleController::class, 'add_role'])->name('add.role');
Route::get('/del/role/{role_id}',[RoleController::class, 'del_role'])->name('del.role');
Route::post('/assign/role/',[RoleController::class, 'assign_role'])->name('assign.role');
Route::get('/remove/role/{user_id}',[RoleController::class, 'remove_role'])->name('remove.role');

//Social Login
Route::get('/github/redirect', [SocialLoginController::class, 'github_redirect'])->name('github.redirect');
Route::get('/github/callback', [SocialLoginController::class, 'github_callback'])->name('github.callback');

Route::get('/google/redirect', [SocialLoginController::class, 'google_redirect'])->name('google.redirect');
Route::get('/google/callback', [SocialLoginController::class, 'google_callback'])->name('google.callback');
