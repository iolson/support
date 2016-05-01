<?php

namespace IanOlson\Support\Exceptions;

use Exception;

class ValidateException extends Exception
{
    /**
     * Errors.
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Construct.
     *
     * @param string $message
     * @param array $errors
     */
    public function __construct($message = '', $errors = [])
    {
        $this->errors = $errors;
        parent::__construct($message);
    }

    /**
     * Return errors from validator.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
