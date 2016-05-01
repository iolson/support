<?php

namespace IanOlson\Tests\Exceptions;

use IanOlson\Support\Exceptions\BaseModelException;
use IanOlson\Support\Tests\TestCase;

class BaseModelExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function message()
    {
        $this->setExpectedException(BaseModelException::class, 'Testing');

        throw new BaseModelException("Testing");
    }

    /**
     * @test
     */
    public function messageNull()
    {
        $this->setExpectedException(BaseModelException::class);

        throw new BaseModelException();
    }
}