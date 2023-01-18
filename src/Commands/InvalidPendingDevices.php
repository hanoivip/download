<?php

namespace Hanoivip\Download\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Hanoivip\Download\Models\IosInstall;
use Hanoivip\Events\Download\IosDeviceInvalid;

class InvalidPendingDevices extends Command
{
    protected $signature = 'ios:invalid {udid}';

    protected $description = 'Mark device as invalid';
    
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
        $record = IosInstall::where('udid', $udid)->first();
        if (!empty($record))
        {
            $record->udid = '';
            $record->begin_time = 0;
            $record->end_time = 0;
            $record->save();
            event(new IosDeviceInvalid($record->user_id, $udid));
        }
        $this->info("ok");
    }
}
