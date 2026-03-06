<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->must_change_password) {
            // Allow access to profile and logout routes
            if (! $request->routeIs(['profile.edit', 'profile.update', 'password.update', 'logout'])) {
                return redirect()->route('profile.edit')->with('info', 'You must change your password before continuing.');
            }
        }

        return $next($request);
    }
}
