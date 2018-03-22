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

Route::get('/analyze', 'AnalysesController@index')->name('analyze');
Route::post('/analyze', 'AnalysesController@analyze')->name('analysis');
Route::post('/analyze/{name}', 'AnalysesController@analyze')->name('analysis.name');
Route::get('/analysis/{id}/{name}', 'AnalysesController@getAnalysis')->name('analysis.view');
Route::get('/analysis/save/{id}', 'UserController@linkAnalysis')->name('analysis.save');

Route::get('/compare', 'CompareController@index')->name('compare');
Route::post('/compare', 'CompareController@compare')->name('compare');
Route::get('/compare/{first}/{second}/{third?}/{fourth?}', 'CompareController@getCompare')->name('compare.view');

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


