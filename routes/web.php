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


Route::group(['prefix' => 'account', 'middleware' => ['auth']], function () {
    Route::post('create', 'Finances\AccountController@create')->name('account.create');
    Route::post('close', 'Finances\AccountController@close')->name('account.close');
    Route::post('transaction', 'Finances\AccountController@transaction')->name('account.transaction');
});
