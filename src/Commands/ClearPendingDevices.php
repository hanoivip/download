<?php

namespace Hanoivip\Download\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Hanoivip\Download\Models\IosInstall;
use Hanoivip\Download\Services\IosService;
use Hanoivip\User\Facades\UserFacade;
use Hanoivip\Download\Notifications\IosInstallReady;

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
                $user = UserFacade::getUserCredentials($record->user_id);
                $user->notify(new IosInstallReady());
            }
        }
        Cache::put('pending_ios_devices', []);
        $this->info("ok");
    }
}
