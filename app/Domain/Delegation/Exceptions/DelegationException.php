<?php

namespace App\Domain\Delegation\Exceptions;

use Exception;

class DelegationException extends Exception
{
    public static function workerAlreadyDelegated(): static
    {
        return new static('Pracownik jest w tym czasie na innej delegacji');
    }

    public static function invalidConfig(): static
    {
        return new static('Nieprawidłowa konfiguracja delegacji');
    }
}
