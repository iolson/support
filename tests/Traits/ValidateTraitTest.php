<?php

namespace IanOlson\Support\Tests\Traits;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Mockery as m;
use IanOlson\Support\Exceptions\ValidateException;
use IanOlson\Support\Tests\TestCase;
use IanOlson\Support\Traits\ValidateTrait;

class ValidateTraitTest extends TestCase
{
    /**
     * @test
     */
    public function addValidationOptionInvalid()
    {
        $this->setExpectedException(ValidateException::class, 'Error');

        $mockClass = m::mock(ValidateStub::class)->makePartial();

        Lang::shouldReceive('get')->once()->andReturn('Error');

        $mockClass->addValidationOption('omgwtfbbq', 'testing', 'testing_value');
    }

    /**
     * @test
     */
    public function removeValidationOptionInvalid()
    {
        $this->setExpectedException(ValidateException::class, 'Error');

        $mockClass = m::mock(ValidateStub::class)->makePartial();

        Lang::shouldReceive('get')->once()->andReturn('Error');

        $mockClass->removeValidationOption('omgwtfbbq', 'testing', 'testing_value');
    }

    /**
     * @test
     */
    public function addValidationOptionMessage()
    {
        $mockClass = m::mock(ValidateStub::class)->makePartial();

        $mockClass->addValidationOption('messages', 'testing', 'testing_value');

        $this->assertNotEmpty($mockClass->getValidationOptions('messages'));
        $this->assertNotNull($mockClass->getValidationOptions('messages'));
        $this->assertArrayHasKey('testing', $mockClass->getValidationOptions('messages'));
    }

    /**
     * @test
     */
    public function removeValidationOptionMessage()
    {
        $mockClass = m::mock(ValidateStub::class)->makePartial();

        $mockClass->addValidationOption('messages', 'testing', 'testing_value');
        $this->assertArrayHasKey('testing', $mockClass->getValidationOptions('messages'));

        $mockClass->removeValidationOption('messages', 'testing');
        $this->assertArrayNotHasKey('testing', $mockClass->getValidationOptions('messages'));
        $this->assertEmpty($mockClass->getValidationOptions('messages'));
    }

    /**
     * @test
     */
    public function addValidationOptionRule()
    {
        $mockClass = m::mock(ValidateStub::class)->makePartial();

        $mockClass->addValidationOption('rules', 'testing', 'testing_value');

        $this->assertNotEmpty($mockClass->getValidationOptions('rules'));
        $this->assertNotNull($mockClass->getValidationOptions('rules'));
        $this->assertArrayHasKey('testing', $mockClass->getValidationOptions('rules'));
    }

    /**
     * @test
     */
    public function removeValidationOptionRule()
    {
        $mockClass = m::mock(ValidateStub::class)->makePartial();

        $mockClass->addValidationOption('rules', 'testing', 'testing_value');
        $this->assertArrayHasKey('testing', $mockClass->getValidationOptions('rules'));

        $mockClass->removeValidationOption('rules', 'testing');
        $this->assertArrayNotHasKey('testing', $mockClass->getValidationOptions('rules'));
        $this->assertEmpty($mockClass->getValidationOptions('rules'));
    }

    /**
     * @test
     */
    public function validate()
    {
        $mockClass = m::mock(ValidateStub::class)->makePartial();
        $data = ['name' => 'Testing'];

        Validator::shouldReceive('make')->once()->andReturn(m::mock(['fails' => false]));
        $mockClass->addValidationOption('rules', 'name', 'required');

        $this->assertTrue($mockClass->validate($data));
    }

    /**
     * @test
     */
    public function validateFail()
    {
        $this->setExpectedException(ValidateException::class, 'Error');

        $mockClass = m::mock(ValidateStub::class)->makePartial();
        $data = ['name' => 'Testing'];

        Validator::shouldReceive('make')->once()->andReturn(m::mock(['fails' => true]));
        Lang::shouldReceive('get')->once()->andReturn('Error');

        $mockClass->validate($data);
    }

    /**
     * @test
     */
    public function validateCustomMessage()
    {
        $mockClass = m::mock(ValidateStub::class)->makePartial();
        $customMessage = 'This has failed.';
        $data = ['name' => 'Testing'];

        $this->setExpectedException(ValidateException::class, $customMessage);

        Validator::shouldReceive('make')->once()->andReturn(m::mock(['fails' => true]));
        Lang::shouldReceive('get')->once()->andReturn('Error');

        $mockClass->validate($data, $customMessage);
    }

    /**
     * @test
     */
    public function getValidationOptionsInvalid()
    {
        $this->setExpectedException(ValidateException::class, 'Error');

        $mockClass = m::mock(ValidateStub::class)->makePartial();

        Lang::shouldReceive('get')->once()->andReturn('Error');

        $mockClass->getValidationOptions('omgwtfbbq');
    }
}

class ValidateStub
{
    use ValidateTrait;
}