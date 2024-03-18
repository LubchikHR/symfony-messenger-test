<?php

declare(strict_types=1);

namespace App\Gateway\Exception;

class ProviderResponseException extends \Exception
{
    public static function exception(string $bankClass): self
    {
        return new static(sprintf('Something happened with bank provider: %s', $bankClass));
    }
}
