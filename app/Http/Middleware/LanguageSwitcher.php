<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class LanguageSwitcher
{
    public function handle($request, Closure $next)
    {
        $locale = session('app_locale', config('app.locale'));
        App::setLocale($locale);
        return $next($request);
    }

}