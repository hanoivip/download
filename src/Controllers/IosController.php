<?php
namespace Hanoivip\Download\Controllers;

use Hanoivip\Download\Services\IosService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Hanoivip\Payment\Facades\BalanceFacade;

class IosController extends Controller
{
    private $service;
    
    public function __construct(IosService $b)
    {
        $this->service = $b;
    }
    
    public function index(Request $request)
    {
        $userId = Auth::user()->getAuthIdentifier();
        $info = $this->service->getInfo($userId);
        if (empty($info))
        {
            // not buy anytime
            $cost = config('ios.cost', 999999);
            $days = config('ios.days', 10);
            return view('hanoivip::ios-buy', ['cost' => $cost, 'days' => $days]);
        }
        else
        {
            if (empty($info->udid))
            {
                return view('hanoivip::ios-ask-udid');
            }
            return view('hanoivip::ios-detail', ['beginTime' => $info->begin_time, 'endTime' => $info->end_time]);
        }
    }
    
    public function buy()
    {
        $userId = Auth::user()->getAuthIdentifier();
        $cost = config('ios.cost');
        $days = config('ios.days');
        if (BalanceFacade::enough($userId, $cost))
        {
            $result = $this->service->newInstall($userId, $days);
            if ($result === true)
            {
                $ok = BalanceFacade::remove($userId, $cost, 'Ios');
                if (empty($ok))
                {
                    Log::error("Ios fail to recharge user $userId with $cost coins");
                }
                return view('hanoivip::ios-buy-success');
            }
            else if ($result === false)
            {
                $error = __('hanoivip::ios.failure');
            }
            else
            {
                $error = $result;
            }
        }
        else
        {
            $error = __('hanoivip::balance.not-enough-money');
        }
        // Log::error($error);
        return view('hanoivip::ios-buy', ['cost' => $cost, 'days' => $days, 'error' => $error]);
    }
    
    public function askUdid()
    {
        return view('hanoivip::ios-ask-udid');
    }
    
    public function udid()
    {
        $userId = Auth::user()->getAuthIdentifier();
        $udid = Request::input('udid');
        $result = $this->service->registerDevice($userId, $udid);
        if ($result === true)
        {
            return view('hanoivip::ios-udid-success');
        }
        else if ($result === false)
        {
            $error = __('hanoivip::ios.register-device-failed');
        }
        else
        {
            $error = $result;
        }
        return view('hanoivip::ios-ask-udid', ['error' => $error]);
    }
    
    public function history()
    {
        $userId = Auth::user()->getAuthIdentifier();
        //TODO: make UserLog
        $records = $this->service->getHistory($userId);
        return view('hanoivip::ios-history', ['records' => $records]);
    }
    
    public function renew()
    {
        $userId = Auth::user()->getAuthIdentifier();
        $cost = config('ios.cost');
        $days = config('ios.days');
        if (BalanceFacade::enough($userId, $cost))
        {
            $ok = $this->service->renewInstall($userId, $days);
            if ($ok)
            {
                $ok1 = BalanceFacade::remove($userId, $cost, 'Ios');
                if (empty($ok1))
                {
                    Log::error("Fail to recharge player $userId with $cost coins");
                }
                return view('hanoivip::ios-buy-success');
            }
            else
            {
                $error = __('hanoivip::ios.failure');
            }
        }
        else
        {
            $error = __('hanoivip::balance.not-enough-money');
        }
        return view('hanoivip::ios-buy', ['cost' => $cost, 'days' => $days, 'error' => $error]);
    }
}