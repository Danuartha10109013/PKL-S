<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckDirektur
{
    public function handle($request, Closure $next)
    {
        // Periksa apakah pengguna adalah direktur (role = 2)
        if (Auth::check()) {
            if (Auth::user()->role == 2){
                return $next($request);
            }
            return response()->view('errors.custom', ['message' => 'Anda Bukan Direktur'], 403);
        }
        return redirect('/');
        
        // Jika bukan admin, arahkan ke halaman lain
         // Ganti dengan kode status atau rute yang sesuai
    }
}
