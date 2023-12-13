<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\UserItem;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
     /**
     * Display the specified resource.
     */
    public function showByDni(string $dni)
    {
        $user = (new UserService)->show($dni);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return $user->only(['dni', 'first_name', 'last_name', 'email', 'has_filled_profile']);
    }

   /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = (new UserService)->store($request->validated());

        return response()->json([
            'user' => $user->only(['dni', 'first_name', 'last_name', 'email', 'has_filled_profile']),
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

        return $user->only(['dni', 'first_name', 'last_name', 'email', 'has_filled_profile']);
    }

    public function getItems(string $dni)
    {
        $user = (new UserService)->show($dni);

        $userEntities = $user->userItems()->with('entity')->paginate();

        $userEntities = $userEntities->getCollection()->map(function ($userEntity) {
            return array_merge(
                $userEntity->entity->toArray(),
                ['entity_type' => $userEntity->entity_type]);
        });

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return $userEntities;
    }
}
