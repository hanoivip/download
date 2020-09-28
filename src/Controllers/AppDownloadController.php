<?php
namespace Hanoivip\Download\Controllers;

use Illuminate\Http\Request;

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
                'current' => $currentBuildNumber,
                'urls' => [
                    'android_store' => $buildNumber <= $currentBuildNumber ? route('android.store') : route('home'),
                    'android_apk' => $buildNumber <= $currentBuildNumber ? route('android.apk') : route('home'),
                    'ios_store' => $buildNumber <= $currentBuildNumber ? route('ios.store') : route('home'),
                    'ios_inhouse' => $buildNumber <= $currentBuildNumber ? route('ios.inhouse') : route('home'),
                    'pc' => route('home'),
                ]
            ]
        ];
        return $config;
    }
}