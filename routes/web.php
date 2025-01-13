<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\Frontend\BkashController;
use App\Http\Controllers\Frontend\SellerController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ShoppingController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\SmsreportController;
use App\Http\Controllers\Frontend\ShurjopayControllers;
use App\Http\Controllers\Frontend\SellerProductController;
use App\Http\Controllers\Frontend\SellerWalletController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\ChildcategoryController;
use App\Http\Controllers\Admin\ExpenseCategoriesController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\PixelsController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ApiIntegrationController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\BannerCategoryController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\PackagingCategoryController;
use App\Http\Controllers\Admin\PackagingManageController;
use App\Http\Controllers\Admin\BoostManageController;
use App\Http\Controllers\Admin\SellerManageController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\VideoCategoryController;
use App\Http\Controllers\Admin\OurServiceController;
use App\Http\Controllers\Admin\CreatePageController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\SpecialOfferController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\CustomerManageController;
use App\Http\Controllers\Admin\ShippingChargeController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\TagManagerController;
use App\Http\Controllers\Admin\FreeShippingController;
use App\Http\Controllers\Admin\RegistrationChargeController;
use App\Http\Controllers\Admin\NewstickerController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\SellersmsController;
use App\Http\Controllers\Admin\VentorwithdrawController;

Auth::routes();

Route::get('/cc', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cleared!";
});
//Route::get('/insertdata', [ChildcategoryController::class,'insertData'])->name('insert.index');

Route::group(['namespace' => 'Frontend', 'middleware' => ['ipcheck', 'check_refer']], function () {
    Route::get('/', [FrontendController::class, 'index'])->name('home');
    Route::get('category/{category}', [FrontendController::class, 'category'])->name('category');

    Route::get('subcategory/{subcategory}', [FrontendController::class, 'subcategory'])->name('subcategory');

    Route::get('products/{slug}', [FrontendController::class, 'products'])->name('products');

    Route::get('feature_product', [FrontendController::class, 'feature_product'])->name('feature_product');

    Route::get('on_sale', [FrontendController::class, 'on_sale'])->name('on_sale');
    Route::get('best_deals', [FrontendController::class, 'best_deals'])->name('best_deals');
    Route::get('toprated', [FrontendController::class, 'toprated'])->name('toprated');
    Route::get('baazarkorimall', [FrontendController::class, 'baazarkorimall'])->name('baazarkorimall');
    Route::get('seller-pro/{slug}/{id}', [FrontendController::class, 'yourshop'])->name('yourshop');
    Route::get('seller-cus/{slug}/{id}', [FrontendController::class, 'sellershop'])->name('sellershop');
    Route::get('hot-deals', [FrontendController::class, 'hotdeals'])->name('hotdeals');
    Route::get('livesearch', [FrontendController::class, 'livesearch'])->name('livesearch');
    Route::get('search', [FrontendController::class, 'search'])->name('search');
    Route::get('product/{id}', [FrontendController::class, 'details'])->name('product');
    Route::get('quick-view', [FrontendController::class, 'quickview'])->name('quickview');
    Route::get('/shipping-charge', [FrontendController::class, 'shipping_charge'])->name('shipping.charge');
    Route::get('site/contact-us', [FrontendController::class, 'contact'])->name('contact');
    Route::get('/page/{slug}', [FrontendController::class, 'page'])->name('page');
    Route::get('districts', [FrontendController::class, 'districts'])->name('districts');
    Route::get('shipping-districts', [FrontendController::class, 'shipping_districts'])->name('shipping_districts');
    Route::get('/campaign/{slug}', [FrontendController::class, 'campaign'])->name('campaign');
    Route::get('/specialoffer/{slug}', [FrontendController::class, 'specialoffer'])->name('specialoffer');
    Route::get('/offer', [FrontendController::class, 'offers'])->name('offers');
    Route::get('/payment-success', [FrontEndController::class, 'payment_success'])->name('payment_success');
    Route::get('/payment-cancel', [FrontEndController::class, 'payment_cancel'])->name('payment_cancel');
    Route::get('/shurjopay-method', [FrontendController::class, 'payment_shurjopay'])->name('payment.shurjopay');
    Route::get('/bkash-method', [FrontendController::class, 'payment_bkash'])->name('payment.bkash');
    Route::get('/nagad-method', [FrontendController::class, 'payment_nagad'])->name('payment.nagad');
    Route::get('/rock-method', [FrontendController::class, 'payment_rocket'])->name('payment.rocket');
    Route::get('/advanced-payment', [FrontendController::class, 'advanced_payment'])->name('advanced.payment');
    Route::get('/forget/advanced-payment', [FrontendController::class, 'forget_advanced'])->name('forget.advanced_payment');

    // cart route
    Route::post('cart/store', [ShoppingController::class, 'cart_store'])->name('cart.store');
    Route::post('customer/wholesell_store', [FrontEndController::class, 'wholesell_store'])->name('customer.wholesell_store');
    Route::get('/add-to-cart/{id}/{qty}', [ShoppingController::class, 'addTocartGet']);
    Route::get('cart', [ShoppingController::class, 'cart_show'])->name('cart');
    Route::get('cart/remove', [ShoppingController::class, 'cart_remove'])->name('cart.remove');
    Route::get('cart/count', [ShoppingController::class, 'cart_count'])->name('cart.count');
    Route::get('mobilecart/count', [ShoppingController::class, 'mobilecart_qty'])->name('mobile.cart.count');
    Route::get('cart/decrement', [ShoppingController::class, 'cart_decrement'])->name('cart.decrement');
    Route::get('cart/increment', [ShoppingController::class, 'cart_increment'])->name('cart.increment');
    Route::get('cart/remove_pg', [ShoppingController::class, 'cart_remove_pg'])->name('cart.remove_pg');
    Route::get('cart/decrement_pg', [ShoppingController::class, 'cart_decrement_pg'])->name('cart.decrement_pg');
    Route::get('cart/increment_pg', [ShoppingController::class, 'cart_increment_pg'])->name('cart.increment_pg');
    Route::get('cart/remove-bn', [ShoppingController::class, 'cart_remove_bn'])->name('cart.remove_bn');
    Route::get('cart/decrement-bn', [ShoppingController::class, 'cart_decrement_bn'])->name('cart.decrement_bn');
    Route::get('cart/increment-bn', [ShoppingController::class, 'cart_increment_bn'])->name('cart.increment_bn');
    
    Route::get('cart/product-size', [ShoppingController::class, 'product_size'])->name('product.size');
    Route::get('cart/product-color', [ShoppingController::class, 'product_color'])->name('product.color');

    // compare route
    Route::get('add-to-compare/{id}', [ShoppingController::class, 'add_compare'])->name('compare.add');
    Route::get('compare/content/', [ShoppingController::class, 'compare_content'])->name('compare.content');
    Route::get('compare-product/', [ShoppingController::class, 'compare_product'])->name('compare.product');
    Route::get('compare-product-add/{id}/{rowId}', [ShoppingController::class, 'compare_product_add'])->name('compare.productadd');
    Route::post('compare-remove-cart/', [ShoppingController::class, 'remove_compare'])->name('compare.remove');
    Route::post('reseller/update-cart', [ShoppingController::class, 'resellerupdateCart'])->name('reseller.update');

    // wishlist route
    Route::get('wishlist/store', [ShoppingController::class, 'wishlist_store'])->name('wishlist.store');
    Route::get('wishlist', [ShoppingController::class, 'wishlist_show'])->name('wishlist.show');
    Route::get('wishlist/remove', [ShoppingController::class, 'wishlist_remove'])->name('wishlist.remove');
    Route::get('wishlist/count', [ShoppingController::class, 'wishlist_count'])->name('wishlist.count');

    Route::get('customer/register_note', [CustomerController::class, 'register_note'])->name('customer.register_note');
});

