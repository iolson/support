<?php

namespace IanOlson\Tests\Exceptions;

use Illuminate\Support\Arr;
use IanOlson\Support\Exceptions\ValidateException;
use IanOlson\Support\Tests\TestCase;

class ValidateExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function message()
    {
        $this->setExpectedException(ValidateException::class, 'Testing');

        throw new ValidateException("Testing");
    }

    /**
     * @test
     */
    public function messageNull()
    {
        $this->setExpectedException(ValidateException::class);

        throw new ValidateException();
    }

    /**
     * @test
     */
    public function errors()
    {
        try {
            throw new ValidateException('Testing', ['errors' => true]);
        } catch (ValidateException $e) {
            $errors = $e->getErrors();
        }

        $this->assertNotEmpty($errors);
        $this->assertArrayHasKey('errors', $errors);
        $this->assertTrue(Arr::get($errors, 'errors'));
    }

    /**
     * @test
     */
    public function errorsEmpty()
    {
        try {
            throw new ValidateException('Testing');
        } catch (ValidateException $e) {
            $errors = $e->getErrors();
        }

        $this->assertEmpty($errors);
    }
}