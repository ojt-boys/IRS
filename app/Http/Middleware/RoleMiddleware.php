<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // if (!Auth::check()) {
        //     return redirect('/')->with('error', 'Unauthorized. Please log in.');
        // }

        // $user = Auth::user();
        // $userRoles = $user->getRoleNames()->toArray();

        // if (empty($userRoles)) {
        //     return redirect('/')->with('error', 'No role assigned. Redirecting to welcome page.');
        // }

        return $next($request);
    }
}
