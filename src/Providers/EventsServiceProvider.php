<?php

namespace Acacha\Events\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class EventsServiceProvider.
 */
class EventsServiceProvider extends ServiceProvider
{

    public function register()
    {
//        dump('Registering Events package');
        if (!defined('EVENTS_PATH')) {
            define('EVENTS_PATH', realpath(__DIR__.'/../../'));
        }

    }

    public function boot()
    {
//        dump('Booting Events package');

        $this->defineRoutes();
        $this->loadViews();
        $this->loadmigrations();
    }

    private function defineRoutes()
    {
        require EVENTS_PATH . '/src/routes/web.php';
    }

    private function loadViews()
    {
        $this->loadViewsFrom(EVENTS_PATH.'/resources/views', 'events');
    }

    private function loadMigrations()
    {
        $this->loadMigrationsFrom(EVENTS_PATH.'/database/migrations');
    }
}