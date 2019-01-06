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

//Home
Route::get('/', 'basicController@viewHome');

//Temperature Route
Route::post('/temp/save', 'TemperatureController@save_temp')->name('saveTemp');
Route::get('/temp/delete/{id}', 'TemperatureController@delete_temp');
Route::get('/temp/past', 'TemperatureController@view_temp_past_init');
Route::post('/temp/past', 'TemperatureController@view_temp_past')->name('searchTemp');
Route::get('/temp', 'TemperatureController@viewHome');

//Expenses Route

