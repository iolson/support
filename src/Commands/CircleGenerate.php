<?php

namespace IanOlson\Support\Commands;

use Illuminate\Console\Command;
use IanOlson\Support\Traits\CommandTrait;

class CircleGenerate extends Command
{
    use CommandTrait;

    const COMMAND_DIRECTORY = __DIR__;
    const STUB_DIRECTORY = "/stubs/ci/";
    const STUB_YAML = "circle";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'support:ci:circle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates basic CircleCI YAML.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->setPath(base_path())
             ->setupFiles();
        $this->info("CircleCI files setup and ready.");
    }

    /**
     * Setup files.
     */
    private function setupFiles()
    {
        $this->setupYaml();
    }

    /**
     * Setup GitLab CI Yaml configuration file.
     */
    private function setupYaml()
    {
        $fileName = '.' . self::STUB_YAML;
        $content = $this->getContent(self::STUB_YAML);
        $this->writeFile($content, null, $fileName, null, '.yaml');
    }
}
