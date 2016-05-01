<?php

namespace IanOlson\Support\Tests\Traits;

use Mockery as m;
use IanOlson\Support\Exceptions\BaseModelException;
use IanOlson\Support\Tests\TestCase;
use IanOlson\Support\Traits\ServiceTrait;

class ServiceTraitTest extends TestCase
{
    /**
     * @test
     */
    public function createModelSuccess()
    {
        $mockService = m::mock(ServiceStub::class)->makePartial();

        $mockService->setModel(ServiceModelStub::class);

        $this->assertEquals(ServiceModelStub::class, get_class($mockService->createModel()));
    }

    /**
     * @test
     */
    public function getModelSuccess()
    {
        $mockService = m::mock(ServiceStub::class)->makePartial();

        $mockService->setModel(ServiceModelStub::class);

        $this->assertEquals(ServiceModelStub::class, $mockService->getModel());
    }

    /**
     * @test
     */
    public function getModelCallDynamicFunction()
    {
        $mockService = m::mock(ServiceStub::class)->makePartial();

        $mockService->setModel(ServiceModelStub::class);

        $this->assertTrue($mockService->createModel()->test());
    }

    /**
     * @test
     */
    public function setModelSuccess()
    {
        $mockService = m::mock(ServiceStub::class)->makePartial();

        $mockService->setModel(ServiceModelStub::class);

        $this->assertEquals(ServiceModelStub::class, $mockService->getModel());
    }

    /**
     * @test
     */
    public function throwExceptionSuccess()
    {
        $this->setExpectedException(BaseModelException::class, 'Testing');

        $mockService = m::mock(ServiceStub::class)->makePartial();

        $mockService->setException(BaseModelException::class);

        $mockService->throwException('Testing');
    }
}

class ServiceStub
{
    use ServiceTrait;
}

class ServiceModelStub
{
    public function test()
    {
        return true;
    }
}