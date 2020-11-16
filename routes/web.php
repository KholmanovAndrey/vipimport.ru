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
Route::resource('/address', 'AddressController')->except('show');
Route::resource('/country', 'CountryController')->except('show');
Route::resource('/city', 'CityController')->except('show');
Route::resource('/order', 'OrderController');
Route::resource('/parcel', 'ParcelController');
Route::resource('/support', 'SupportController');
Route::resource('/message', 'MessageController');
Route::resource('/subscribe', 'SubscribeController')->only('store');

Route::group([
    'prefix' => 'manager',
    'as' => 'manager.',
    'namespace' => 'Roles'
], function() {
    Route::get('/', 'ManagerController@index')->name('index');
    Route::get('/order-new', 'ManagerController@orderNew')->name('order-new');
    Route::get('/order-my', 'ManagerController@orderMy')->name('order-my');
    Route::put('/order-accept/{order}', 'ManagerController@orderAccept')->name('order-accept');
    Route::get('/order-show/{order}', 'ManagerController@orderShow')->name('order-show');
    Route::put('/order-status/{order}', 'ManagerController@orderStatus')->name('order-status');
    Route::put('/order-transfer/{order}', 'ManagerController@orderTransfer')->name('order-transfer');
    Route::get('/parcel-new', 'ManagerController@parcelNew')->name('parcel-new');
    Route::get('/parcel-my', 'ManagerController@parcelMy')->name('parcel-my');
    Route::put('/parcel-accept/{parcel}', 'ManagerController@parcelAccept')->name('parcel-accept');
    Route::get('/parcel-show/{parcel}', 'ManagerController@parcelShow')->name('parcel-show');
    Route::put('/parcel-status/{parcel}', 'ManagerController@parcelStatus')->name('parcel-status');
    Route::put('/parcel-transfer/{parcel}', 'ManagerController@parcelTransfer')->name('parcel-transfer');
    Route::get('/support-new', 'ManagerController@supportNew')->name('support-new');
    Route::get('/support-my', 'ManagerController@supportMy')->name('support-my');
    Route::get('/support-view/{support}', 'ManagerController@supportView')->name('support-view');
    Route::put('/support-accept/{support}', 'ManagerController@supportAccept')->name('support-accept');
    Route::get('/client-view/{client}', 'ManagerController@clientView')->name('client-view');
    Route::get('/statistic', 'ManagerController@statistic')->name('statistic');
    Route::get('/user-statistic/{user}', 'ManagerController@userStatistic')->name('user-statistic');
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
    'namespace' => 'Roles'
], function() {
    Route::get('/', 'SuperAdminController@index')->name('index');
    Route::get('/user-view', 'SuperAdminController@userView')->name('user-view');
    Route::get('/user-statistic/{user}', 'SuperAdminController@userStatistic')->name('user-statistic');
//    Route::delete('/user-delete/{user}', 'SuperAdminController@userDelete')->name('user-delete');
    Route::get('/user-role/{user}', 'SuperAdminController@userRole')->name('user-role');
    Route::put('/user-role-update/{user}', 'SuperAdminController@userRoleUpdate')->name('user-role-update');
    Route::get('/statistic', 'SuperAdminController@statistic')->name('statistic');
});