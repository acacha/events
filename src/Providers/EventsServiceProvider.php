<?php

namespace Acacha\Events\Providers;

use Acacha\Events\Console\Commands\Esborrar;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

/**
 * Class EventsServiceProvider.
 */
class EventsServiceProvider extends ServiceProvider
{

    public function register()
    {
        if (!defined('EVENTS_PATH')) {
            define('EVENTS_PATH', realpath(__DIR__.'/../../'));
        }

        $this->registerEloquentFactoriesFrom(EVENTS_PATH . '/database/factories');

    }

    public function boot()
    {

        $this->defineRoutes();
        $this->loadViews();
        $this->loadmigrations();
        $this->loadCommands();
    }

    protected function loadCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Esborrar::class,
            ]);
        }
    }

    private function defineRoutes()
    {
        $this->defineWebRoutes();
        $this->defineApiRoutes();
    }

    protected function defineWebRoutes()     {
        require EVENTS_PATH . '/routes/web.php';
    }

    protected function defineApiRoutes()     {
        require EVENTS_PATH . '/routes/api.php';
    }

    private function loadViews()
    {
        $this->loadViewsFrom(EVENTS_PATH.'/resources/views', 'events');
    }

    private function loadMigrations()
    {
        $this->loadMigrationsFrom(EVENTS_PATH.'/database/migrations');
    }

    /**
     * Register factories.
     *
     * @param  string  $path
     * @return void
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }
}