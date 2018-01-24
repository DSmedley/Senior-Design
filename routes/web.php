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

Route::get('/', 'PagesController@getHome')->name('welcome');
Route::get('/about', 'PagesController@getAbout')->name('about');
Route::get('/contact', 'PagesController@getContact')->name('contact');

Route::get('/messages', 'MessagesController@getMessages')->name('messages');

Route::post('/contact/submit', 'MessagesController@submit');

Auth::routes();

Route::prefix('user')->group(function(){
    Route::get('/', 'UserController@index')->name('user');
    Route::get('/edit', 'UserController@edit')->name('user.edit');
    Route::post('/edit', 'UserController@updateProfile');
    Route::get('/inbox', 'UserController@inbox')->name('user.inbox');
});

Route::prefix('admin')->group(function(){
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/settings', 'AdminController@settings')->name('admin.settings');
    Route::post('/settings', 'AdminController@updateSettings');
    Route::get('/users', 'AdminController@users')->name('admin.users');
    Route::get('/users/{id}', 'AdminController@getUser')->name('admin.user.edit');
    Route::post('/users/{id}', 'AdminController@updateUser')->name('admin.user.edit');
    Route::get('/users/ban/{id}', 'AdminController@banUser')->name('admin.user.ban');
    Route::get('/users/unban/{id}', 'AdminController@unbanUser')->name('admin.user.unban');

});

