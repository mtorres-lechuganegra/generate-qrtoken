<?php

namespace App\Exceptions;

use Exception;

class UserItemException extends Exception
{
    public static function userNotFound(): self
    {
        return new self('User not found', 404);
    }

    public static function entityAlreadyAssignedToUser(): self
    {
        return new self('Entity already assigned to user', 409);
    }
}
