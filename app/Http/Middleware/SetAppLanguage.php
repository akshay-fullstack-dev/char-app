<?php

namespace App\Http\Middleware;

use App;
use Closure;

class SetAppLanguage
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
        $default_lang = config('language.default');
        $language = trim($request->header('Accept-Language'));
        if ($language == '' || $language == $default_lang) {
            App::setLocale($default_lang);
        } else {
            // if language exists then set that language otherwise use default 
            if (array_key_exists($language, config('language'))) {
                App::setLocale($language);
            } else {
                App::setLocale($default_lang);
            }
        }
        return $next($request);
    }
}
