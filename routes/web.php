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
Route::get('log-aggregated', 'LogAggregatedController@index')->name('log-aggregated.index');
Route::get('log-aggregated2', 'LogAggregatedController@index2')->name('log-aggregated2.index2');
