<?php
namespace Hanoivip\Download\Controllers;

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
                return $this->iosInhouse($request);
            }
            else 
            {
                return $this->androidDirect($request);
            }
        }
        else if (Agent::isDesktop())
        {
            return view('hanoivip::pc');
        }
    }
    
    // 2 redirect to CHPlay, display error if not found
    public function androidStore(Request $request)
    {
        $lang = "";
        if ($request->has('lang'))
            $lang = $request->input('lang');
        if (!empty($lang))
            $link = __('hanoivip::download.gg-play', [], $lang);
        else
            $link = __('hanoivip::download.gg-play');
        if (!empty($link))
            return view('hanoivip::android-store', ['link' => $link]);
        return view('hanoivip::android-store');
    }
    
    // 3 direct download, show backup links
    public function androidDirect(Request $request)
    {
        $lang = "";
        if ($request->has('lang'))
            $lang = $request->input('lang');
        if (!empty($lang))
            $link = __('hanoivip::download.apk-direct', [], $lang);
        else
            $link = __('hanoivip::download.apk-direct');
        if (!empty($link))
            return view('hanoivip::android-apk', ['link' => $link]);
        return view('hanoivip::android-apk');
    }
    
    // 4 redirect to AppStore, display if not found
    public function iosStore(Request $request)
    {
        $lang = "";
        if ($request->has('lang'))
            $lang = $request->input('lang');
        if (!empty($lang))
            $link = __('hanoivip::download.ios-app-store', [], $lang);
        else
            $link = __('hanoivip::download.ios-app-store');
        if (!empty($link))
            return view('hanoivip::ios-store', ['link' => $link]);
        return view('hanoivip::ios-store');
    }
    
    // 5 download plist file, display error if not found
    public function iosInhouse(Request $request)
    {
        $lang = "";
        if ($request->has('lang'))
            $lang = $request->input('lang');
        if (!empty($lang))
            $link = __('hanoivip::download.ios-in-house', [], $lang);
        else
            $link = __('hanoivip::download.ios-in-house');
        if (!empty($link))
            return view('hanoivip::ios-inhouse', ['link' => $link]);
        return view('hanoivip::ios-inhouse');
    }
}