<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
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

// Route::get('/', function (Request $request) {
//     return $request->user();
// });

Route::get('/', [HomeController::class, 'home']);
Route::get('/news/{route}', [NewsController::class, 'vue']);
Route::post('/login', [AdminController::class, 'login']);
