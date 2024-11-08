<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\LocaleMiddleware;

class LocaleController extends PageController
{
	public function set(Request $request, $lang)
	{
		$referer = url()->previous();
		$parse_url = parse_url($referer, PHP_URL_PATH);
		$segments = explode('/', $parse_url);

		if (in_array($segments[1], LocaleMiddleware::$languages)) {
			unset($segments[1]);
		}

		if ($lang != LocaleMiddleware::$mainLanguage) {
			array_splice($segments, 1, 0, $lang);
		}

		$url = $request->root().implode("/", $segments);
		if (parse_url($referer, PHP_URL_QUERY)) {
			$url = $url . '?' . parse_url($referer, PHP_URL_QUERY);
		}

		return redirect($url);
	}
}
