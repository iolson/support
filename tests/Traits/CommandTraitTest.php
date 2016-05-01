<?php

namespace IanOlson\Support\Tests\Traits;

use ErrorException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Mockery as m;
use IanOlson\Support\Tests\TestCase;
use IanOlson\Support\Exceptions\InvalidVariableTypeException;
use IanOlson\Support\Traits\CommandTrait;

class CommandTraitTest extends TestCase
{
    /**
     * @var CommandStub
     */
    private $commandStub;

    public function setUp()
    {
        parent::setUp();
        $this->commandStub = m::mock(CommandStub::class);
    }

    public function testGetModel()
    {
        $this->assertNull($this->commandStub->getModel());
    }

    public function testSetModel()
    {
        $this->commandStub->setModel('Test');

        $this->assertEquals('Test', $this->commandStub->getModel());
    }

    public function testSetModel_InvalidVariableTypeException()
    {
        $this->setExpectedException(InvalidVariableTypeException::class);

        $this->commandStub->setModel(1);
    }

    public function testGetTable()
    {
        $this->assertNull($this->commandStub->getTable());
    }

    public function testSetTable()
    {
        $this->commandStub->setTable('test');

        $this->assertEquals('test', $this->commandStub->getTable());
    }

    public function testSetTable_InvalidVariableTypeException()
    {
        $this->setExpectedException(InvalidVariableTypeException::class);

        $this->commandStub->setTable(1);
    }

    public function testGetPath()
    {
        $this->assertNull($this->commandStub->getPath());
    }

    public function testSetPath()
    {
        $this->commandStub->setPath('test');

        $this->assertEquals('test', $this->commandStub->getPath());
    }

    public function testSetPath_InvalidVariableTypeException()
    {
        $this->setExpectedException(InvalidVariableTypeException::class);

        $this->commandStub->setPath(1);
    }

    public function testCreateDirectory()
    {
        File::shouldReceive('makeDirectory')->once()->andReturn(true);

        $this->commandStub->createDirectory('directory');
    }

    public function testCreateDirectory_ErrorException()
    {
        $this->setExpectedException(ErrorException::class);

        File::shouldReceive('makeDirectory')->once()->andThrow(new ErrorException());

        $this->commandStub->createDirectory('directory');
    }

    public function testGetContent()
    {
        File::shouldReceive('get')->once()->andReturn('No Stub Content');

        $this->assertEquals('No Stub Content', $this->commandStub->getContent('Model'));
    }

    public function testGetContent_Model()
    {
        File::shouldReceive('get')->once()->andReturn('{{model}} Model');
        $this->commandStub->setModel('Test');

        $this->assertEquals('Test Model', $this->commandStub->getContent('Model'));
    }

    public function testGetContent_Table()
    {
        File::shouldReceive('get')->once()->andReturn('{{model}} Model {{table}}');
        $this->commandStub->setModel('Test');
        $this->commandStub->setTable(Str::plural(Str::snake('Test')));

        $this->assertEquals('Test Model tests', $this->commandStub->getContent('Model'));
    }

    public function testWriteFile()
    {
        $content = 'Hello';
        $directory = null;
        $fileName = 'Test';

        File::shouldReceive('put')->once()->andReturn(true);
        $this->commandStub->setPath('/');

        $this->commandStub->writeFile($content, $directory, $fileName);
    }

    public function testWriteFile_Directory()
    {
        $content = 'Hello';
        $directory = 'testing';
        $fileName = 'Test';

        File::shouldReceive('put')->once()->andReturn(true);
        $this->commandStub->setPath('/');

        $this->commandStub->writeFile($content, $directory, $fileName);
    }
}

class CommandStub extends Command
{
    use CommandTrait;

    const COMMAND_DIRECTORY = 'command';
    const STUB_DIRECTORY = 'stub';
}
