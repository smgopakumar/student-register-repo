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
//
//Route::get('/', function () {return view('welcome');});
Route::get('/', 'SettingsController@index');


Route::get('/register',function () {return view('student.register');});
Route::post('/student/register', 'SettingsController@studentRegister');


Route::get('/register/update/page', 'SettingsController@studentRegisterUpdatePage');
Route::post('/student/register/update', 'SettingsController@studentRegisterUpdate');

Route::get('/student/changeStatus', 'SettingsController@changeStatus');

Route::get('/login', function () {return view('login');});
Route::post('/login', 'SettingsController@setLogin');
Route::get('/logout', 'SettingsController@logOut');
