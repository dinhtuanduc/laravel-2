<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', "Frontend\HomepageController@index");

Route::get('/backend','Backend\DashboardController@index')->middleware('backendauth');

//Products
Route::get('/backend/product/index','Backend\ProductsController@index')->middleware('backendauth');
Route::get('/backend/product/create','Backend\ProductsController@create')->middleware('backendauth');
Route::get('/backend/product/edit/{id}','Backend\ProductsController@edit')->middleware('backendauth');
Route::get('/backend/product/delete/{id}','Backend\ProductsController@delete')->middleware('backendauth');
//Lưu sản phẩm
Route::post('/backend/product/store','Backend\ProductsController@store')->middleware('backendauth');
//Cập nhật sản phẩm
Route::post('/backend/product/update/{id}','Backend\ProductsController@update')->middleware('backendauth');
//Xóa sản phẩm
Route::post('/backend/product/destroy/{id}','Backend\ProductsController@destroy')->middleware('backendauth');

//Category
Route::get('/backend/category/index','Backend\CategoryController@index')->middleware('backendauth');
Route::get('/backend/category/create','Backend\CategoryController@create')->middleware('backendauth');
//Lưu danh mục
Route::post('/backend/category/store','Backend\CategoryController@store')->middleware('backendauth');
Route::get('/backend/category/edit/{id}','Backend\CategoryController@edit')->middleware('backendauth');
//Sửa danh mục
Route::post('/backend/category/update/{id}','Backend\CategoryController@update')->middleware('backendauth');
Route::get('/backend/category/delete/{id}','Backend\CategoryController@delete')->middleware('backendauth');

//Order - Đơn hàng
Route::get('backend/order/index','Backend\OrderController@index')->middleware('backendauth');
Route::get('backend/order/create','Backend\OrderController@create')->middleware('backendauth');
Route::post('backend/order/store','Backend\OrderController@store')->middleware('backendauth');
Route::get('backend/order/edit/{id}','Backend\OrderController@edit')->middleware('backendauth');
Route::post('backend/order/update/{id}','Backend\OrderController@update')->middleware('backendauth');
Route::get('backend/order/delete/{id}','Backend\OrderController@delete')->middleware('backendauth');

//Setting - Cài đặt
Route::get('/backend/settings','Backend\SettingsController@edit')->middleware('backendauth');
Route::post('/backend/settings/update','Backend\SettingsController@update')->middleware('backendauth');

//Admin - Quản trị người dùng
Route::get('backend/admin/index','Backend\AdminController@index')->middleware('backendauth');
Route::get('backend/admin/create','Backend\AdminController@create')->middleware('backendauth');
Route::post('backend/admin/store','Backend\AdminController@store')->middleware('backendauth');
Route::get('backend/admin/edit/{id}','Backend\AdminController@edit')->middleware('backendauth');
Route::post('backend/admin/update/{id}','Backend\AdminController@update')->middleware('backendauth');
Route::get('backend/admin/delete/{id}','Backend\AdminController@delete')->middleware('backendauth');

//Admin - Login
Route::get('/backend/admin-login','Backend\AdminLoginController@loginview');
Route::post('/backend/admin-login','Backend\AdminLoginController@loginpost');
Route::get('/backend/admin-logout','Backend\AdminLoginController@logout')->middleware('backendauth');
