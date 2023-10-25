<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckEditProfileAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->route('user_id');
        $authenticatedUserId = auth()->user()->id;

        if ($userId != $authenticatedUserId) {
            return abort(403);
        }

        return $next($request);
    }
}
