<?php

namespace Application\Core;

use Exception;
use Throwable;

class ApplicationException extends Exception
{
    protected string $userMessage;

    public function __construct(
        string $userMessage,
        string $internalMessage = "",
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($internalMessage, $code, $previous);
        $this->userMessage = $userMessage;
    }

    public function getUserMessage(): string
    {
        return $this->userMessage;
    }
}
