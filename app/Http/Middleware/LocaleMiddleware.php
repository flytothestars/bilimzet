<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
	public static $mainLanguage = 'ru';
	public static $languages = [ 'ru', 'kz' ];

	public static function getLocale()
	{
		$uri = request()->path();
		$segmentsURI = explode('/', $uri);

		if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], self::$languages)) {
			if ($segmentsURI[0] != self::$mainLanguage) {
				return $segmentsURI[0];
			}
		}
		return null;
	}


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	    $locale = self::getLocale();
	    App::setLocale($locale ? $locale : self::$mainLanguage);
	    return $next($request);
    }
}
