<?php

namespace Faiznurullah\Gemini\Exceptions;

use Exception;

class GeminiException extends Exception
{
    protected $context;

    public function __construct($message, $code = 0, Exception $previous = null, array $context = [])
    {
        parent::__construct($message, (int) $code, $previous);
        $this->context = $context;
    }

    public function getContext()
    {
        return $this->context;
    }
}
