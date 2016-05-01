<?php

namespace IanOlson\Support;

use IanOlson\Support\Commands\CircleGenerate;
use IanOlson\Support\Commands\CrudGenerate;
use IanOlson\Support\Commands\GitlabGenerate;
use IanOlson\Support\Commands\TravisGenerate;
use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerCrudGeneratorCommand();
        $this->registerGitlabGeneratorCommand();
        $this->registerTravisGeneratorCommand();
        $this->registerCircleGeneratorCommand();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Register CircleCI generator command.
     */
    private function registerCircleGeneratorCommand()
    {
        $this->app['support:ci:circle'] = $this->app->share(function () {
            return new CircleGenerate();
        });

        $this->commands('support:ci:circle');
    }

    /**
     * Register CRUD generator command.
     */
    private function registerCrudGeneratorCommand()
    {
        $this->app['support:make:crud'] = $this->app->share(function () {
            return new CrudGenerate();
        });

        $this->commands('support:make:crud');
    }

    /**
     * Register GitLab CI generator command.
     */
    private function registerGitlabGeneratorCommand()
    {
        $this->app['support:ci:gitlab'] = $this->app->share(function () {
            return new GitlabGenerate();
        });

        $this->commands('support:ci:gitlab');
    }

    /**
     * Register Travis CI generator command.
     */
    private function registerTravisGeneratorCommand()
    {
        $this->app['support:ci:travis'] = $this->app->share(function () {
            return new TravisGenerate();
        });

        $this->commands('support:ci:travis');
    }
}
