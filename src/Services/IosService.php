<?php
namespace Hanoivip\Download\Services;

use Hanoivip\Download\Models\IosInstall;
use Illuminate\Support\Carbon;
use Hanoivip\Download\Jobs\WaitDeviceRegistration;
use Hanoivip\Events\Download\IosProvisionRenewSuccess;

class IosService
{
    private $provision;
    
    public function __construct(IIosProvision $p)
    {
        $this->provision = $p;
    }
    /**
     * 
     * @param number $userId
     * @return IosInstall
     */
    public function getInfo($userId)
    {
        return IosInstall::where('user_id', $userId)->first();
    }
    /**
     *
     * @param number $userId
     * @param number $days
     * @return boolean
     */
    public function newInstall($userId, $days)
    {
        $info = $this->getInfo($userId);
        if (!empty($info))
            return false;
        $record = new IosInstall();
        $record->user_id = $userId;
        $record->buy_days = $days;
        $record->save();
        return true;
    }
    /**
     * 
     * @param number $userId
     * @param string $udid
     * @return boolean
     */
    public function registerDevice($userId, $udid)
    {
        $dev = IosInstall::where('udid', $udid)->first();
        if (!empty($dev))
            return __('hanoivip::ios.device-registered');
        $record = $this->getInfo($userId);
        if (!empty($record->udid))
            return __('hanoivip::ios.user-had-device');
        $record->udid = $udid;
        $record->save();
        // request to device provision
        if ($this->provision->registerDevice($udid))
        {
            dispatch(new WaitDeviceRegistration($userId, $udid))->delay(now()->addSeconds(180));
            return true;
        }
        return false;
    }
    /**
     * 
     * @param number $userId
     * @param number $days Number of days to renew/added
     * @return boolean
     */
    public function renewInstall($userId, $days)
    {
        $record = $this->getInfo($userId);
        $now = now()->timestamp;
        if ($now > $record->end_time)
        {
            // log?
            $record->begin_time = $now;
            $record->end_time = now()->addDays($days)->timestamp;
            $record->save();
            /*
            if ($this->provision->renewDevice($record->udid))
            {
                dispatch(new WatiDeviceRenewal($record->user_id, $record->udid))->delay(now()->addSeconds(180));
                return true;
            }
            return false;*/
        }
        else
        {
            $endTime = $record->end_time;
            $record->end_time = (Carbon::parse($endTime)->addDays($days)->timestamp);
            $record->save();
        }
        // event
        dispatch(new IosProvisionRenewSuccess($userId, $record->udid));
        return true;
    }
    
    public function onProvisionDone($userId, $udid)
    {
        $record = $this->getInfo($userId);
        $now = now()->timestamp;
        $record->begin_time = $now;
        $record->end_time = now()->addDays($record->buy_days)->timestamp;
        $record->save();
    }
}