<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('getCategories', 'CategoriesController@index');
Route::post('storeCategory', 'CategoriesController@store');
Route::post('updateCategory/{id}', 'CategoriesController@update');
Route::get('showCategory/{id}', 'CategoriesController@show');
Route::post('deleteCategory/{id}', 'CategoriesController@destroy');

Route::get('getOrders', 'OrdersController@index');
Route::post('storeOrder', 'OrdersController@store');
Route::post('updateOrder/{id}', 'OrdersController@update');
Route::get('showOrder/{id}', 'OrdersController@show');
Route::post('deleteOrder/{id}', 'OrdersController@destroy');

Route::get('getProducts', 'ProductsController@index');
Route::post('storeProduct', 'ProductsController@store');
Route::post('updateProduct/{id}', 'ProductsController@update');
Route::get('showProduct/{id}', 'ProductsController@show');
Route::post('deleteProduct/{id}', 'ProductsController@destroy');

Route::get('getRoles', 'RolesController@index');
Route::post('storeRole', 'RolesController@store');
Route::post('updateRole/{id}', 'RolesController@update');
Route::get('showRole/{id}', 'RolesController@show');
Route::post('deleteRole/{id}', 'RolesController@destroy');

Route::post('signup', 'UsersController@signup');
Route::post('signin', 'UsersController@signin');

Route::any('{path?}', 'MainController@index')->where("path", ".+");
