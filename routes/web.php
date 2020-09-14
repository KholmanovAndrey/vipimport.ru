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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/contacts', 'ContactController@view')->name('contact.view');
Route::resource('/contact', 'ContactController');

Route::get('/category/view/{category}', 'CategoryController@view')->name('category.view');
Route::resource('/category', 'CategoryController');

Route::get('/article/view/{category}', 'ArticleController@view')->name('article.view');
Route::resource('/article', 'ArticleController');

Route::resource('/profile', 'ProfileController');
Route::resource('/address', 'AddressController')->except('show');
Route::resource('/country', 'CountryController')->except('show');
Route::resource('/city', 'CityController')->except('show');

