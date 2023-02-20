<?php

namespace ObeliskAdmin\Http\Middleware;

use Closure;
use Gate;

class SettingsMiddleware
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
        if (Gate::denies('manage-settings')) {
            abort(403);
        }

        return $next($request);
    }
}
