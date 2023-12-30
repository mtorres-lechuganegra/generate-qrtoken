<?php

namespace App\Exceptions;

use Exception;

class TokenException extends Exception
{
    public static function entityAlreadyHasToken(): self
    {
        return new self('Entity already has a token', 409);
    }
}
