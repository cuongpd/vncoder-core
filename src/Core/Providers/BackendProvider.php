<?php

namespace VnCoder\Core\Providers;

use Illuminate\Support\ServiceProvider;

define('ADMIN_PATH', VNCODER_PATH.'Admin'.DIRECTORY_SEPARATOR);
define('BACKEND_PATH', APP_PATH.'backend'.DIRECTORY_SEPARATOR);

class BackendProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(ADMIN_PATH.'Views', 'admin');
        $this->loadViewsFrom(BACKEND_PATH.'Views', 'backend');
    }

    public function register()
    {
        // Helper
        require ADMIN_PATH.'helper.php';
        if (file_exists(BACKEND_PATH.'helper.php')) {
            require BACKEND_PATH.'helper.php';
        }
    }
}
