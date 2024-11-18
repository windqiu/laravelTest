<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
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

Route::get('/dev', [UserController::class, 'index']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('login')->group(function () {
    Route::get('/page', [LogController::class, 'page']);
    Route::post('/addSql', [LogController::class, 'submitSql']);
});
