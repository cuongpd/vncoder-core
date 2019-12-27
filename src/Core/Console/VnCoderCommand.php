<?php

namespace VnCoder\Core\Console;

use Illuminate\Console\Command;

class VnCoderCommand extends Command
{
    protected $signature = 'vncoder {action}';
    protected $description = 'VnCoder Command - User for VnCMS';

    public function handle()
    {
        $action = $this->argument('action');
        if (!$action) {
            $action = 'index';
        }

    }
}
