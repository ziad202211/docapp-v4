<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;
use Illuminate\Http\Request;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check()) {
            if (Auth::user()->role == $role) {
                return $next($request);
            }
            // Redirect based on the user role
            if ($role == 'doctor') {
                return redirect('/doctor/dashboard'); // Or any other redirection
            } elseif ($role == 'patient') {
                return redirect('/patient/dashboard'); // Or any other redirection
            }
        }

        return redirect('/'); // Redirect to home if not logged in or no role match
    }

}
