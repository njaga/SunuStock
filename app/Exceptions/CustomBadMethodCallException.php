<?php

namespace App\Exceptions;

use BadMethodCallException;

class CustomBadMethodCallException extends BadMethodCallException
{
    public function __construct($message = 'Custom Bad Method Call Exception', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
