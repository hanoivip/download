<?php

namespace Hanoivip\Download\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Hanoivip\Download\Models\IosInstall;
use Hanoivip\Download\Services\IosService;
use Hanoivip\Events\Download\IosProvisionSuccess;

class ClearPendingDevices extends Command
{
    protected $signature = 'ios:clear';

    protected $description = 'Clear all pending device to register';
    
    public function handle()
    {
        // Finish
        $service = app()->make(IosService::class);
        $list = Cache::get('pending_ios_devices', []);
        foreach ($list as $udid)
        {
            $record = IosInstall::where('udid', $udid)->first();
            if (!empty($record))
            {
                // business
                $service->onProvisionDone($record->user_id, $record->udid);
                // send notifications
                dispatch(new IosProvisionSuccess($record->user_id, $record->udid));
            }
        }
        Cache::put('pending_ios_devices', []);
        $this->info("ok");
    }
}
