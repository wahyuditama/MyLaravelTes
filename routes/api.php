<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bookcontroller;
use App\http\Controllers\MemberController;
use App\Http\Controllers\RentedController;

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

Route::get('/book', [Bookcontroller::class, 'index']);
Route::apiResource('book', Bookcontroller::class);
Route::put('/book', [Bookcontroller::class, 'update']);

Route::get('/member', [MemberController::class, 'index']);
Route::post('/member', [MemberController::class, 'store']);
Route::get('/member/{id}', [MemberController::class, 'show']);
Route::put('/member/{id}', [MemberController::class, 'update']);
Route::delete('/member/{id}', [MemberController::class, 'destroy']);

Route::get('/sewa', [RentedController::class, 'index']);
Route::post('/sewa', [RentedController::class, 'store']);
Route::put('/sewa/{id}', [RentedController::class, 'update']);
Route::delete('/sewa/{id}', [RentedController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
