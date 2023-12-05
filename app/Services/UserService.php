<?php

namespace App\Services;

use App\Models\User;

final class UserService
{
    public function store($data): User
    {
        $user = User::create($data);

        return $user;
    }

    public function update(array $data): ?User
    {
        $user = User::where('dni', $data['dni'])->first();

        if (!$user) {
            return null;
        }

        $user->update($data);

        return $user;
    }
}
