<?php

namespace IanOlson\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use IanOlson\Support\Traits\CommandTrait;

class CrudGenerate extends Command
{
    use CommandTrait;

    const COMMAND_DIRECTORY = __DIR__;
    const DIRECTORY_CONTROLLERS = "Http/Controllers";
    const DIRECTORY_EXCEPTION = "Exceptions";
    const DIRECTORY_MODELS = "Models";
    const DIRECTORY_SERVICES = "Services";
    const STUB_DIRECTORY = "/stubs/crud/";
    const STUB_SERVICE = "Service";
    const STUB_SERVICE_IMPL = "ServiceImpl";
    const STUB_CONTROLLER = "Controller";
    const STUB_EXCEPTION = "Exception";
    const STUB_MODEL = "Model";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'support:make:crud {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates model with full CRUD functionality.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->setModel($this->argument('model'))
             ->setPath(app_path())
             ->setTable(Str::plural(Str::snake(class_basename($this->getModel()))))
             ->setupFiles();

        $this->info("{$this->getModel()} model and CRUD functionality have been setup.");
        $this->info("Be sure to add the bind to a registered Service Provider to be able to inject your interface.");
    }

    /**
     * Setup files.
     */
    private function setupFiles()
    {
        $this->setupInterface()
             ->setupController()
             ->setupException()
             ->setupModel()
             ->setupRepo();
    }

    /**
     * Setup interface.
     *
     * @return $this
     */
    private function setupInterface()
    {
        try {
            $this->createDirectory(self::DIRECTORY_SERVICES);
        } catch (\ErrorException $e) {
            $this->warn(self::DIRECTORY_SERVICES . " was not created. It either exists or there was an error.");
        }
        $content = $this->getContent(self::STUB_SERVICE);
        $this->writeFile($content, self::DIRECTORY_SERVICES, $this->getModel(), 'Service');

        return $this;
    }

    /**
     * Setup controller.
     *
     * @return $this
     */
    private function setupController()
    {
        $content = $this->getContent(self::STUB_CONTROLLER);
        $this->writeFile($content, self::DIRECTORY_CONTROLLERS, $this->getModel(), 'Controller');

        return $this;
    }

    /**
     * Setup exception.
     *
     * @return $this
     */
    private function setupException()
    {
        $content = $this->getContent(self::STUB_EXCEPTION);
        $this->writeFile($content, self::DIRECTORY_EXCEPTION, $this->getModel(), 'Exception');

        return $this;
    }

    /**
     * Setup model.
     *
     * @return $this
     */
    private function setupModel()
    {
        try {
            $this->createDirectory(self::DIRECTORY_MODELS);
        } catch (\ErrorException $e) {
            $this->warn(self::DIRECTORY_MODELS . " was not created. It either exists or there was an error.");
        }

        $content = $this->getContent(self::STUB_MODEL);
        $this->writeFile($content, self::DIRECTORY_MODELS, $this->getModel());
        $this->writeMigration();

        return $this;
    }

    /**
     * Setup repository.
     *
     * @return $this
     */
    private function setupRepo()
    {
        try {
            $this->createDirectory(self::DIRECTORY_SERVICES);
        } catch (\ErrorException $e) {
            $this->warn(self::DIRECTORY_SERVICES . " was not created. It either exists or there was an error.");
        }

        $content = $this->getContent(self::STUB_SERVICE_IMPL);
        $this->writeFile($content, self::DIRECTORY_SERVICES, $this->getModel(), 'ServiceImpl');

        return $this;
    }

    /**
     * Create migration file.
     *
     * @return $this
     */
    private function writeMigration()
    {
        $this->call('make:migration', ['name' => "create_{$this->getTable()}_table", '--create' => $this->getTable()]);

        return $this;
    }
}