Route::group(['prefix' => 'customer', 'namespace' => 'Frontend', 'middleware' => ['ipcheck', 'check_refer']], function () {
    Route::get('/login', [CustomerController::class, 'login'])->name('customer.login');
    Route::post('/signin', [CustomerController::class, 'signin'])->name('customer.signin');
    Route::get('/register', [CustomerController::class, 'register'])->name('customer.register');
    Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/verify', [CustomerController::class, 'verify'])->name('customer.verify');
    Route::post('/verify-account', [CustomerController::class, 'account_verify'])->name('customer.account.verify');
    Route::post('/resend-otp', [CustomerController::class, 'resendotp'])->name('customer.resendotp');
    Route::post('/logout', [CustomerController::class, 'logout'])->name('customer.logout');
    Route::post('/request', [CustomerController::class, 'request'])->name('customer.request');
    Route::post('/post/review', [CustomerController::class, 'review'])->name('customer.review');
    Route::get('/forgot-password', [CustomerController::class, 'forgot_password'])->name('customer.forgot.password');
    Route::post('/forgot-verify', [CustomerController::class, 'forgot_verify'])->name('customer.forgot.verify');
    Route::get('/forgot-password/reset', [CustomerController::class, 'forgot_reset'])->name('customer.forgot.reset');
    Route::post('/forgot-password/store', [CustomerController::class, 'forgot_store'])->name('customer.forgot.store');
    Route::post('/forgot-password/resendotp', [CustomerController::class, 'forgot_resend'])->name('customer.forgot.resendotp');
    Route::get('/checkout', [CustomerController::class, 'checkout'])->name('customer.checkout');
    Route::post('/order-save', [CustomerController::class, 'order_save'])->name('customer.ordersave');
    Route::get('/order-success/{id}', [CustomerController::class, 'order_success'])->name('customer.order_success');
    Route::get('/order-track', [CustomerController::class, 'order_track'])->name('customer.order_track');
    Route::get('/order-track/result', [CustomerController::class, 'order_track_result'])->name('customer.order_track_result');
});
// customer auth
Route::group(['prefix' => 'customer', 'namespace' => 'Frontend', 'middleware' => ['customer', 'ipcheck', 'check_refer']], function () {

    Route::get('/account', [CustomerController::class, 'account'])->name('customer.account');
    Route::get('/videouddokata', [CustomerController::class, 'videouddokata'])->name('customer.videouddokata');
    Route::get('/videoreseller', [CustomerController::class, 'videoreseller'])->name('customer.videoreseller');
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');

    Route::get('/withdraw', [CustomerController::class, 'withdraw'])->name('customer.withdraw');
    Route::get('/commissions', [CustomerController::class, 'commissions'])->name('customer.commissions');
    Route::get('/expense', [CustomerController::class, 'expense'])->name('customer.expense');
    Route::post('withdraw-request', [CustomerController::class, 'withdraw_request'])->name('customer.withdraw_request');

    Route::get('/boostc', [CustomerController::class, 'boostc'])->name('customer.boostc');
    Route::get('/boostc-request', [CustomerController::class, 'boostc_request'])->name('customer.boostc_request');
    Route::post('/boostc-store', [CustomerController::class, 'boostc_store'])->name('customer.boostc_store');

    Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');
    Route::post('order-cancel', [CustomerController::class,'order_cancel'])->name('customer.order_cancel');
    Route::get('/wallet', [CustomerController::class, 'wallet'])->name('customer.wallet');
    Route::get('/wallet-add', [CustomerController::class, 'wallet_add'])->name('customer.wallet_add');
    Route::post('/wallet-save', [CustomerController::class, 'wallet_save'])->name('wallet.save');
    Route::get('/invoice', [CustomerController::class, 'invoice'])->name('customer.invoice');
    Route::get('/invoice/order-note', [CustomerController::class, 'order_note'])->name('customer.order_note');
    Route::get('/profile-edit', [CustomerController::class, 'profile_edit'])->name('customer.profile_edit');
    Route::post('/profile-update', [CustomerController::class, 'profile_update'])->name('customer.profile_update');
    Route::get('/change-password', [CustomerController::class, 'change_pass'])->name('customer.change_pass');
    Route::post('/password-update', [CustomerController::class, 'password_update'])->name('customer.password_update');
    Route::get('/wishlist', [CustomerController::class, 'wishlist'])->name('customer.wishlist');
});

Route::group(['namespace' => 'Frontend', 'middleware' => ['ipcheck', 'check_refer']], function () {
    Route::get('bkash/checkout-url/pay', [BkashController::class, 'pay'])->name('url-pay');
    Route::any('bkash/checkout-url/create', [BkashController::class, 'create'])->name('url-create');
    Route::get('bkash/checkout-url/callback', [BkashController::class, 'callback'])->name('url-callback');

    Route::get('/payment-success', [ShurjopayControllers::class, 'payment_success'])->name('payment_success');
    Route::get('/payment-cancel', [ShurjopayControllers::class, 'payment_cancel'])->name('payment_cancel');
});


// seller route
Route::group(['prefix'=>'seller','namespace'=>'Frontend'], function() {
    Route::get('/login', [SellerController::class, 'login'])->name('seller.login');
    Route::post('/signin', [SellerController::class, 'signin'])->name('seller.signin');
    Route::get('/register', [SellerController::class, 'register'])->name('seller.register');
    Route::post('/store', [SellerController::class, 'store'])->name('seller.store');
    Route::get('/verify', [SellerController::class, 'verify'])->name('seller.verify');
    Route::post('/verify-account', [SellerController::class, 'account_verify'])->name('seller.account.verify');
    Route::post('/resend-otp', [SellerController::class, 'resendotp'])->name('seller.resendotp');
    Route::post('/logout', [SellerController::class, 'logout'])->name('seller.logout');
    Route::get('/forgot-password', [SellerController::class, 'forgot_password'])->name('seller.forgot.password');
    Route::post('/forgot-verify', [SellerController::class, 'forgot_verify'])->name('seller.forgot.verify');
    Route::get('/forgot-password/reset', [SellerController::class, 'forgot_reset'])->name('seller.forgot.reset');
    Route::post('/forgot-password/store', [SellerController::class, 'forgot_store'])->name('seller.forgot.store');
});

