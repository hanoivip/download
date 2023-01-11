<?php
namespace Hanoivip\Download\Controllers;

use Hanoivip\Download\Services\IosService;
use Illuminate\Support\Facades\Auth;

class Admin extends Controller
{
    private $service;
    
    public function __construct(IosService $b)
    {
        $this->service = $b;
    }
    
    public function index()
    {
        $userId = Auth::user()->getAuthIdentifier();
        $info = $this->service->getInfo($userId);
        if (empty($info))
        {
            // not buy anytime
            $cost = config('ios.cost');
            $days = config('ios.days');
            return view('hanoivip::ios-buy', ['cost' => $cost, 'days' => $days]);
        }
        else
        {
            // renew
            return view('hanoivip::ios-detail', ['expires' => $info->expires]);
        }
    }
    
    public function buy()
    {
        $userId = Auth::user()->getAuthIdentifier();
    }
    
    public function history()
    {
        
    }
    
    public function renew()
    {
        
    }
}