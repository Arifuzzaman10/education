<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use App\SmGeneralSettings;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        if (Storage::exists('.app_installed') and Storage::get('.app_installed')) {
            App::setLocale(getUserLanguage());
            try {
                $school_id = 1 ;
                if (auth()->check()) {
                    $school_id = auth()->user()->school_id;
                } elseif (app()->bound('school')) {
                    $school_id = app('school')->id;
                }
                $time_zone_setup = SmGeneralSettings::join('sm_time_zones', 'sm_time_zones.id', '=', 'sm_general_settings.time_zone_id')->where('school_id', $school_id)->first();
                // App::setTimeZone($time_zone_setup->time_zone);
                date_default_timezone_set($time_zone_setup->time_zone);
            } catch (\Throwable $th) {
                throw $th;
            }

        }

        return $next($request);
    }
}
