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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'auth'], function () {

    Route::get('user/getUser', 'UserController@getUser')->name('user.getUser');
    Route::post ( '/editUser', 'UserController@editUser' );
    Route::post ( '/deleteUser', 'UserController@deleteUser' );
    Route::resource('user', 'UserController');
    Route::group(['middleware' => ['role:Administrador']], function () {
        Route::post ( 'user/create', 'UserController@store' );
        Route::get ( 'user/create', 'UserController@create' );

    });
 //   Route::resource('user', 'UserController');

});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
