<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('zip-codes/{code}', "Api\ZipCodesController@index")->where('code', '[0-9]+');
Route::get('load/{number}', "Api\ZipCodesController@load")->where('number', '[0-9]+');