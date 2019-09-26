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

Route::get('/', "ExcelFileController@index");

Route::get("/create", "ExcelFileController@create")->name("create");
Route::post("/store", "ExcelFileController@store");

Route::post("/update", "ExcelFileController@update");
Route::get("/edit/{key}", "ExcelFileController@edit");

Route::post("/convert", "ExcelFileController@convertToPDFAndSave");
Route::post("/convert/download", "ExcelFileController@convertToPDFAndDownload");