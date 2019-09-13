<?php
namespace Hanoivip\Download;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;


class DownloadController extends Controller
{
    // 1 click to download
    public function general(Request $request)
    {
        if (Agent::isMobile() || Agent::isTablet())
        {
            if (Agent::is('iOS'))
            {
                return view('hanoivip::ios-inhouse');
            }
            else 
            {
                return view('hanoivip::android-apk');
            }
        }
        else if (Agent::isDesktop())
        {
            return view('hanoivip::pc');
        }
    }
}