<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
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
//进入登录页
Route::get('/dev', [UserController::class, 'index']);
//登录提交接口
Route::post('/login', [UserController::class, 'login']);
//登录验证
Route::middleware('login_auth')->group(function () {
    //展示sql日志页面
    Route::get('/page', [LogController::class, 'page']);
    //提交sql验证接口
    Route::post('/addSql', [LogController::class, 'submitSql']);
    //导出，复用接口导出 excel & json
    Route::get('/exportSql', [LogController::class, 'exportSql']);
});

//心跳检测
Route::get('/health', function () {
    return time();
});
