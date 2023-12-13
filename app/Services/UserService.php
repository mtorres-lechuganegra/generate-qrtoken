<?php

namespace App\Services;

use App\Models\User;

final class UserService
{
    public function show(string $userDni): ?User
    {
        $user = User::where('dni', $userDni)->first();

        return $user;
    }

    public function store($data): User
    {
        $user = new User();
        $user->fill($data);

        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        $user->has_filled_profile = $this->userHasFilledProfile($user);

        $user->save();

        return $user;
    }

    public function update(array $data): ?User
    {
        $user = User::where('dni', $data['dni'])->first();

        if (!$user) {
            return null;
        }

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->fill($data);

        $user->has_filled_profile = $this->userHasFilledProfile($user);

        $user->save();

        return $user;
    }

    public function userHasFilledProfile(User $user): bool
    {
        if (
            !empty($user->first_name)
            && !empty($user->last_name)
            && !empty($user->email)
            && !empty($user->phone)
            // && !empty($user->email_verified_at)
            && !empty($user->password)
        ) {
            return true;
        }

        return false;
    }
}
