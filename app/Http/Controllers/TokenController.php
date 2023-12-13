<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTokenRequest;
use App\Http\Requests\AssignTokenToUserRequest;
use App\Http\Requests\ValidateQrRequest;
use App\Models\Token;
use App\Services\TokenService;

class TokenController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTokenRequest $request)
    {
        $token = (new TokenService())->store(
            $request->entity_type,
            $request->entity_id
        );

        if (!$token) {
            return response()->json([
                'message' => 'Could not create token',
            ], 400);
        }

        return response()->json([
            'token' => $token,
        ]);
    }

    /**
     * Assign a token to a user.
     */
    public function assignTokenToUser(AssignTokenToUserRequest $request)
    {
        $tokenAssigned = (new TokenService())->assignTokenToUser($request->get('user_dni'), $request->get('token'));

        if (!$tokenAssigned) {
            return response()->json([
                'message' => 'Could not assign token',
            ], 409);
        }

        return response()->json([
            'message' => 'Token assigned',
        ]);
    }

    public function qr(ValidateQrRequest $request)
    {
        $token = Token::query()->where('value', $request->get('token'))->firstOrFail();

        return view('qr', [
            'token' => $token,
        ]);
    }
}
