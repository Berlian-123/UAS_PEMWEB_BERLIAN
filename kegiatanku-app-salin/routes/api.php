<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// ✅ Route menggunakan string untuk controller method
Route::get('kegiatans', 'ApiKegiatanController@index');
Route::get('kegiatans/{id}', 'ApiKegiatanController@show');
Route::post('kegiatans', 'ApiKegiatanController@store');
Route::put('kegiatans/{id}', 'ApiKegiatanController@update');
Route::delete('kegiatans/{id}', 'ApiKegiatanController@destroy');
