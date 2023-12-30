<?php

namespace App\Services;

use App\Exceptions\UserException;
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
            if (User::where('email', $data['email'])->exists()) {
                throw UserException::emailAlreadyTaken();
            }

            $user->password = bcrypt($data['password']);
        }

        if (User::where('dni', $data['dni'])->exists()) {
            throw UserException::userAlreadyExists();
        }

        $user->has_filled_profile = $this->userHasFilledProfile($user);

        $user->save();

        return $user;
    }

    public function update(array $data): User
    {
        $user = User::where('dni', $data['dni'])->first();

        if (!$user) {
            throw UserException::userNotFound();
        }

        $emailAlreadyTaken = User::where('email', $data['email'])->where('dni', '!=', $data['dni'])->exists();

        if ($emailAlreadyTaken) {
            throw UserException::emailAlreadyTaken();
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
        return !empty($user->first_name)
            && !empty($user->last_name)
            && !empty($user->email)
            && !empty($user->phone)
            && !empty($user->password);
    }
}
