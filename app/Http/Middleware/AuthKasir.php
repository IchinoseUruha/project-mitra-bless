<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthKasir
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

        // Periksa apakah pengguna sudah login dan memiliki utype 'Kasir'
        if (Auth::check() && strcasecmp(Auth::user()->utype, 'Kasir') === 0) {
            return $next($request); // Jika Kasir, lanjutkan request
        }

        // Jika bukan kasir atau belum login, logout dan redirect ke login
        Auth::logout();
        return redirect()->route('login')->with('error', 'You do not have cashier access.');
    }
}