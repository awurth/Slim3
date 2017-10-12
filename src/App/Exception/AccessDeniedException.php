<?php

namespace App\Exception;

use Exception;
use Throwable;

class AccessDeniedException extends Exception
{
    public function __construct($message = 'Access denied', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
