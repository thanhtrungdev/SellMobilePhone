<?php

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'HomeController@index')->name('homepage'); //trang chu

Route::get('/phone/{brand_name}', 'BrandController@listProductOfBrand')->name('list-product-of-brand'); //danh sach dien thoai cua tung hang
Route::get('/accessories', 'CategoryController@listAccessories')->name('list-accessories'); // danh sach cac phu kien

Route::get('/product/{id}', 'ProductController@show')->name('product-detail'); // xem thong tin cua 1 san pham

Route::get('/search', 'SearchController@searchProduct')->name('search'); // tim kiem san pham

Route::get('/cart', 'CartController@index')->name('view-cart'); // xem gio hang
Route::get('/add-to-cart/{product_id}', 'CartController@addProductToCart')->name('add-product-to-cart'); // them san pham vao gio hang
Route::get('/remove-from-cart/{product_id}', 'CartController@removeProductFromCart')->name('remove-product-from-cart');// xoa san pham khoi gio hang
//Route::delete('/remove-from-cart/{product_id}', 'CartController@removeProductFromCart')->name('remove-product-from-cart');// xoa san pham khoi gio hang
Route::get('/update-cart', 'CartController@updateCart')->name('update-cart'); // cap nhat gio hang
Route::get('/delete-cart', 'CartController@deleteCart')->name('delete-cart'); // cap nhat gio hang
//Route::put('/update-cart', 'CartController@updateCart')->name('update-cart'); // cap nhat gio hang
Route::get('/checkout', 'CartController@checkout')->name('checkout'); // gui don dat hang

Route::post('/feedback', 'FeedbackController@sendFeedback')->name('feedback'); //gui email gop y

Route::get('/list-order', 'OrderController@listOrderOfUser')->name('order-history'); //lich su dat hang

Route::get('/sign-up', 'UserController@create')->name('form-register'); // goi form dang ky
Route::post('/sign-up', 'UserController@store')->name('create-user'); // tao nguoi dung moi
Route::get('/sign-in', 'UserController@userSignIn')->name('form-login'); // goi form dang nhap
Route::post('/user', 'UserController@signIn')->name('sign-in'); // dang nhap vao tai khoan
Route::get('/user/{id}', 'UserController@show')->name('view-profile'); // xem profile
Route::get('/user/{id}/edit', 'UserController@edit')->name('edit-profile'); // goi form chinh sua profile
Route::put('/user/{id}', 'UserController@update')->name('update-profile'); // cap nhat profile
Route::get('/user/{id}/order', 'UserController@listOrder')->name('list-order'); // danh sach cac don hang
Route::get('/user/{id}/order/{order_id}', 'UserController@listOrder')->name('list-order'); // xem chi tiet don hang
Route::post('/user/{id}/logout', 'UserController@logout')->name('logout'); // thoat khoi tai khoan

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
