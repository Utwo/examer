<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (auth()->guest()) {
            return redirect()->guest('show_login');
        }

        if ($request->user()->role != $role) {
            return redirect()->back()->withErrors('Forbidden');
        }

        return $next($request);
    }
}
