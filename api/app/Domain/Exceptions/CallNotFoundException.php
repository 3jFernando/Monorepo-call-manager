<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use DomainException;

class CallNotFoundException extends DomainException
{
    public static function withoutId(string $callId): self
    {
        return new self("No hay registros con el ID: {$callId}");
    }
}
