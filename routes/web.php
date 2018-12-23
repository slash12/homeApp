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

Route::get('/', 'basicController@viewHome');
Route::post('/temp/save', 'basicController@save_temp')->name('saveTemp');
Route::get('/temp/delete/{id}', 'basicController@delete_temp');
Route::get('/temp/past', 'basicController@view_temp_past_init');

