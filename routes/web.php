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

Route::get('/', 'DashboardController@index');

Auth::routes();

Route::get('/luwiad', 'HomeController@index')->name('home');
//create Home Banner
Route::get('/homebanner','HomebannerController@index')->name('homebanner');
Route::get('/getbannerdata','HomebannerController@getBasicData')->name('getbannerdata');
Route::get('/homebanner/create','HomebannerController@create')->name('homebannercreate');
Route::post('/homebanner/create','HomebannerController@store')->name('homebannersave');
Route::get('/homebanner/{id}/edit','HomebannerController@edit')->name('homebanneredit');
Route::post('/homebanner/{id}/update','HomebannerController@update')->name('homebannerupdate');
Route::post('/homebanner/{id}/delete','HomebannerController@destroy')->name('homebannerdelete');
//create Wahana
Route::get('/wahana','WahanaController@index')->name('wahana');
Route::get('/getwahanadata','WahanaController@getBasicData')->name('getwahanadata');
Route::get('/wahana/create','WahanaController@create')->name('wahanacreate');
Route::post('/wahana/create','WahanaController@store')->name('wahanasave');
Route::get('/wahana/{id}/edit','WahanaController@edit')->name('wahanaedit');
Route::post('/wahana/{id}/update','WahanaController@update')->name('wahanaupdate');
Route::post('/wahana/{id}/delete','WahanaController@destroy')->name('wahanadelete');