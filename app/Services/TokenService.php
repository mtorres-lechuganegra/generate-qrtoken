<?php

namespace App\Services;

use App\Models\Token;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Str;
use Throwable;

final class TokenService
{
    public function store(): string
    {
        $token = self::generateToken();

        Token::create([
            'value' => $token,
        ]);

        return $token;
    }

    public function assignTokenToUser($userDni, $token): bool
    {
        $token = Token::where('value', $token)->first();

        if (!$token) {
            return false;
        }

        $user = User::query()->firstOrCreate(['dni' => $userDni]);

        $userToken = UserToken::query()
            ->where('user_id', $user->id)
            ->where('token_id', $token->id)
            ->first();

        if ($userToken) {
            return false;
        }

        try {
            UserToken::create([
                'user_id' => $user->id,
                'token_id' => $token->id,
            ]);
            return true;
        } catch (UniqueConstraintViolationException $th) {
            return false;
        } catch (Throwable $th) {
            report($th);
            return false;
        }
    }

    private static function generateToken(): string
    {
        return 'LN' . strtolower(Str::random(Token::TOKEN_LENGTH - 2));
    }
}
