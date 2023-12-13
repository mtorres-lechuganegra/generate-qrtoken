<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignItemToUserRequest;
use App\Models\UserItem;
use App\Services\UserItemService;
use Illuminate\Http\Request;

class UserItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignItemToUserRequest $request)
    {
        $userItem = (new UserItemService())->create(
            $request->user_dni,
            $request->entity_sku,
            $request->entity_type
        );

        if (!$userItem) {
            return response()->json([
                'message' => 'Could not assign item to user',
            ], 400);
        }

        return response()->json([
            'message' => 'User item created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserItem $userItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserItem $userItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserItem $userItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserItem $userItem)
    {
        //
    }
}
