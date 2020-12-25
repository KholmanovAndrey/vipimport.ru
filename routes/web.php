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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/contacts', 'ContactController@view')->name('contact.view');
Route::resource('/contact', 'ContactController');

Route::get('/category/view/{category}', 'CategoryController@view')->name('category.view');
Route::resource('/category', 'CategoryController');

Route::get('/article/view/{article}', 'ArticleController@view')->name('article.view');
Route::resource('/article', 'ArticleController');

Route::resource('/profile', 'ProfileController')->except('view');
Route::middleware('role:client')->resource('/address', 'AddressController');
Route::resource('/country', 'CountryController')->except('show');
Route::resource('/city', 'CityController')->except('show');
Route::middleware('role:client')->resource('/order', 'OrderController');
Route::middleware('role:client')->resource('/parcel', 'ParcelController');
Route::resource('/support', 'SupportController');
Route::resource('/message', 'MessageController');
Route::resource('/subscribe', 'SubscribeController')->only('store');

Route::group([
    'prefix' => 'manager',
    'as' => 'manager.',
    'middleware' => 'role:manager'
], function() {
    // пользователи
    Route::resource('/user', 'UserController')->only(['show']);
    // заказы клиентов
    Route::get('/order/new', 'OrderController@new')->name('order.new');
    Route::get('/order/my', 'OrderController@my')->name('order.my');
    Route::get('/order/{order}', 'OrderController@show')->name('order.show');
    Route::put('/order/{order}/accept', 'OrderController@accept')->name('order.accept');
    Route::put('/order/{order}/status', 'OrderController@status')->name('order.status');
    Route::put('/order/{order}/transfer', 'OrderController@transfer')->name('order.transfer');
    // посылки клиентов
    Route::get('/parcel/new', 'ParcelController@new')->name('parcel.new');
    Route::get('/parcel/my', 'ParcelController@my')->name('parcel.my');
    Route::get('/parcel/{parcel}', 'ParcelController@show')->name('parcel.show');
    Route::put('/parcel/{parcel}/accept', 'ParcelController@accept')->name('parcel.accept');
    Route::put('/parcel/{parcel}/status', 'ParcelController@status')->name('parcel.status');
    Route::put('/parcel/{parcel}/transfer', 'ParcelController@transfer')->name('parcel.transfer');


    Route::get('/', 'Roles\ManagerController@index')->name('index');
    Route::get('/parcel-new', 'Roles\ManagerController@parcelNew')->name('parcel-new');
    Route::get('/parcel-my', 'Roles\ManagerController@parcelMy')->name('parcel-my');
    Route::put('/parcel-accept/{parcel}', 'Roles\ManagerController@parcelAccept')->name('parcel-accept');
    Route::get('/parcel-show/{parcel}', 'Roles\ManagerController@parcelShow')->name('parcel-show');
    Route::put('/parcel-status/{parcel}', 'Roles\ManagerController@parcelStatus')->name('parcel-status');
    Route::put('/parcel-transfer/{parcel}', 'Roles\ManagerController@parcelTransfer')->name('parcel-transfer');
    Route::get('/support-new', 'Roles\ManagerController@supportNew')->name('support-new');
    Route::get('/support-my', 'Roles\ManagerController@supportMy')->name('support-my');
    Route::get('/support-view/{support}', 'Roles\ManagerController@supportView')->name('support-view');
    Route::put('/support-accept/{support}', 'Roles\ManagerController@supportAccept')->name('support-accept');
    Route::get('/client-view/{client}', 'Roles\ManagerController@clientView')->name('client-view');
    Route::get('/statistic', 'Roles\ManagerController@statistic')->name('statistic');
    Route::get('/user-statistic/{user}', 'Roles\ManagerController@userStatistic')->name('user-statistic');
});

Route::group([
    'prefix' => 'client',
    'as' => 'client.',
    'namespace' => 'Roles'
], function() {
    Route::get('/', 'ClientController@index')->name('index');
    Route::put('/order-add-parcel-id/{parcel}', 'ClientController@orderAddParcelID')->name('order-add-parcel-id');
    Route::put('/order-delete-parcel-id/{order}', 'ClientController@orderDeleteParcelID')->name('order-delete-parcel-id');
    Route::put('/parcel-send-to-packaging/{parcel}', 'ClientController@parcelSendToPackaging')->name('parcel-send-to-packaging');

    Route::post('/support', 'ClientController@supportStore')->name('support-store');
    Route::get('/support', 'ClientController@supportAll')->name('support-all');
    Route::get('/support/create', 'ClientController@supportCreate')->name('support-create');
    Route::get('/support/{support}', 'ClientController@supportView')->name('support-view');

    Route::post('/message/{support}', 'ClientController@messageStore')->name('message-store');
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Roles'
], function() {
    Route::get('/', 'AdminController@index')->name('index');
});

Route::group([
    'prefix' => 'superAdmin',
    'as' => 'superAdmin.',
    'middleware' => 'role:superAdmin'
], function() {
    // пользователи
    Route::resource('/user', 'UserController');
    Route::get('/user/{user}/role', 'UserController@role')->name('user.role');
    Route::put('/user/{user}/role/update', 'UserController@roleUpdate')->name('user.role.update');
    // адреса клиентов
    Route::resource('/address', 'AddressController');
    // заказы клиентов
    Route::resource('/order', 'OrderController');
    // посылки клиентов
    Route::resource('/parcel', 'ParcelController');



    Route::get('/', 'Roles\SuperAdminController@index')->name('index');
    Route::get('/user-view', 'Roles\SuperAdminController@userView')->name('user-view');
    Route::get('/user-statistic/{user}', 'Roles\SuperAdminController@userStatistic')->name('user-statistic');
//    Route::delete('/user-delete/{user}', 'SuperAdminController@userDelete')->name('user-delete');
    Route::get('/statistic', 'Roles\SuperAdminController@statistic')->name('statistic');
    Route::get('/user-parcel/{user}', 'Roles\SuperAdminController@userParcel')->name('user-parcel');
});