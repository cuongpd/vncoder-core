<?php

namespace VnCoder\Core\Providers;

use Illuminate\Support\ServiceProvider;

define('API_PATH', APP_PATH.'api'.DIRECTORY_SEPARATOR);
define('FRONTEND_PATH', APP_PATH.'frontend'.DIRECTORY_SEPARATOR);

class FrontendProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(API_PATH.'Views', 'api');
        $this->loadViewsFrom(FRONTEND_PATH.'Views', 'frontend');

        if (!env('APP_DEBUG')) {
            ob_start("minify_output", true);
        }
    }

    public function register()
    {
        if (file_exists(FRONTEND_PATH.'helper.php')) {
            require FRONTEND_PATH.'helper.php';
        }
    }
}
