<?php

namespace VnCoder\Core\Console;

use Illuminate\Console\Command;

class RunCommand extends Command
{
    protected $signature = 'run {method} {action?}';
    protected $description = 'Auto run command from app/Command';

    public function handle()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            system('cls');
        } else {
            system('clear');
        }

        $method = $this->argument('method');
        if (!$method) {
            die("Error: Permission denied\n");
        }

        $action = $this->argument('action');
        if (!$action) {
            $action = 'index';
        }
        $controller = "App\\Command\\" . ucfirst($method) . "Command";

        if (class_exists($controller)) {
            $class = app()->make($controller);
            $method = ucfirst($action)."_Action";
            if (!method_exists($class, $method)) {
                die("Method $method not active in class $controller \n");
            } else {
                $class->$method();
            }
        } else {
            die('Please create command '.ucfirst($method).'Command in app/Command folder!');
        }
    }
}
