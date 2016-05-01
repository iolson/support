<?php

namespace IanOlson\Support;

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
     * Register CRUD generator command.
     */
    private function registerCrudGeneratorCommand()
    {
        $this->app['support:make:crud'] = $this->app->share(function () {
            return new Commands\CrudGenerate();
        });

        $this->commands('support:make:crud');
    }

    /**
     * Register GitLab generator command.
     */
    private function registerGitlabGeneratorCommand()
    {
        $this->app['support:make:gitlab'] = $this->app->share(function () {
            return new Commands\GitlabGenerate();
        });

        $this->commands('support:make:gitlab');
    }
}
