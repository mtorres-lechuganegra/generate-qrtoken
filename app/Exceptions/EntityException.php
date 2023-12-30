<?php

namespace App\Exceptions;

use Exception;

class EntityException extends Exception
{
    public static function entityNotFound(): self
    {
        return new self('Entity not found', 404);
    }

    public static function invalidEntity(string $entityType): self
    {
        return new self("Invalid entity $entityType", 400);
    }
}
