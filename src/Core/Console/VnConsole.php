<?php

namespace VnCoder\Core\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


class VnConsole extends ConsoleKernel
{

    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule)
    {
        if (file_exists(APP_PATH . 'schedule.php')) {
            require APP_PATH . 'schedule.php';
        }
    }

}