// seller auth
Route::group(['prefix'=>'seller','namespace'=>'Frontend','middleware' => ['seller']], function() {
    Route::get('/account', [SellerController::class, 'account'])->name('seller.account');
    Route::get('/sellervideo', [SellerController::class, 'sellervideo'])->name('seller.sellervideo');
    Route::get('/packet', [SellerController::class, 'packet'])->name('seller.packet');
    Route::get('/packet-request', [SellerController::class, 'packet_request'])->name('seller.packet_request');
    Route::post('/packet-store', [SellerController::class, 'packet_store'])->name('seller.packet_store');

    Route::get('/boost', [SellerController::class, 'boost'])->name('seller.boost');
    Route::get('/boost-request', [SellerController::class, 'boost_request'])->name('seller.boost_request');
    Route::post('/boost-store', [SellerController::class, 'boost_store'])->name('seller.boost_store');

    Route::get('/orders', [SellerController::class, 'orders'])->name('seller.orders');
    Route::post('order/process', [SellerController::class,'process'])->name('seller.order.process');
    Route::post('order/cancel', [SellerController::class,'cancel'])->name('seller.order.cancel');

    Route::get('invoice/{id}', [SellerController::class, 'invoice'])->name('seller.invoice');

    Route::get('/profile', [SellerController::class, 'profile'])->name('seller.profile');
    Route::get('/profile-edit', [SellerController::class, 'profile_edit'])->name('seller.profile_edit');
    Route::post('/profile-update', [SellerController::class, 'profile_update'])->name('seller.profile_update');
    Route::get('/change-password', [SellerController::class, 'change_pass'])->name('seller.change_pass');
    Route::post('/password-update', [SellerController::class, 'password_update'])->name('seller.password_update');
    Route::get('/withdraws', [SellerController::class, 'withdraws'])->name('seller.withdraws');
    Route::get('/sellerearn', [SellerController::class, 'sellerearn'])->name('seller.sellerearn');
    Route::get('/sellerexpense', [SellerController::class, 'sellerexpense'])->name('seller.sellerexpense');

    // product manage
    Route::get('products/manage', [SellerProductController::class,'index'])->name('seller.products.index');
    Route::get('products/{id}/show', [SellerProductController::class,'show'])->name('seller.products.show');
    Route::get('products/create', [SellerProductController::class,'create'])->name('seller.products.create');
    Route::post('products/save', [SellerProductController::class,'store'])->name('seller.products.store');
    Route::get('products/{id}/edit', [SellerProductController::class,'edit'])->name('seller.products.edit');
    Route::post('products/update', [SellerProductController::class,'update'])->name('seller.products.update');
    Route::post('products/inactive', [SellerProductController::class,'inactive'])->name('seller.products.inactive');
    Route::post('products/active', [SellerProductController::class,'active'])->name('seller.products.active');
    Route::post('products/destroy', [SellerProductController::class,'destroy'])->name('seller.products.destroy');
    Route::get('products/image/destroy', [SellerProductController::class,'imgdestroy'])->name('seller.products.image.destroy');

    // seller- wallet code route
    Route::get('/sellerwallet', [SellerWalletController::class, 'sellerwallet'])->name('seller.sellerwallet');
    Route::get('/sellerwallet-add', [SellerWalletController::class, 'sellerwallet_add'])->name('seller.sellerwallet_add');
    Route::post('/sellerwallet-save', [SellerWalletController::class, 'sellerwallet_save'])->name('seller.wallet.save');


    Route::post('sellerwithdraw-request', [SellerController::class, 'sellerwithdraw_request'])->name('seller.sellerwithdraw_request');


    // seller- sms report code route

    Route::get('/smsreport', [SmsreportController::class, 'smsreport'])->name('seller.smsreport');
    Route::get('/smsreport-add', [SmsreportController::class, 'smsreport_add'])->name('seller.smsreport_add');
    Route::post('/smsreport-save', [SmsreportController::class, 'smsreport_save'])->name('seller.smsreport.save');





});




// unathenticate admin route
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['customer', 'ipcheck', 'check_refer']], function () {
    Route::get('locked', [DashboardController::class, 'locked'])->name('locked');
    Route::post('unlocked', [DashboardController::class, 'unlocked'])->name('unlocked');
});

// ajax route
Route::get('/ajax-product-subcategory', [ProductController::class, 'getSubcategory']);
Route::get('/ajax-product-childcategory', [ProductController::class, 'getChildcategory']);

