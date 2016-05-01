<?php

namespace IanOlson\Support\Tests\Traits;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Events\Dispatcher;
use IanOlson\Support\Helpers\ValidateVariableTypeHelper;
use IanOlson\Support\Tests\TestCase;
use IanOlson\Support\Traits\UuidTrait;

class UuidTraitTest extends TestCase
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();
        $this->configureDatabase();
        $this->migrateTestTable();
    }

    /**
     * Configure in memory database.
     */
    protected function configureDatabase()
    {
        $db = new DB;
        $db->addConnection(array(
            'driver'    => 'sqlite',
            'database'  => ':memory:',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ));
        $db->setEventDispatcher(new Dispatcher(new Container()));
        $db->bootEloquent();
        $db->setAsGlobal();

    }

    /**
     * Migrate test table.
     */
    public function migrateTestTable()
    {
        DB::schema()->create('testing', function(Blueprint $table) {
            $table->uuid('id');
            $table->string('test');
            $table->timestamps();
        });
    }

    /**
     * @test
     */
    public function testUuid()
    {
        $test = 'testing';
        $model = UuidStub::create(compact('test'));

        $this->assertNotNull($model->id);
        $this->assertTrue(ValidateVariableTypeHelper::isString($model->id, 'id'));
    }
}

class UuidStub extends Model
{
    use UuidTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'testing';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['test'];
}