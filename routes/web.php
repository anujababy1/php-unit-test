<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/books', 'App\Http\Controllers\BookController@store');
Route::patch('/books/{book}', 'App\Http\Controllers\BookController@update');
Route::delete('/books/{book}', 'App\Http\Controllers\BookController@destroy');

Route::post('/authors', 'App\Http\Controllers\AuthorController@store');
