<?php

use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
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
Route::post('/tokens/assign', [TokenController::class, 'assignTokenToUser']);

Route::post('/qr/{token}', function (Request $request, $token) {
    $token = Token::query()->where('value', $token)->firstOrFail();

    $user = $token->user()->firstOrFail();

    $user->tokens()->attach($token);

    return response()->json([
        'message' => 'QR scanned',
    ]);
});
