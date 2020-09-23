<?php
namespace Hanoivip\Download\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppDownloadController extends Controller
{
    public function getConfig(Request $request)
    {
        $buildNumber = $request->input('build_number');
        if ($buildNumber == 'unknown')
            $buildNumber = 999999;
        else
            $buildNumber = intval($buildNumber);
        $currentBuildNumber = config('download-homeapp.current_build_number', 0);
        $config = ['error' => 0, 'message' => 'success', 
            'data' => [
                'urls' => [
                    'android-store' => $buildNumber <= $currentBuildNumber ? route('android.store') : route('home'),
                    'android-apk' => $buildNumber <= $currentBuildNumber ? route('android.apk') : route('home'),
                    'ios-store' => $buildNumber <= $currentBuildNumber ? route('ios.store') : route('home'),
                    'ios-in-house' => $buildNumber <= $currentBuildNumber ? route('ios.inhouse') : route('home'),
                    //'pc' => $buildNumber <= $currentBuildNumber ? route('pc') : route('home'),
                ]
            ]
        ];
        return $config;
    }
}