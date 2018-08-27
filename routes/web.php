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




Route::get('/auth/redirect', 'AuthController@redirect');

Route::get('/auth/callback', 'AuthController@callback');

Route::get('/{page}', 'VueController')->where('page', '^(api.+|(?!api).*)$');
use Illuminate\Http\Request;
