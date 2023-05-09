<?php

use Illuminate\Support\Facades\Route;

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
    return view('layouts.app');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/submit' , [App\Http\Controllers\Controller::class, 'submit']);
Route::post('/submitProcess' , [App\Http\Controllers\Controller::class, 'submitprocess']);
Route::get('/overview' , [App\Http\Controllers\Controller::class, 'overview']);
Route::get('/leaderboard', [App\Http\Controllers\Controller::class, 'leaderboard']);
Route::get('/leaderboardActive', [App\Http\Controllers\Controller::class, 'LeaderboardActive']);
