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
    //return view('welcome');
    return redirect(route('login'));
});
//Route::get('/', 'UserController@index')->name('users');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'UserController@index')->name('users');
Route::get('/users/create', 'UserController@create')->name('users.create');
Route::get('/users/edit/{id}', 'UserController@edit')->name('users.edit');
Route::post('/users/update/{id}', 'UserController@update')->name('users.update');
Route::post('users/store', 'UserController@store')->name('users.store');
Route::get('users/destroy/{id}', 'UserController@destroy')->name('users.destroy');
