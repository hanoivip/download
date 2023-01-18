<?php
namespace Hanoivip\Download\Controllers;

use Hanoivip\Download\Services\IosService;
use Hanoivip\Events\Download\IosProvisionSuccess;
use Illuminate\Support\Facades\Request;

class Admin extends Controller
{
    private $service;
    
    public function __construct(IosService $b)
    {
        $this->service = $b;
    }
    
    public function index()
    {
        return $this->listPending();
    }
    
    public function listPending()
    {
        $pendings = $this->service->listPending();
        return view('hanoivip::admin.ios-pendings', ['pendings' => $pendings]);
    }
    
    public function invalidPending()
    {
        $udid = Request::input('udid');
        $result = $this->service->invalidPending($udid);
        return $this->listPending();
    }
    
    public function finishPending()
    {
        $pendings = $this->service->listPending();
        foreach ($pendings as $record) 
        {
            // business
            $this->service->onProvisionDone($record->user_id, $record->udid);
            // send notifications
            event(new IosProvisionSuccess($record->user_id, $record->udid));
        }
        return view('hanoivip::admin.ios-finish-pendings');
    }
}