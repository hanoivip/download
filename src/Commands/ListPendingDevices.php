<?php

namespace Hanoivip\Download\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ListPendingDevices extends Command
{
    protected $signature = 'ios:list';

    protected $description = 'List all pending device to register';
    
    public function handle()
    {
        $list = Cache::get('pending_ios_devices');
        $this->info("list:" . json_encode($list));
    }
}
