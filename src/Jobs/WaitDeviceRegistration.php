<?php
namespace Hanoivip\Download\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Hanoivip\Download\Services\IIosProvision;
use Exception;
use Hanoivip\Download\Services\IosService;
use Hanoivip\Events\Download\IosProvisionSuccess;

class WaitDeviceRegistration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    private $userId;
    
    private $udid;
    
    public function __construct($userId, $udid)
    {
        $this->userId = $userId;
        $this->udid = $udid;
    }
    
    public function handle()
    {
        $provision = app()->make(IIosProvision::class);
        if (empty($provision))
        {
            $this->fail(new Exception("Ios Provision must be defined!"));
            return;
        }
        $mode = config('ios.mode', 'manual');
        if ($mode == 'manual')
        {
            $this->delete();
            return;  
        }
        if (!$provision->isDone($this->udid))
        {
            $this->release(3600);
            return;
        }
        // business
        $service = app()->make(IosService::class);
        $service->onProvisionDone($this->userId, $this->udid);
        // event
        event(new IosProvisionSuccess($this->userId, $this->udid));
    }
}