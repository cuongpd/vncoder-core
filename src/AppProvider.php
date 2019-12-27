<?php

namespace VnCoder;

use Illuminate\Support\ServiceProvider;

use VnCoder\Core\Providers\BackendProvider;
use VnCoder\Core\Providers\FrontendProvider;
use VnCoder\Core\Providers\RouteProvider;
use VnCoder\Core\Console\VnCoderCommand;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use VnCoder\Core\Providers\BroadcastProvider;
use VnCoder\Core\Console\RunCommand;
use VnCoder\Core\Console\CrudCommand;

define('VNCODER_PATH', realpath(__DIR__). DIRECTORY_SEPARATOR);
define('HELPER_PATH', VNCODER_PATH. DIRECTORY_SEPARATOR.'Helper'. DIRECTORY_SEPARATOR );

class AppProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(VNCODER_PATH . 'Core/Views', 'core');
    }

    public function register()
    {
        $this->registerModule();
        $this->registerService();
    }

    protected function registerModule()
    {
        if (defined('IS_BACKEND')) {
            $this->app->register(BackendProvider::class);
        } else {
            $this->app->register(FrontendProvider::class);
        }
        $this->app->register(RouteProvider::class);

        if ($this->app->runningInConsole()) {
            $this->commands(CrudCommand::class); // Crud Command
            $this->commands(RunCommand::class); // php artisan run {method} {action?}
            $this->commands(VnCoderCommand::class); // php artisan vncoder:{action}
        }        
    }

    protected function registerService()
    {
        $debugbar = vn_cookie('_debugbar');
        if ($debugbar == 'on') {
            Debugbar::enable(); // Turn on debugbar
        }

    }

}