// auth route
Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'lock', 'check_refer'], 'prefix' => 'admin'], function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('change-password', [DashboardController::class, 'changepassword'])->name('change_password');
    Route::post('new-password', [DashboardController::class, 'newpassword'])->name('new_password');

    // users route
    Route::get('users/manage', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users/save', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('users/update', [UserController::class, 'update'])->name('users.update');
    Route::post('users/inactive', [UserController::class, 'inactive'])->name('users.inactive');
    Route::post('users/active', [UserController::class, 'active'])->name('users.active');
    Route::post('users/destroy', [UserController::class, 'destroy'])->name('users.destroy');

    // roles
    Route::get('roles/manage', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/{id}/show', [RoleController::class, 'show'])->name('roles.show');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles/save', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('roles/update', [RoleController::class, 'update'])->name('roles.update');
    Route::post('roles/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');

    // permissions
    Route::get('permissions/manage', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('permissions/{id}/show', [PermissionController::class, 'show'])->name('permissions.show');
    Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('permissions/save', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('permissions/update', [PermissionController::class, 'update'])->name('permissions.update');
    Route::post('permissions/destroy', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    // categories
    Route::get('categories/manage', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/{id}/show', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories/save', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('categories/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::post('categories/inactive', [CategoryController::class, 'inactive'])->name('categories.inactive');
    Route::post('categories/active', [CategoryController::class, 'active'])->name('categories.active');
    Route::post('categories/destroy', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::post('categories/sort', [CategoryController::class, 'sort'])->name('categories.sort');

    // Subcategories
    Route::get('subcategories/manage', [SubcategoryController::class, 'index'])->name('subcategories.index');
    Route::get('subcategories/{id}/show', [SubcategoryController::class, 'show'])->name('subcategories.show');
    Route::get('subcategories/create', [SubcategoryController::class, 'create'])->name('subcategories.create');
    Route::post('subcategories/save', [SubcategoryController::class, 'store'])->name('subcategories.store');
    Route::get('subcategories/{id}/edit', [SubcategoryController::class, 'edit'])->name('subcategories.edit');
    Route::post('subcategories/update', [SubcategoryController::class, 'update'])->name('subcategories.update');
    Route::post('subcategories/inactive', [SubcategoryController::class, 'inactive'])->name('subcategories.inactive');
    Route::post('subcategories/active', [SubcategoryController::class, 'active'])->name('subcategories.active');
    Route::post('subcategories/destroy', [SubcategoryController::class, 'destroy'])->name('subcategories.destroy');

    Route::post('subcategories/sort', [SubcategoryController::class, 'sort'])->name('subcategories.sort');

    // Childcategories


    Route::get('childcategories/manage', [ChildcategoryController::class, 'index'])->name('childcategories.index');
    Route::get('childcategories/{id}/show', [ChildcategoryController::class, 'show'])->name('childcategories.show');
    Route::get('childcategories/create', [ChildcategoryController::class, 'create'])->name('childcategories.create');
    Route::post('childcategories/save', [ChildcategoryController::class, 'store'])->name('childcategories.store');
    Route::get('childcategories/{id}/edit', [ChildcategoryController::class, 'edit'])->name('childcategories.edit');
    Route::post('childcategories/update', [ChildcategoryController::class, 'update'])->name('childcategories.update');
    Route::post('childcategories/inactive', [ChildcategoryController::class, 'inactive'])->name('childcategories.inactive');
    Route::post('childcategories/active', [ChildcategoryController::class, 'active'])->name('childcategories.active');
    Route::post('childcategories/destroy', [ChildcategoryController::class, 'destroy'])->name('childcategories.destroy');

    Route::post('childcategories/sort', [ChildcategoryController::class, 'sort'])->name('childcategories.sort');

    // paymentgeteway
    Route::get('paymentgeteway/manage', [ApiIntegrationController::class, 'pay_manage'])->name('paymentgeteway.manage');
    Route::post('paymentgeteway/save', [ApiIntegrationController::class, 'pay_update'])->name('paymentgeteway.update');

    // smsgeteway
    Route::get('smsgeteway/manage', [ApiIntegrationController::class, 'sms_manage'])->name('smsgeteway.manage');
    Route::post('smsgeteway/save', [ApiIntegrationController::class, 'sms_update'])->name('smsgeteway.update');

    // courierapi
    Route::get('courierapi/manage', [ApiIntegrationController::class, 'courier_manage'])->name('courierapi.manage');
    Route::post('courierapi/save', [ApiIntegrationController::class, 'courier_update'])->name('courierapi.update');

    // attribute
    Route::get('orderstatus/manage', [OrderStatusController::class, 'index'])->name('orderstatus.index');
    Route::get('orderstatus/{id}/show', [OrderStatusController::class, 'show'])->name('orderstatus.show');
    Route::get('orderstatus/create', [OrderStatusController::class, 'create'])->name('orderstatus.create');
    Route::post('orderstatus/save', [OrderStatusController::class, 'store'])->name('orderstatus.store');
    Route::get('orderstatus/{id}/edit', [OrderStatusController::class, 'edit'])->name('orderstatus.edit');
    Route::post('orderstatus/update', [OrderStatusController::class, 'update'])->name('orderstatus.update');
    Route::post('orderstatus/inactive', [OrderStatusController::class, 'inactive'])->name('orderstatus.inactive');
    Route::post('orderstatus/active', [OrderStatusController::class, 'active'])->name('orderstatus.active');
    Route::post('orderstatus/destroy', [OrderStatusController::class, 'destroy'])->name('orderstatus.destroy');

    // pixels
    Route::get('pixels/manage', [PixelsController::class, 'index'])->name('pixels.index');
    Route::get('pixels/{id}/show', [PixelsController::class, 'show'])->name('pixels.show');
    Route::get('pixels/create', [PixelsController::class, 'create'])->name('pixels.create');
    Route::post('pixels/save', [PixelsController::class, 'store'])->name('pixels.store');
    Route::get('pixels/{id}/edit', [PixelsController::class, 'edit'])->name('pixels.edit');
    Route::post('pixels/update', [PixelsController::class, 'update'])->name('pixels.update');
    Route::post('pixels/inactive', [PixelsController::class, 'inactive'])->name('pixels.inactive');
    Route::post('pixels/active', [PixelsController::class, 'active'])->name('pixels.active');
    Route::post('pixels/destroy', [PixelsController::class, 'destroy'])->name('pixels.destroy');

    // tag manager
    Route::get('tag-manager/manage', [TagManagerController::class, 'index'])->name('tagmanagers.index');
    Route::get('tag-manager/{id}/show', [TagManagerController::class, 'show'])->name('tagmanagers.show');
    Route::get('tag-manager/create', [TagManagerController::class, 'create'])->name('tagmanagers.create');
    Route::post('tag-manager/save', [TagManagerController::class, 'store'])->name('tagmanagers.store');
    Route::get('tag-manager/{id}/edit', [TagManagerController::class, 'edit'])->name('tagmanagers.edit');
    Route::post('tag-manager/update', [TagManagerController::class, 'update'])->name('tagmanagers.update');
    Route::post('tag-manager/inactive', [TagManagerController::class, 'inactive'])->name('tagmanagers.inactive');
    Route::post('tag-manager/active', [TagManagerController::class, 'active'])->name('tagmanagers.active');
    Route::post('tag-manager/destroy', [TagManagerController::class, 'destroy'])->name('tagmanagers.destroy');

    // attribute
    Route::get('brands/manage', [BrandController::class, 'index'])->name('brands.index');
    Route::get('brands/{id}/show', [BrandController::class, 'show'])->name('brands.show');
    Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('brands/save', [BrandController::class, 'store'])->name('brands.store');
    Route::get('brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::post('brands/update', [BrandController::class, 'update'])->name('brands.update');
    Route::post('brands/inactive', [BrandController::class, 'inactive'])->name('brands.inactive');
    Route::post('brands/active', [BrandController::class, 'active'])->name('brands.active');
    Route::post('brands/destroy', [BrandController::class, 'destroy'])->name('brands.destroy');

    // Newsticker
    Route::get('newsticker/manage', [NewstickerController::class,'index'])->name('newsticker.index');
    Route::get('newsticker/{id}/show', [NewstickerController::class,'show'])->name('newsticker.show');
    Route::get('newsticker/create', [NewstickerController::class,'create'])->name('newsticker.create');
    Route::post('newsticker/save', [NewstickerController::class,'store'])->name('newsticker.store');
    Route::get('newsticker/{id}/edit', [NewstickerController::class,'edit'])->name('newsticker.edit');
    Route::post('newsticker/update', [NewstickerController::class,'update'])->name('newsticker.update');
    Route::post('newsticker/inactive', [NewstickerController::class,'inactive'])->name('newsticker.inactive');
    Route::post('newsticker/active', [NewstickerController::class,'active'])->name('newsticker.active');
    Route::post('newsticker/destroy', [NewstickerController::class,'destroy'])->name('newsticker.destroy');

    // sms report code
    Route::get('sellersms/manage', [SellersmsController::class,'index'])->name('sellersms.index');
    Route::get('sellersms/{id}/show', [SellersmsController::class,'show'])->name('sellersms.show');
    Route::get('sellersms/{id}/smsshow', [SellersmsController::class,'smsshow'])->name('sellersms.smsshow');
    Route::post('sellersms/inactive', [SellersmsController::class,'inactive'])->name('sellersms.inactive');
    Route::post('sellersms/active', [SellersmsController::class,'active'])->name('sellersms.active');
    Route::post('sellersms/destroy', [SellersmsController::class,'destroy'])->name('sellersms.destroy');

    // color
    Route::get('color/manage', [ColorController::class, 'index'])->name('colors.index');
    Route::get('color/{id}/show', [ColorController::class, 'show'])->name('colors.show');
    Route::get('color/create', [ColorController::class, 'create'])->name('colors.create');
    Route::post('color/save', [ColorController::class, 'store'])->name('colors.store');
    Route::get('color/{id}/edit', [ColorController::class, 'edit'])->name('colors.edit');
    Route::post('color/update', [ColorController::class, 'update'])->name('colors.update');
    Route::post('color/inactive', [ColorController::class, 'inactive'])->name('colors.inactive');
    Route::post('color/active', [ColorController::class, 'active'])->name('colors.active');
    Route::post('color/destroy', [ColorController::class, 'destroy'])->name('colors.destroy');

    // size
    Route::get('size/manage', [SizeController::class, 'index'])->name('sizes.index');
    Route::get('size/{id}/show', [SizeController::class, 'show'])->name('sizes.show');
    Route::get('size/create', [SizeController::class, 'create'])->name('sizes.create');
    Route::post('size/save', [SizeController::class, 'store'])->name('sizes.store');
    Route::get('size/{id}/edit', [SizeController::class, 'edit'])->name('sizes.edit');
    Route::post('size/update', [SizeController::class, 'update'])->name('sizes.update');
    Route::post('size/inactive', [SizeController::class, 'inactive'])->name('sizes.inactive');
    Route::post('size/active', [SizeController::class, 'active'])->name('sizes.active');
    Route::post('size/destroy', [SizeController::class, 'destroy'])->name('sizes.destroy');


    // product
    Route::get('products/manage', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{id}/show', [ProductController::class, 'show'])->name('products.show');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products/save', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('products/update', [ProductController::class, 'update'])->name('products.update');
    Route::post('products/inactive', [ProductController::class, 'inactive'])->name('products.inactive');
    Route::post('products/active', [ProductController::class, 'active'])->name('products.active');
    Route::post('products/destroy', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('products/image/destroy', [ProductController::class, 'imgdestroy'])->name('products.image.destroy');
    Route::get('products/price/destroy', [ProductController::class, 'pricedestroy'])->name('products.price.destroy');
    Route::get('products/update-deals', [ProductController::class, 'update_deals'])->name('products.update_deals');
    Route::get('products/update-feature', [ProductController::class, 'update_feature'])->name('products.update_feature');
    Route::get('products/update-status', [ProductController::class, 'update_status'])->name('products.update_status');
    Route::get('products/price-edit', [ProductController::class, 'price_edit'])->name('products.price_edit');
    Route::post('products/price-update', [ProductController::class, 'price_update'])->name('products.price_update');

    // Route::get('/approve-all-products', [ProductController::class, 'approveAllProducts'])->name('products.approveAll');

    // campaign
    Route::get('campaign/manage', [CampaignController::class, 'index'])->name('campaign.index');
    Route::get('campaign/{id}/show', [CampaignController::class, 'show'])->name('campaign.show');
    Route::get('campaign/create', [CampaignController::class, 'create'])->name('campaign.create');
    Route::post('campaign/save', [CampaignController::class, 'store'])->name('campaign.store');
    Route::get('campaign/{id}/edit', [CampaignController::class, 'edit'])->name('campaign.edit');
    Route::post('campaign/update', [CampaignController::class, 'update'])->name('campaign.update');
    Route::post('campaign/inactive', [CampaignController::class, 'inactive'])->name('campaign.inactive');
    Route::post('campaign/active', [CampaignController::class, 'active'])->name('campaign.active');
    Route::post('campaign/destroy', [CampaignController::class, 'destroy'])->name('campaign.destroy');
    Route::get('campaign/image/destroy', [CampaignController::class, 'imgdestroy'])->name('campaign.image.destroy');


    // specialoffer
    Route::get('specialoffer/manage', [SpecialOfferController::class, 'index'])->name('specialoffer.index');
    Route::get('specialoffer/{id}/show', [SpecialOfferController::class, 'show'])->name('specialoffer.show');
    Route::get('specialoffer/create', [SpecialOfferController::class, 'create'])->name('specialoffer.create');
    Route::post('specialoffer/save', [SpecialOfferController::class, 'store'])->name('specialoffer.store');
    Route::get('specialoffer/{id}/edit', [SpecialOfferController::class, 'edit'])->name('specialoffer.edit');
    Route::post('specialoffer/update', [SpecialOfferController::class, 'update'])->name('specialoffer.update');
    Route::post('specialoffer/inactive', [SpecialOfferController::class, 'inactive'])->name('specialoffer.inactive');
    Route::post('specialoffer/active', [SpecialOfferController::class, 'active'])->name('specialoffer.active');
    Route::post('specialoffer/destroy', [SpecialOfferController::class, 'destroy'])->name('specialoffer.destroy');
    Route::get('specialoffer/image/destroy', [SpecialOfferController::class, 'imgdestroy'])->name('specialoffer.image.destroy');


    // settings route
    Route::get('settings/manage', [GeneralSettingController::class, 'index'])->name('settings.index');
    Route::get('settings/create', [GeneralSettingController::class, 'create'])->name('settings.create');
    Route::post('settings/save', [GeneralSettingController::class, 'store'])->name('settings.store');
    Route::get('settings/{id}/edit', [GeneralSettingController::class, 'edit'])->name('settings.edit');
    Route::post('settings/update', [GeneralSettingController::class, 'update'])->name('settings.update');
    Route::post('settings/inactive', [GeneralSettingController::class, 'inactive'])->name('settings.inactive');
    Route::post('settings/active', [GeneralSettingController::class, 'active'])->name('settings.active');
    Route::post('settings/destroy', [GeneralSettingController::class, 'destroy'])->name('settings.destroy');

    // settings route
    Route::get('social-media/manage', [SocialMediaController::class, 'index'])->name('socialmedias.index');
    Route::get('social-media/create', [SocialMediaController::class, 'create'])->name('socialmedias.create');
    Route::post('social-media/save', [SocialMediaController::class, 'store'])->name('socialmedias.store');
    Route::get('social-media/{id}/edit', [SocialMediaController::class, 'edit'])->name('socialmedias.edit');
    Route::post('social-media/update', [SocialMediaController::class, 'update'])->name('socialmedias.update');
    Route::post('social-media/inactive', [SocialMediaController::class, 'inactive'])->name('socialmedias.inactive');
    Route::post('social-media/active', [SocialMediaController::class, 'active'])->name('socialmedias.active');
    Route::post('social-media/destroy', [SocialMediaController::class, 'destroy'])->name('socialmedias.destroy');

    // contact route
    Route::get('contact/manage', [ContactController::class, 'index'])->name('contact.index');
    Route::get('contact/create', [ContactController::class, 'create'])->name('contact.create');
    Route::post('contact/save', [ContactController::class, 'store'])->name('contact.store');
    Route::get('contact/{id}/edit', [ContactController::class, 'edit'])->name('contact.edit');
    Route::post('contact/update', [ContactController::class, 'update'])->name('contact.update');
    Route::post('contact/inactive', [ContactController::class, 'inactive'])->name('contact.inactive');
    Route::post('contact/active', [ContactController::class, 'active'])->name('contact.active');
    Route::post('contact/destroy', [ContactController::class, 'destroy'])->name('contact.destroy');

    // contact route
    Route::get('registrationcharge/manage', [RegistrationChargeController::class, 'index'])->name('registrationcharges.index');
    Route::get('registrationcharge/create', [RegistrationChargeController::class, 'create'])->name('registrationcharges.create');
    Route::post('registrationcharge/save', [RegistrationChargeController::class, 'store'])->name('registrationcharges.store');
    Route::get('registrationcharge/{id}/edit', [RegistrationChargeController::class, 'edit'])->name('registrationcharges.edit');
    Route::post('registrationcharge/update', [RegistrationChargeController::class, 'update'])->name('registrationcharges.update');
    Route::post('registrationcharge/inactive', [RegistrationChargeController::class, 'inactive'])->name('registrationcharges.inactive');
    Route::post('registrationcharge/active', [RegistrationChargeController::class, 'active'])->name('registrationcharges.active');
    Route::post('registrationcharge/destroy', [RegistrationChargeController::class, 'destroy'])->name('registrationcharges.destroy');

    // Slider routes
    Route::get('slider/manage', [SliderController::class, 'index'])->name('sliders.index');
    Route::get('slider/create', [SliderController::class, 'create'])->name('sliders.create');
    Route::post('slider/save', [SliderController::class, 'store'])->name('sliders.store');
    Route::get('slider/{id}/edit', [SliderController::class, 'edit'])->name('sliders.edit');
    Route::post('slider/update', [SliderController::class, 'update'])->name('sliders.update');
    Route::post('slider/inactive', [SliderController::class, 'inactive'])->name('sliders.inactive');
    Route::post('slider/active', [SliderController::class, 'active'])->name('sliders.active');
    Route::post('slider/destroy', [SliderController::class, 'destroy'])->name('sliders.destroy');


    // banner category route
    Route::get('banner-category/manage', [BannerCategoryController::class, 'index'])->name('banner_category.index');
    Route::get('banner-category/create', [BannerCategoryController::class, 'create'])->name('banner_category.create');
    Route::post('banner-category/save', [BannerCategoryController::class, 'store'])->name('banner_category.store');
    Route::get('banner-category/{id}/edit', [BannerCategoryController::class, 'edit'])->name('banner_category.edit');
    Route::post('banner-category/update', [BannerCategoryController::class, 'update'])->name('banner_category.update');
    Route::post('banner-category/inactive', [BannerCategoryController::class, 'inactive'])->name('banner_category.inactive');
    Route::post('banner-category/active', [BannerCategoryController::class, 'active'])->name('banner_category.active');
    Route::post('banner-category/destroy', [BannerCategoryController::class, 'destroy'])->name('banner_category.destroy');

    // banner  route
    Route::get('banner/manage', [BannerController::class, 'index'])->name('banners.index');
    Route::get('banner/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('banner/save', [BannerController::class, 'store'])->name('banners.store');
    Route::get('banner/{id}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::post('banner/update', [BannerController::class, 'update'])->name('banners.update');
    Route::post('banner/inactive', [BannerController::class, 'inactive'])->name('banners.inactive');
    Route::post('banner/active', [BannerController::class, 'active'])->name('banners.active');
    Route::post('banner/destroy', [BannerController::class, 'destroy'])->name('banners.destroy');
    

    // packaging category route
    Route::get('package-category/manage', [PackagingCategoryController::class, 'index'])->name('package_category.index');
    Route::get('package-category/create', [PackagingCategoryController::class, 'create'])->name('package_category.create');
    Route::post('package-category/save', [PackagingCategoryController::class, 'store'])->name('package_category.store');
    Route::get('package-category/{id}/edit', [PackagingCategoryController::class, 'edit'])->name('package_category.edit');
    Route::post('package-category/update', [PackagingCategoryController::class, 'update'])->name('package_category.update');
    Route::post('package-category/inactive', [PackagingCategoryController::class, 'inactive'])->name('package_category.inactive');
    Route::post('package-category/active', [PackagingCategoryController::class, 'active'])->name('package_category.active');
    Route::post('package-category/destroy', [PackagingCategoryController::class, 'destroy'])->name('package_category.destroy');

    // Packaging route
    Route::get('package/manage', [PackagingManageController::class, 'index'])->name('packages.index');
    Route::get('package/create', [PackagingManageController::class, 'create'])->name('packages.create');
    Route::post('package/save', [PackagingManageController::class, 'store'])->name('packages.store');
    Route::get('package/{id}/edit', [PackagingManageController::class, 'edit'])->name('packages.edit');
    Route::post('package/update', [PackagingManageController::class, 'update'])->name('packages.update');
    Route::post('package/inactive', [PackagingManageController::class, 'inactive'])->name('packages.inactive');
    Route::post('package/active', [PackagingManageController::class, 'active'])->name('packages.active');
    Route::post('package/destroy', [PackagingManageController::class, 'destroy'])->name('packages.destroy');// 


    //Boost route
    Route::get('boost/manage', [BoostManageController::class, 'index'])->name('boosts.index');
    Route::get('boost/create', [BoostManageController::class, 'create'])->name('boosts.create');
    Route::post('boost/save', [BoostManageController::class, 'store'])->name('boosts.store');
    Route::get('boost/{id}/edit', [BoostManageController::class, 'edit'])->name('boosts.edit');
    Route::post('boost/update', [BoostManageController::class, 'update'])->name('boosts.update');
    Route::post('boost/inactive', [BoostManageController::class, 'inactive'])->name('boosts.inactive');
    Route::post('boost/active', [BoostManageController::class, 'active'])->name('boosts.active');
    Route::post('boost/destroy', [BoostManageController::class, 'destroy'])->name('boosts.destroy');


    // register video
    Route::get('video/manage', [VideoController::class, 'index'])->name('video.index');
    Route::get('video/{id}/show', [VideoController::class, 'show'])->name('video.show');
    Route::get('video/create', [VideoController::class, 'create'])->name('video.create');
    Route::post('video/save', [VideoController::class, 'store'])->name('video.store');
    Route::get('video/{id}/edit', [VideoController::class, 'edit'])->name('video.edit');
    Route::post('video/update', [VideoController::class, 'update'])->name('video.update');
    Route::post('video/inactive', [VideoController::class, 'inactive'])->name('video.inactive');
    Route::post('video/active', [VideoController::class, 'active'])->name('video.active');
    Route::post('video/destroy', [VideoController::class, 'destroy'])->name('video.destroy');

    // video category route
    Route::get('video-category/manage', [VideoCategoryController::class, 'index'])->name('video_category.index');
    Route::get('video-category/create', [VideoCategoryController::class, 'create'])->name('video_category.create');
    Route::post('video-category/save', [VideoCategoryController::class, 'store'])->name('video_category.store');
    Route::get('video-category/{id}/edit', [VideoCategoryController::class, 'edit'])->name('video_category.edit');
    Route::post('video-category/update', [VideoCategoryController::class, 'update'])->name('video_category.update');
    Route::post('video-category/inactive', [VideoCategoryController::class, 'inactive'])->name('video_category.inactive');
    Route::post('video-category/active', [VideoCategoryController::class, 'active'])->name('video_category.active');
    Route::post('video-category/destroy', [VideoCategoryController::class, 'destroy'])->name('video_category.destroy');



    // expensecategories
    Route::get('expensecategories/manage', [ExpenseCategoriesController::class, 'index'])->name('expensecategories.index');
    Route::get('expensecategories/{id}/show', [ExpenseCategoriesController::class, 'show'])->name('expensecategories.show');
    Route::get('expensecategories/create', [ExpenseCategoriesController::class, 'create'])->name('expensecategories.create');
    Route::post('expensecategories/save', [ExpenseCategoriesController::class, 'store'])->name('expensecategories.store');
    Route::get('expensecategories/{id}/edit', [ExpenseCategoriesController::class, 'edit'])->name('expensecategories.edit');
    Route::post('expensecategories/update', [ExpenseCategoriesController::class, 'update'])->name('expensecategories.update');
    Route::post('expensecategories/inactive', [ExpenseCategoriesController::class, 'inactive'])->name('expensecategories.inactive');
    Route::post('expensecategories/active', [ExpenseCategoriesController::class, 'active'])->name('expensecategories.active');
    Route::post('expensecategories/destroy', [ExpenseCategoriesController::class, 'destroy'])->name('expensecategories.destroy');

    // expense
    Route::get('expense/manage', [ExpenseController::class, 'index'])->name('expense.index');
    Route::get('expense/{id}/show', [ExpenseController::class, 'show'])->name('expense.show');
    Route::get('expense/create', [ExpenseController::class, 'create'])->name('expense.create');
    Route::post('expense/save', [ExpenseController::class, 'store'])->name('expense.store');
    Route::get('expense/{id}/edit', [ExpenseController::class, 'edit'])->name('expense.edit');
    Route::post('expense/update', [ExpenseController::class, 'update'])->name('expense.update');
    Route::post('expense/inactive', [ExpenseController::class, 'inactive'])->name('expense.inactive');
    Route::post('expense/active', [ExpenseController::class, 'active'])->name('expense.active');
    Route::post('expense/destroy', [ExpenseController::class, 'destroy'])->name('expense.destroy');

    // freeshipping  route
    Route::get('freeshipping/manage', [FreeShippingController::class, 'index'])->name('freeshipping.index');
    Route::get('freeshipping/create', [FreeShippingController::class, 'create'])->name('freeshipping.create');
    Route::post('freeshipping/save', [FreeShippingController::class, 'store'])->name('freeshipping.store');
    Route::get('freeshipping/{id}/edit', [FreeShippingController::class, 'edit'])->name('freeshipping.edit');
    Route::post('freeshipping/update', [FreeShippingController::class, 'update'])->name('freeshipping.update');
    Route::post('freeshipping/inactive', [FreeShippingController::class, 'inactive'])->name('freeshipping.inactive');
    Route::post('freeshipping/active', [FreeShippingController::class, 'active'])->name('freeshipping.active');
    Route::post('freeshipping/destroy', [FreeShippingController::class, 'destroy'])->name('freeshipping.destroy');

    // our service route
    Route::get('service/manage', [OurServiceController::class, 'index'])->name('services.index');
    Route::get('service/create', [OurServiceController::class, 'create'])->name('services.create');
    Route::post('service/save', [OurServiceController::class, 'store'])->name('services.store');
    Route::get('service/{id}/edit', [OurServiceController::class, 'edit'])->name('services.edit');
    Route::post('service/update', [OurServiceController::class, 'update'])->name('services.update');
    Route::post('service/inactive', [OurServiceController::class, 'inactive'])->name('services.inactive');
    Route::post('service/active', [OurServiceController::class, 'active'])->name('services.active');
    Route::post('service/destroy', [OurServiceController::class, 'destroy'])->name('services.destroy');


    // contact route
    Route::get('page/manage', [CreatePageController::class, 'index'])->name('pages.index');
    Route::get('page/create', [CreatePageController::class, 'create'])->name('pages.create');
    Route::post('page/save', [CreatePageController::class, 'store'])->name('pages.store');
    Route::get('page/{id}/edit', [CreatePageController::class, 'edit'])->name('pages.edit');
    Route::post('page/update', [CreatePageController::class, 'update'])->name('pages.update');
    Route::post('page/inactive', [CreatePageController::class, 'inactive'])->name('pages.inactive');
    Route::post('page/active', [CreatePageController::class, 'active'])->name('pages.active');
    Route::post('page/destroy', [CreatePageController::class, 'destroy'])->name('pages.destroy');

    // Pos route
    Route::get('order/search', [OrderController::class, 'search'])->name('admin.livesearch');
    Route::get('order/create', [OrderController::class, 'order_create'])->name('admin.order.create');
    Route::post('order/store', [OrderController::class, 'order_store'])->name('admin.order.store');
    Route::get('order/cart-add', [OrderController::class, 'cart_add'])->name('admin.order.cart_add');
    Route::get('order/cart-content', [OrderController::class, 'cart_content'])->name('admin.order.cart_content');
    Route::get('order/cart-increment', [OrderController::class, 'cart_increment'])->name('admin.order.cart_increment');
    Route::get('order/cart-decrement', [OrderController::class, 'cart_decrement'])->name('admin.order.cart_decrement');
    Route::get('order/cart-remove', [OrderController::class, 'cart_remove'])->name('admin.order.cart_remove');
    Route::get('order/cart-product-discount', [OrderController::class, 'product_discount'])->name('admin.order.product_discount');
    Route::get('order/cart-details', [OrderController::class, 'cart_details'])->name('admin.order.cart_details');
    Route::get('order/cart-shipping', [OrderController::class, 'cart_shipping'])->name('admin.order.cart_shipping');
    Route::post('order/cart-clear', [OrderController::class, 'cart_clear'])->name('admin.order.cart_clear');

    // Order route
    Route::get('order/{slug}', [OrderController::class, 'index'])->name('admin.orders');
    Route::get('order/edit/{invoice_id}', [OrderController::class, 'order_edit'])->name('admin.order.edit');
    Route::post('order/update', [OrderController::class, 'order_update'])->name('admin.order.update');
    Route::get('order/invoice/{invoice_id}', [OrderController::class, 'invoice'])->name('admin.order.invoice');
    Route::get('order/process/{invoice_id}', [OrderController::class, 'process'])->name('admin.order.process');
    Route::post('order/change', [OrderController::class, 'order_process'])->name('admin.order_change');
    Route::post('order/destroy', [OrderController::class, 'destroy'])->name('admin.order.destroy');
    Route::get('order-assign', [OrderController::class, 'order_assign'])->name('admin.order.assign');
    Route::get('order-status', [OrderController::class, 'order_status'])->name('admin.order.status');
    Route::get('order-bulk-destroy', [OrderController::class, 'bulk_destroy'])->name('admin.order.bulk_destroy');
    Route::get('order-print', [OrderController::class, 'order_print'])->name('admin.order.order_print');
    Route::get('bulk-courier/{slug}', [OrderController::class, 'bulk_courier'])->name('admin.bulk_courier');
    Route::get('order-pathao', [OrderController::class, 'order_pathao'])->name('admin.order.pathao');
    Route::get('pathao-city', [OrderController::class, 'pathaocity'])->name('pathaocity');
    Route::get('pathao-zone', [OrderController::class, 'pathaozone'])->name('pathaozone');
    Route::get('stock-report', [OrderController::class, 'stock_report'])->name('admin.stock_report');
    Route::get('order-report', [OrderController::class, 'order_report'])->name('admin.order_report');
    Route::get('expense-report', [OrderController::class, 'expense_report'])->name('admin.expense_report');
    Route::get('reseller-cash-report', [OrderController::class, 'reseller_cash_report'])->name('admin.reseller_cash_report');
    Route::get('loss-profit', [OrderController::class, 'loss_profit'])->name('admin.loss_profit');

    // Order route
    Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('review/pending', [ReviewController::class, 'pending'])->name('reviews.pending');
    Route::post('review/inactive', [ReviewController::class, 'inactive'])->name('reviews.inactive');
    Route::post('review/active', [ReviewController::class, 'active'])->name('reviews.active');
    Route::get('review/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('review/save', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('review/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::post('review/update', [ReviewController::class, 'update'])->name('reviews.update');
    Route::post('review/destroy', [ReviewController::class, 'destroy'])->name('reviews.destroy');


    // order route
    Route::get('seller', [SellerManageController::class,'index'])->name('sellers.index');
    Route::get('seller/manage', [SellerManageController::class,'index'])->name('sellers.index');
    Route::get('seller/{id}/edit', [SellerManageController::class,'edit'])->name('sellers.edit');
    Route::post('seller/update', [SellerManageController::class,'update'])->name('sellers.update');
    Route::post('seller/inactive', [SellerManageController::class,'inactive'])->name('sellers.inactive');
    Route::post('seller/active', [SellerManageController::class,'active'])->name('sellers.active');
    Route::post('seller/adminlog', [SellerManageController::class,'adminlog'])->name('sellers.adminlog');
    Route::get('seller/profile', [SellerManageController::class,'profile'])->name('sellers.profile');
    Route::post('seller/store', [SellerManageController::class, 'store'])->name('sellers.store');
    Route::post('seller/change', [SellerManageController::class, 'change'])->name('sellers.change');
    Route::post('seller/addstore', [SellerManageController::class, 'addstore'])->name('sellers.addstore');

    Route::get('seller/withdraw', [SellerManageController::class,'withdraw'])->name('sellers.withdraw');
    Route::post('seller/withdraw-save', [SellerManageController::class,'withdraw_save'])->name('sellers.withdraw.save');

    // seller product
    Route::get('sellers/pending-product', [SellerManageController::class,'pending_product'])->name('sellers.pending_product');
    Route::get('seller/products', [SellerManageController::class,'products'])->name('sellers.products');
    Route::post('seller/product-approve', [SellerManageController::class,'product_approve'])->name('sellers.product_approve');



    Route::post('seller/product-approve', [SellerManageController::class,'product_approve'])->name('sellers.product_approve');

    Route::get('seller/products/{id}/edit', [SellerManageController::class,'procode_edit'])->name('products.procode.edit');

    Route::post('seller/products/procode/update', [SellerManageController::class,'procode_update'])->name('products.procode.update');

    // ventor withdraw route code 
    Route::get('ventorwithdraw/{status}', [VentorwithdrawController::class, 'ventorwithdraw'])->name('admin.ventorwithdraw');
    Route::post('ventorwithdraw-change', [VentorwithdrawController::class, 'ventorwithdraw_change'])->name('admin.ventorwithdraw_change');



    // flavor  route
    Route::get('shipping-charge/manage', [ShippingChargeController::class, 'index'])->name('shippingcharges.index');
    Route::get('shipping-charge/create', [ShippingChargeController::class, 'create'])->name('shippingcharges.create');
    Route::post('shipping-charge/save', [ShippingChargeController::class, 'store'])->name('shippingcharges.store');
    Route::get('shipping-charge/{id}/edit', [ShippingChargeController::class, 'edit'])->name('shippingcharges.edit');
    Route::post('shipping-charge/update', [ShippingChargeController::class, 'update'])->name('shippingcharges.update');
    Route::post('shipping-charge/inactive', [ShippingChargeController::class, 'inactive'])->name('shippingcharges.inactive');
    Route::post('shipping-charge/active', [ShippingChargeController::class, 'active'])->name('shippingcharges.active');
    Route::post('shipping-charge/destroy', [ShippingChargeController::class, 'destroy'])->name('shippingcharges.destroy');

    // district routes
    Route::get('district/manage', [DistrictController::class, 'index'])->name('districts.index');
    Route::get('district/{id}/edit', [DistrictController::class, 'edit'])->name('districts.edit');
    Route::post('district/update', [DistrictController::class, 'update'])->name('districts.update');
    Route::post('district/charge-update', [DistrictController::class, 'district_charge'])->name('districts.charge');

      // wallet code route
    Route::get('wallet/manage', [WalletController::class,'index'])->name('wallet.index');
    Route::get('wallet/history', [WalletController::class,'history'])->name('wallet.history');
    Route::post('wallet/status', [WalletController::class,'status'])->name('wallet.status');




    // backend customer route
    Route::get('customer', [CustomerManageController::class, 'index'])->name('customers.index');
    Route::get('customer/manage', [CustomerManageController::class, 'index'])->name('customers.index');
    Route::get('customer/{id}/edit', [CustomerManageController::class, 'edit'])->name('customers.edit');
    Route::post('customer/update', [CustomerManageController::class, 'update'])->name('customers.update');
    Route::post('customer/inactive', [CustomerManageController::class, 'inactive'])->name('customers.inactive');
    Route::post('customer/active', [CustomerManageController::class, 'active'])->name('customers.active');
    Route::get('customer/profile', [CustomerManageController::class, 'profile'])->name('customers.profile');
    Route::get('customer/payment', [CustomerManageController::class, 'payment'])->name('customers.payment');
    Route::get('customer/payment-show', [CustomerManageController::class, 'payment_show'])->name('customers.payment.show');
    Route::post('customer/payment-status', [CustomerManageController::class, 'payment_status'])->name('customers.payment_status');

    Route::get('polyorder/orders', [CustomerManageController::class, 'polyorders'])->name('polyorder.orders');
    Route::get('polyorder/order-details', [CustomerManageController::class, 'order_details'])->name('polyorder.order_details');
    Route::post('polyorder/poly-status', [CustomerManageController::class, 'poly_status'])->name('polyorder.poly_status');

    Route::get('boostorder/orders', [CustomerManageController::class, 'boostorders'])->name('boostorder.orders');
    Route::get('boostorder/boost-details', [CustomerManageController::class, 'boost_details'])->name('boostorder.boost_details');
    Route::post('boostorder/boost-status', [CustomerManageController::class, 'boost_status'])->name('boostorder.boost_status');

    Route::post('customer/storecus', [CustomerManageController::class, 'storecus'])->name('customers.storecus');
    Route::post('customer/changecus', [CustomerManageController::class, 'changecus'])->name('customers.changecus');
    Route::post('customer/addstorecus', [CustomerManageController::class, 'addstorecus'])->name('customers.addstorecus');







    Route::post('customer/adminlog', [CustomerManageController::class, 'adminlog'])->name('customers.adminlog');
    Route::get('customer/ip-block', [CustomerManageController::class, 'ip_block'])->name('customers.ip_block');
    Route::post('customer/ip-store', [CustomerManageController::class, 'ipblock_store'])->name('customers.ipblock.store');
    Route::post('customer/ip-update', [CustomerManageController::class, 'ipblock_update'])->name('customers.ipblock.update');
    Route::post('customer/ip-destroy', [CustomerManageController::class, 'ipblock_destroy'])->name('customers.ipblock.destroy');

    Route::get('withdraw/{status}', [CustomerManageController::class, 'withdraw'])->name('admin.withdraw');
    Route::post('withdraw-change', [CustomerManageController::class, 'withdraw_change'])->name('admin.withdraw_change');
    Route::get('slip/{invoice_id}', [CustomerManageController::class, 'slip'])->name('admin.slip');



    // // backend wholeseller customer
    // Route::get('reseller/manage', [WholeSellerManageController::class, 'index'])->name('wholesellercustomers.index');
    // Route::get('whole-seller/manage', [WholeSellerManageController::class, 'wholesellers'])->name('wholesellers.index');
    // Route::get('reseller/request', [WholeSellerManageController::class, 'request'])->name('wholesellercustomers.request');
    // Route::get('reseller/show', [WholeSellerManageController::class, 'show'])->name('wholesellercustomers.show');
    // Route::post('reseller/inactive', [WholeSellerManageController::class, 'inactive'])->name('wholesellercustomers.inactive');
    // Route::post('reseller/active', [WholeSellerManageController::class, 'active'])->name('wholesellercustomers.active');
    // Route::get('reseller/profile', [WholeSellerManageController::class, 'profile'])->name('wholesellercustomers.profile');


    // Route::post('reseller/status-manage', [WholeSellerManageController::class, 'status_change'])->name('wholesellercustomers.status_manage');




});
