<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
   
    public function handle($request, Closure $next) {
        // cek apakah user merupakan admin
        if (Auth :: check() && Auth :: user()->level === 'admin') {
        return $next($request);
        }
        // jika bukan admin maka ke halaman home
        return redirect('/home');
    }
}
