<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = (new UserService)->store($request->validated());

        return response()->json([
            'user' => $user->only(['dni', 'name', 'email']),
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        $user = (new UserService)->update($request->validated());

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return $user->only(['dni', 'name', 'email']);
    }
}
