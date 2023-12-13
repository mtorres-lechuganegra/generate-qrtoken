<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserItemController;
use App\Models\Token;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tokens', [TokenController::class, 'store']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users', [UserController::class, 'update']);
Route::get('/users/dni/{dni}', [UserController::class, 'showByDni'])->where('dni', '[0-9]{8,8}');
Route::get('/users/dni/{dni}/items', [UserController::class, 'getItems'])->where('dni', '[0-9]{8,8}');
Route::post('/tokens/assign', [TokenController::class, 'assignTokenToUser']);
Route::post('/items/assign', [UserItemController::class, 'store']);

Route::apiResources([
    'products' => ProductController::class,
    'services' => ServiceController::class,
]);
