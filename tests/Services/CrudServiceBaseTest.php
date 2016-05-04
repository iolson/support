<?php

namespace IanOlson\Support\Tests\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Mockery as m;
use IanOlson\Support\Exceptions\BaseModelException;
use IanOlson\Support\Exceptions\ValidateException;
use IanOlson\Support\Services\CrudServiceBase;
use IanOlson\Support\Tests\TestCase;

class CrudServiceBaseTest extends TestCase
{
    /**
     * @test
     */
    public function constructor()
    {
        $mockModel = m::mock('Model');
        $mockService = new TestRepo($mockModel);

        $this->assertEquals($mockModel, $mockService->getModel());
    }

    /**
     * @test
     */
    public function index()
    {
        $mockService = m::mock(CrudServiceBase::class)->makePartial();
        $mockModel = m::mock('Model');
        $mockModel1 = m::mock('Model2');
        $mockModel2 = m::mock('Model3');
        $mockCollection = new Collection([$mockModel1, $mockModel2]);

        $mockService->shouldReceive('createModel')->andReturn($mockModel);
        $mockModel->shouldReceive('newQuery')->andReturn($mockModel);
        $mockModel->shouldReceive('get')->andReturn($mockCollection);

        $this->assertEquals($mockCollection, $mockService->index());
        $this->assertNotTrue($mockService->index()->isEmpty());
        $this->assertEquals($mockModel1, $mockService->index()->first());
        $this->assertEquals($mockModel2, $mockService->index()->last());
    }

    /**
     * @test
     */
    public function index_EmptyCollection()
    {
        $mockService = m::mock(CrudServiceBase::class)->makePartial();
        $mockModel = m::mock('Model');
        $mockCollection = new Collection();

        $mockService->shouldReceive('createModel')->andReturn($mockModel);
        $mockModel->shouldReceive('newQuery')->andReturn($mockModel);
        $mockModel->shouldReceive('get')->andReturn($mockCollection);

        $this->assertEquals($mockCollection, $mockService->index());
        $this->assertTrue($mockService->index()->isEmpty());
    }

    /**
     * @test
     */
    public function find()
    {
        $mockService = m::mock(CrudServiceBase::class)->makePartial();
        $mockModel = m::mock('Model');

        $mockService->shouldReceive('read')->once()->andReturn($mockModel);

        $this->assertEquals($mockModel, $mockService->read(1));
    }

    /**
     * @test
     */
    public function find_Null()
    {
        $mockService = m::mock(CrudServiceBase::class)->makePartial();

        $mockService->shouldReceive('read')->once()->andReturnNull();

        $this->assertNull($mockService->read(1));
    }

    /**
     * @test
     */
    public function create()
    {
        $mockService = m::mock(CrudServiceBase::class)->makePartial();
        $mockModel = m::mock('Model');
        $name = 'Hello';

        Validator::shouldReceive('make')->once()->andReturn(m::mock(['fails' => false]));
        $mockService->shouldReceive('createModel')->once()->andReturn($mockModel);
        $mockModel->shouldReceive('getFillable')->once()->andReturn(['name']);
        $mockModel->shouldReceive('save')->once()->andReturn($mockModel);

        $mockService->addValidationOption('rules', 'name', 'required');

        $this->assertEquals($mockModel, $mockService->create(compact('name')));
    }

    /**
     * @test
     */
    public function create_ValidateException()
    {
        $this->setExpectedException(ValidateException::class, 'Error');

        $mockService = m::mock(CrudServiceBase::class)->makePartial();
        $name = null;

        Validator::shouldReceive('make')->once()->andReturn(m::mock(['fails' => 'true']));
        Lang::shouldReceive('get')->once()->andReturn('Error');

        $mockService->addValidationOption('rules', 'name', 'required');
        $mockService->create(compact('name'));
    }

    /**
     * @test
     */
    public function update()
    {
        $mockService = m::mock(CrudServiceBase::class)->makePartial();
        $mockModel = m::mock('Model');
        $name = 'Hello';

        Validator::shouldReceive('make')->once()->andReturn(m::mock(['fails' => false]));
        $mockService->shouldReceive('createModel')->once()->andReturn($mockModel);
        $mockModel->shouldReceive('newQuery')->once()->andReturn($mockModel);
        $mockModel->shouldReceive('where')->once()->andReturn($mockModel);
        $mockModel->shouldReceive('first')->once()->andReturn($mockModel);
        $mockModel->shouldReceive('getFillable')->once()->andReturn(['name']);
        $mockModel->shouldReceive('save')->once()->andReturn($mockModel);

        $mockService->addValidationOption('rules', 'name', 'required');

        $this->assertEquals($mockModel, $mockService->update(1, compact('name')));
    }

    /**
     * @test
     */
    public function update_ModelException()
    {
        $this->setExpectedException(BaseModelException::class, 'Model could not be found.');

        $mockService = m::mock(CrudServiceBase::class)->makePartial();

        Lang::shouldReceive('get')->once()->andReturn('Model could not be found.');
        $mockService->shouldReceive('read')->once()->andReturnNull();
        $mockService->shouldReceive('throwException')->once()->andThrow(new BaseModelException(Lang::get('support.exceptions.model.read')));

        $mockService->update(1, []);
    }

    /**
     * @test
     */
    public function update_ValidateException()
    {
        $this->setExpectedException(ValidateException::class, 'Error');

        $mockService = m::mock(CrudServiceBase::class)->makePartial();
        $mockModel = m::mock('Model');
        $name = null;

        Validator::shouldReceive('make')->once()->andReturn(m::mock(['fails' => 'true']));
        Lang::shouldReceive('get')->once()->andReturn('Error');
        $mockService->shouldReceive('read')->once()->andReturn($mockModel);

        $mockService->addValidationOption('rules', 'name', 'required');
        $mockService->update(1, compact('name'));
    }

    /**
     * @test
     */
    public function delete()
    {
        $mockService = m::mock(CrudServiceBase::class)->makePartial();
        $mockModel = m::mock('Model');

        $mockService->shouldReceive('read')->once()->andReturn($mockModel);
        $mockModel->shouldReceive('delete')->once()->andReturn(true);

        $this->assertTrue($mockService->delete(1));
    }

    /**
     * @test
     */
    public function delete_ModelException()
    {
        $this->setExpectedException(BaseModelException::class, 'Model could not be found.');

        $mockService = m::mock(CrudServiceBase::class)->makePartial();

        Lang::shouldReceive('get')->once()->andReturn('Model could not be found.');
        $mockService->shouldReceive('read')->once()->andReturnNull();
        $mockService->shouldReceive('throwException')->once()->andThrow(new BaseModelException(Lang::get('support.exceptions.model.read')));

        $mockService->delete(1);
    }
}

class TestRepo extends CrudServiceBase
{
    // Used for testing init.
}