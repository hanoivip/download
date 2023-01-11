<?php
namespace Hanoivip\Download\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ManualProvision implements IIosProvision
{
    public function registerDevice($udid)
    {
        Log::error("Hey Admin, just do it! $udid");
        $list = Cache::get("pending_ios_devices", []);
        $list[] = $udid;
        Cache::put("pending_ios_devices", $list);
        return true;
    }

    public function isDone($udid)
    {
        $list = Cache::get("pending_ios_devices", []);
        return !in_array($udid, $list);
    }

    
}