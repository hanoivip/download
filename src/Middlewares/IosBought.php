<?php

namespace Hanoivip\Download\Middlewares;

use Hanoivip\Download\Services\IosService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Closure;
use Illuminate\Support\Facades\App;

class IosBought
{
    private $service;
    
    public function __construct(IosService $b)
    {
        $this->service = $b;
    }
    
    public function handle($request, Closure $next)
    {
        if (Auth::check())
        {
            if (App::environment('local'))
            {
                return $next($request);
            }
            $userId = Auth::user()->getAuthIdentifier();
            $info = $this->service->getInfo($userId);
            if (empty($info))
            {
                Log::error("User did not buy!");
                abort(404, "User did not buy!");
            }
            return $next($request);
        }
        return response('Unauthorized.', 401);
    }
}
