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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/incentive-configurator', 'HomeController@incentive_configurator')->name('incentive-configurator');
Route::get('/process', 'HomeController@process')->name('process');
Route::get('/report', 'HomeController@report')->name('report');
