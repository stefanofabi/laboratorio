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


Route::group(['middleware' => ['auth']], function () {
		require('patients.php');
		require('prescribers.php');
		require('determinations.php');
		require('protocols.php');

});

Route::group(['middleware' => ['web']], function () {

	Route::get('lang/{lang}', function ($lang) {
		session(['lang' => $lang]);

		return \Redirect::back();
	})->where([
		'lang' => 'en|es'
	]);

});


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');