<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna sudah login dan memiliki utype 'Admin'
        if (Auth::check() && strcasecmp(Auth::user()->utype, 'Admin') === 0) {
            return $next($request); // Jika Admin, lanjutkan request
        }

        // Jika bukan admin atau belum login, logout dan redirect ke login
        Auth::logout();
        return redirect()->route('login')->with('error', 'You do not have admin access.');
    }
}