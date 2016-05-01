<?php

namespace IanOlson\Support\Tests\Traits;

use Illuminate\Database\Eloquent\Model;
use Mockery as m;
use IanOlson\Support\Tests\TestCase;
use IanOlson\Support\Traits\UpdateTrait;
use ReflectionMethod;

class UpdateTraitTest extends TestCase
{
    /**
     * @test
     */
    public function addNonRequiredAttributeSuccess()
    {
        $mockClass = m::mock(UpdateStub::class)->makePartial();

        $mockClass->addNonRequiredAttribute('testing');

        $this->assertNotEmpty($mockClass->getNonRequiredAttributes());
        $this->assertNotNull($mockClass->getNonRequiredAttributes());
        $this->assertArrayHasKey('testing', $mockClass->getNonRequiredAttributes());
    }

    /**
     * @test
     */
    public function removeNonRequiredAttributeSuccess()
    {
        $mockClass = m::mock(UpdateStub::class)->makePartial();

        $mockClass->addNonRequiredAttribute('testing');
        $this->assertArrayHasKey('testing', $mockClass->getNonRequiredAttributes());

        $mockClass->removeNonRequiredAttribute('testing');
        $this->assertArrayNotHasKey('testing', $mockClass->getNonRequiredAttributes());
        $this->assertEmpty($mockClass->getNonRequiredAttributes());
    }

    /**
     * @test
     */
    public function getNonRequiredAttributesEmpty()
    {
        $mockClass = m::mock(UpdateStub::class)->makePartial();

        $this->assertEmpty($mockClass->getNonRequiredAttributes());

    }

    /**
     * @test
     */
    public function updateAttributesSuccess()
    {
        $name = 'Testing';
        $email = 'testing@gmail.com';
        $mockClass = m::mock(UpdateStub::class)->makePartial();
        $mockData = compact('name', 'email');

        $method = new ReflectionMethod(UpdateStub::class, 'updateAttributes');
        $method->setAccessible(true);
        $mockClass->shouldReceive('getFillable')->once()->andReturn(['name', 'email']);

        $method->invokeArgs($mockClass, [&$mockClass, &$mockData]);

        $this->assertEquals($name, $mockClass->name);
        $this->assertEquals($email, $mockClass->email);
    }

    /**
     * @test
     */
    public function updateAttributesWithPasswordSuccess()
    {
        $name = 'Testing';
        $password = 'password';
        $mockClass = m::mock(UpdateStub::class)->makePartial();
        $mockData = compact('name', 'password');

        $method = new ReflectionMethod(UpdateStub::class, 'updateAttributes');
        $method->setAccessible(true);
        $mockClass->shouldReceive('getFillable')->once()->andReturn(['name', 'password']);

        $method->invokeArgs($mockClass, [&$mockClass, &$mockData]);

        $this->assertEquals($name, $mockClass->name);
        $this->assertNotNull($mockClass->password);
    }

    /**
     * @test
     */
    public function updateAttributesWithNonMassAssignableSuccess()
    {
        $name = 'Testing';
        $mockClass = m::mock(UpdateStub::class)->makePartial();
        $mockData = compact('name');

        $method = new ReflectionMethod(UpdateStub::class, 'updateAttributes');
        $method->setAccessible(true);
        $mockClass->shouldReceive('getFillable')->once()->andReturn([]);

        $method->invokeArgs($mockClass, [&$mockClass, &$mockData]);

        $this->assertNull($mockClass->name);
    }

    /**
     * @test
     */
    public function updateAttributesEmptyData()
    {
        $mockClass = m::mock(UpdateStub::class)->makePartial();
        $mockData = [];

        $method = new ReflectionMethod(UpdateStub::class, 'updateAttributes');
        $method->setAccessible(true);

        $method->invokeArgs($mockClass, [&$mockClass, &$mockData]);

        $this->assertNull($mockClass->name);
    }

    /**
     * @test
     */
    public function updateAttributesWithNullValue()
    {
        $name = null;
        $mockClass = m::mock(UpdateStub::class)->makePartial();
        $mockData = compact('name');

        $method = new ReflectionMethod(UpdateStub::class, 'updateAttributes');
        $method->setAccessible(true);
        $mockClass->shouldReceive('getFillable')->once()->andReturn(['name']);

        $method->invokeArgs($mockClass, [&$mockClass, &$mockData]);

        $this->assertNull($mockClass->name);
    }

    /**
     * @test
     */
    public function updateAttributesWithNullValueOnExistingData()
    {
        $existingName = 'Testing';
        $name = null;
        $mockClass = m::mock(UpdateStub::class)->makePartial();
        $mockExistingData = ['name' => $existingName];
        $mockData = compact('name');

        $method = new ReflectionMethod(UpdateStub::class, 'updateAttributes');
        $method->setAccessible(true);
        $mockClass->shouldReceive('getFillable')->twice()->andReturn(['name']);

        $method->invokeArgs($mockClass, [&$mockClass, &$mockExistingData]);
        $method->invokeArgs($mockClass, [&$mockClass, &$mockData]);

        $this->assertNotNull($mockClass->name);
        $this->assertEquals($existingName, $mockClass->name);
    }

    /**
     * @test
     */
    public function updateAttributesWithNullValueNonRequiredAttribute()
    {
        $existingName = 'Testing';
        $name = null;
        $mockClass = m::mock(UpdateStub::class)->makePartial();
        $mockExistingData = ['name' => $existingName];
        $mockData = compact('name');

        $method = new ReflectionMethod(UpdateStub::class, 'updateAttributes');
        $method->setAccessible(true);
        $mockClass->shouldReceive('getFillable')->twice()->andReturn(['name']);

        $mockClass->addNonRequiredAttribute('name');
        $method->invokeArgs($mockClass, [&$mockClass, &$mockExistingData]);
        $method->invokeArgs($mockClass, [&$mockClass, &$mockData]);

        $this->assertNull($mockClass->name);
        $this->assertNotEquals($existingName, $mockClass->name);
    }
}

class UpdateStub extends Model
{
    use UpdateTrait;
}