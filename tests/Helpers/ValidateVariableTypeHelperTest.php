<?php

namespace IanOlson\Support\Tests\Helpers;

use IanOlson\Support\Exceptions\InvalidVariableTypeException;
use IanOlson\Support\Helpers\ValidateVariableTypeHelper;
use IanOlson\Support\Tests\TestCase;

class ValidateVariableTypeHelpeTest extends TestCase
{
    /**
     * @test
     */
    public function isArrayTrue()
    {
        $test = [];

        $this->assertNotFalse(ValidateVariableTypeHelper::isArray($test, 'test'));
        $this->assertTrue(ValidateVariableTypeHelper::isArray($test, 'test'));
    }

    /**
     * @test
     */
    public function isArrayException()
    {
        $this->setExpectedException(InvalidVariableTypeException::class, 'The test variable is not an array.');

        $test = 'testing';

        ValidateVariableTypeHelper::isArray($test, 'test');
    }

    /**
     * @test
     */
    public function isArrayFalse()
    {
        $test = 'testing';

        $this->assertFalse(ValidateVariableTypeHelper::isArray($test, 'test', false));
        $this->assertNotTrue(ValidateVariableTypeHelper::isArray($test, 'test', false));
    }

    /**
     * @test
     */
    public function isBoolTrue()
    {
        $test = true;

        $this->assertNotFalse(ValidateVariableTypeHelper::isBool($test, 'test'));
        $this->assertTrue(ValidateVariableTypeHelper::isBool($test, 'test'));
    }

    /**
     * @test
     */
    public function isBoolException()
    {
        $this->setExpectedException(InvalidVariableTypeException::class, 'The test variable is not a bool.');

        $test = 'testing';

        ValidateVariableTypeHelper::isBool($test, 'test');
    }

    /**
     * @test
     */
    public function isBoolFalse()
    {
        $test = 'testing';

        $this->assertFalse(ValidateVariableTypeHelper::isBool($test, 'test', false));
        $this->assertNotTrue(ValidateVariableTypeHelper::isBool($test, 'test', false));
    }

    /**
     * @test
     */
    public function isIntTrue()
    {
        $test = 1;

        $this->assertNotFalse(ValidateVariableTypeHelper::isInt($test, 'test'));
        $this->assertTrue(ValidateVariableTypeHelper::isInt($test, 'test'));
    }

    /**
     * @test
     */
    public function isIntException()
    {
        $this->setExpectedException(InvalidVariableTypeException::class, 'The test variable is not an int.');

        $test = 'testing';

        ValidateVariableTypeHelper::isInt($test, 'test');
    }

    /**
     * @test
     */
    public function isIntFalse()
    {
        $test = 'testing';

        $this->assertFalse(ValidateVariableTypeHelper::isInt($test, 'test', false));
        $this->assertNotTrue(ValidateVariableTypeHelper::isInt($test, 'test', false));
    }

    /**
     * @test
     */
    public function isNumericTrue()
    {
        $test = '1';

        $this->assertNotFalse(ValidateVariableTypeHelper::isNumeric($test, 'test'));
        $this->assertTrue(ValidateVariableTypeHelper::isNumeric($test, 'test'));
    }

    /**
     * @test
     */
    public function isNumericException()
    {
        $this->setExpectedException(InvalidVariableTypeException::class, 'The test variable is not numeric.');

        $test = 'testing';

        ValidateVariableTypeHelper::isNumeric($test, 'test');
    }

    /**
     * @test
     */
    public function isNumericFalse()
    {
        $test = 'testing';

        $this->assertFalse(ValidateVariableTypeHelper::isNumeric($test, 'test', false));
        $this->assertNotTrue(ValidateVariableTypeHelper::isNumeric($test, 'test', false));
    }

    /**
     * @test
     */
    public function isStringTrue()
    {
        $test = 'testing';

        $this->assertNotFalse(ValidateVariableTypeHelper::isString($test, 'test'));
        $this->assertTrue(ValidateVariableTypeHelper::isString($test, 'test'));
    }

    /**
     * @test
     */
    public function isStringException()
    {
        $this->setExpectedException(InvalidVariableTypeException::class, 'The test variable is not a string.');

        $test = false;

        ValidateVariableTypeHelper::isString($test, 'test');
    }

    /**
     * @test
     */
    public function isStringFalse()
    {
        $test = false;

        $this->assertFalse(ValidateVariableTypeHelper::isString($test, 'test', false));
        $this->assertNotTrue(ValidateVariableTypeHelper::isString($test, 'test', false));
    }
}