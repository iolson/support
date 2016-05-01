<?php

namespace IanOlson\Tests\Exceptions;

use IanOlson\Support\Exceptions\InvalidVariableTypeException;
use IanOlson\Support\Tests\TestCase;

class InvalidVariableTypeExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function message()
    {
        $this->setExpectedException(InvalidVariableTypeException::class, 'Testing');

        throw new InvalidVariableTypeException("Testing");
    }

    /**
     * @test
     */
    public function messageNull()
    {
        $this->setExpectedException(InvalidVariableTypeException::class);

        throw new InvalidVariableTypeException();
    }
}