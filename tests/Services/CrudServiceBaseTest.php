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
        $mockRepo = new TestRepo($mockModel);

        $this->assertEquals($mockModel, $mockRepo->getModel());
    }

    /**
     * @test
     */
    public function index()
    {
        $mockRepo = m::mock(CrudServiceBase::class)->makePartial();
        $mockModel = m::mock('Model');
        $mockModel1 = m::mock('Model2');
        $mockModel2 = m::mock('Model3');
        $mockCollection = new Collection([$mockModel1, $mockModel2]);

        $mockRepo->shouldReceive('createModel')->andReturn($mockModel);
        $mockModel->shouldReceive('newQuery')->andReturn($mockModel);
        $mockModel->shouldReceive('get')->andReturn($mockCollection);

        $this->assertEquals($mockCollection, $mockRepo->index());
        $this->assertNotTrue($mockRepo->index()->isEmpty());
        $this->assertEquals($mockModel1, $mockRepo->index()->first());
        $this->assertEquals($mockModel2, $mockRepo->index()->last());
    }

    /**
     * @test
     */
    public function index_EmptyCollection()
    {
        $mockRepo = m::mock(CrudServiceBase::class)->makePartial();
        $mockModel = m::mock('Model');
        $mockCollection = new Collection();

        $mockRepo->shouldReceive('createModel')->andReturn($mockModel);
        $mockModel->shouldReceive('newQuery')->andReturn($mockModel);
        $mockModel->shouldReceive('get')->andReturn($mockCollection);

        $this->assertEquals($mockCollection, $mockRepo->index());
        $this->assertTrue($mockRepo->index()->isEmpty());
    }

    /**
     * @test
     */
    public function find()
    {
        $mockRepo = m::mock(CrudServiceBase::class)->makePartial();
        $mockModel = m::mock('Model');

        $mockRepo->shouldReceive('find')->once()->andReturn($mockModel);

        $this->assertEquals($mockModel, $mockRepo->find(1));
    }

    /**
     * @test
     */
    public function find_Null()
    {
        $mockRepo = m::mock(CrudServiceBase::class)->makePartial();

        $mockRepo->shouldReceive('find')->once()->andReturnNull();

        $this->assertNull($mockRepo->find(1));
    }

    /**
     * @test
     */
    public function create()
    {
        $mockRepo = m::mock(CrudServiceBase::class)->makePartial();
        $mockModel = m::mock('Model');
        $name = 'Hello';

        Validator::shouldReceive('make')->once()->andReturn(m::mock(['fails' => false]));
        $mockRepo->shouldReceive('createModel')->once()->andReturn($mockModel);
        $mockModel->shouldReceive('getFillable')->once()->andReturn(['name']);
        $mockModel->shouldReceive('save')->once()->andReturn($mockModel);

        $mockRepo->addValidationOption('rules', 'name', 'required');

        $this->assertEquals($mockModel, $mockRepo->create(compact('name')));
    }

    /**
     * @test
     */
    public function create_ValidateException()
    {
        $this->setExpectedException(ValidateException::class, 'Error');

        $mockRepo = m::mock(CrudServiceBase::class)->makePartial();
        $name = null;

        Validator::shouldReceive('make')->once()->andReturn(m::mock(['fails' => 'true']));
        Lang::shouldReceive('get')->once()->andReturn('Error');

        $mockRepo->addValidationOption('rules', 'name', 'required');
        $mockRepo->create(compact('name'));
    }

    /**
     * @test
     */
    public function update()
    {
        $mockRepo = m::mock(CrudServiceBase::class)->makePartial();
        $mockModel = m::mock('Model');
        $name = 'Hello';

        Validator::shouldReceive('make')->once()->andReturn(m::mock(['fails' => false]));
        $mockRepo->shouldReceive('createModel')->once()->andReturn($mockModel);
        $mockModel->shouldReceive('newQuery')->once()->andReturn($mockModel);
        $mockModel->shouldReceive('where')->once()->andReturn($mockModel);
        $mockModel->shouldReceive('first')->once()->andReturn($mockModel);
        $mockModel->shouldReceive('getFillable')->once()->andReturn(['name']);
        $mockModel->shouldReceive('save')->once()->andReturn($mockModel);

        $mockRepo->addValidationOption('rules', 'name', 'required');

        $this->assertEquals($mockModel, $mockRepo->update(1, compact('name')));
    }

    /**
     * @test
     */
    public function update_ModelException()
    {
        $this->setExpectedException(BaseModelException::class, 'Model could not be found.');

        $mockRepo = m::mock(CrudServiceBase::class)->makePartial();

        Lang::shouldReceive('get')->once()->andReturn('Model could not be found.');
        $mockRepo->shouldReceive('find')->once()->andReturnNull();
        $mockRepo->shouldReceive('throwException')->once()->andThrow(new BaseModelException(Lang::get('support.exceptions.model.find')));

        $mockRepo->update(1, []);
    }

    /**
     * @test
     */
    public function update_ValidateException()
    {
        $this->setExpectedException(ValidateException::class, 'Error');

        $mockRepo = m::mock(CrudServiceBase::class)->makePartial();
        $mockModel = m::mock('Model');
        $name = null;

        Validator::shouldReceive('make')->once()->andReturn(m::mock(['fails' => 'true']));
        Lang::shouldReceive('get')->once()->andReturn('Error');
        $mockRepo->shouldReceive('find')->once()->andReturn($mockModel);

        $mockRepo->addValidationOption('rules', 'name', 'required');
        $mockRepo->update(1, compact('name'));
    }

    /**
     * @test
     */
    public function delete()
    {
        $mockRepo = m::mock(CrudServiceBase::class)->makePartial();
        $mockModel = m::mock('Model');

        $mockRepo->shouldReceive('find')->once()->andReturn($mockModel);
        $mockModel->shouldReceive('delete')->once()->andReturn(true);

        $this->assertTrue($mockRepo->delete(1));
    }

    /**
     * @test
     */
    public function delete_ModelException()
    {
        $this->setExpectedException(BaseModelException::class, 'Model could not be found.');

        $mockRepo = m::mock(CrudServiceBase::class)->makePartial();

        Lang::shouldReceive('get')->once()->andReturn('Model could not be found.');
        $mockRepo->shouldReceive('find')->once()->andReturnNull();
        $mockRepo->shouldReceive('throwException')->once()->andThrow(new BaseModelException(Lang::get('support.exceptions.model.find')));

        $mockRepo->delete(1);
    }
}

class TestRepo extends CrudServiceBase
{
    // Used for testing init.
}