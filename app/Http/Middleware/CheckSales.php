<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSales
{
    public function handle($request, Closure $next)
    {
        // Periksa apakah pengguna adalah pegawai (role = 1)
        if (Auth::check()) {
            if (Auth::user()->role == 3){
                return $next($request);
            }
            return response()->view('errors.custom', ['message' => 'Anda Bukan Sales'], 403);
        }
        return redirect('/');; // Ganti dengan kode status atau rute yang sesuai
    }
}
