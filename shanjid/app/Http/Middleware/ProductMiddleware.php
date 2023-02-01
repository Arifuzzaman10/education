<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\User;
use App\Envato\Envato;
use GuzzleHttp\Client;
use App\SmGeneralSettings;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class ProductMiddleware
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
        date_default_timezone_set(timeZone());
        if (Auth::check()) {
            App::setLocale(userLanguage());
        }else{
            $user=User::where('role_id',1)->first();
            App::setLocale($user->language);
        }
        
        if (!Schema::hasTable('sm_general_settings')) {
            return redirect('install');
        }
        if (User::checkAuth() == false || User::checkAuth() == null) {
            return redirect()->route('system.config');
        } else {
            return $next($request);
        }
    }
}
