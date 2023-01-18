<?php

namespace Hanoivip\Download\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Hanoivip\Download\Services\IosService;

class InvalidPendingDevices extends Command
{
    protected $signature = 'ios:invalid {udid}';

    protected $description = 'Mark device as invalid';
    
    private $service;
    
    public function __construct(IosService $s)
    {
        parent::__construct();
        $this->service = $s;
    }
    
    public function handle()
    {
        $udid = $this->argument('udid');
        // Finish
        $list = Cache::get('pending_ios_devices', []);
        $newList = [];
        foreach ($list as $d)
        {
            if ($d == $udid)
            { 
            }
            else
            {
                $newList[] = $d;
            }
        }
        Cache::put('pending_ios_devices', $newList);
        if ($this->service->invalidPending($udid))
        {
            $this->info("ok");
        }
        else
        {
            $this->error("fail to mark pending");
        }
    }
}
