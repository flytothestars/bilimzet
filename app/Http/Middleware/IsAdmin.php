<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;


class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        if (auth()->user()->isAdmin()) {
            return $next($request);
        }
        if (auth()->user()->isDefault()) {
            return redirect()->route('profile');
        }
    }
}
