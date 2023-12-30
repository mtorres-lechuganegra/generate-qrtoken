<?php

namespace App\Exceptions;

use Exception;

class UserException extends Exception
{
    public static function userNotFound(): self
    {
        return new self('User not found', 404);
    }

    public static function userAlreadyExists(): self
    {
        return new self('User already exists', 409);
    }

    public static function emailAlreadyTaken(): self
    {
        return new self('Email already taken', 409);
    }
}
