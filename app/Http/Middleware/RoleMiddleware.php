<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if the user is authenticated and if their role name is in the list of required roles.
        if (! $request->user() || ! in_array($request->user()->role->name, $roles)) {
            \Log::warning('Access control failure: User ' . ($request->user() ? $request->user()->id : 'unauthenticated') . ' attempted to access a resource requiring roles: ' . implode(', ', $roles) . ' with current role: ' . ($request->user() ? $request->user()->role->name : 'none') . ' from IP: ' . $request->ip());
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        return $next($request);
    }
}
