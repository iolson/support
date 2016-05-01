<?php

namespace IanOlson\Support\Exceptions;

use Exception;

class BaseModelException extends Exception
{
    /**
     * Construct.
     *
     * @param string $message
     */
    public function __construct($message = '')
    {
        parent::__construct($message);
    }
}
