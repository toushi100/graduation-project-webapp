<?php

use Illuminate\Support\Facades\Route;
use Iman\Streamer\VideoStreamer;

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
    return view('index');
});

Route::get('/videos/{id}', 'VideoController@search')->name('search');
Route::get('/renderVideo/{id}', 'VideoController@renderVideo')->name('renderVideo');
Route::get('/videos/showannotated/{id}', 'VideoController@renderAnnotated')->name('renderAnnotated');



Route::post('/videos/{id}', 'VideoController@search')->name('search');
Route::resource('videos','VideoController');
Route::resource('upload', 'UploadController');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

