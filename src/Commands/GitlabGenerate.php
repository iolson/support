<?php

namespace IanOlson\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use IanOlson\Support\Traits\CommandTrait;

class GitlabGenerate extends Command
{
    use CommandTrait;

    const COMMAND_DIRECTORY = __DIR__;
    const DIRECTORY_BASH = "ci";
    const STUB_DIRECTORY = "/stubs/ci/";
    const STUB_BASH = "docker_install";
    const STUB_YAML = "gitlab-ci";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'support:ci:gitlab';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates basic GitLab CI YAML and Docker bash script.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->setPath(base_path())
             ->setupFiles();

        $this->info("GitLab CI files setup and ready. Be sure to uncomment the docker images you want to test inside the
         .gitlab-ci.yml in the root.");
    }

    /**
     * Setup files.
     */
    private function setupFiles()
    {
        $this->setupBash()
             ->setupYaml()
             ->copyEnv();
    }

    /**
     * Copy ENV file.
     *
     * @return $this
     */
    private function copyEnv()
    {
        Storage::copy("{$this->getPath()}/.env.example", "{$this->getPath()}/.env.gitlab");

        return $this;
    }

    /**
     * Setup bash script for GitLab CI docker.
     *
     * @return $this
     */
    private function setupBash()
    {
        $this->createDirectory(self::DIRECTORY_BASH);
        $content = $this->getContent(self::STUB_BASH);
        $this->writeFile($content, self::DIRECTORY_BASH, self::STUB_BASH, null, '.sh');

        return $this;
    }

    /**
     * Setup GitLab CI Yaml configuration file.
     *
     * @return $this
     */
    private function setupYaml()
    {
        $fileName = '.' . self::STUB_YAML;
        $content = $this->getContent(self::STUB_YAML);
        $this->writeFile($content, null, $fileName, null, '.yaml');

        return $this;
    }
}
