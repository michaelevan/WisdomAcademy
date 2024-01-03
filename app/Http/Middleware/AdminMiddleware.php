<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has("login")) { // jika blm login
            return redirect('/')->withErrors("Login Terlebih Dahulu!");
        }
        else {
            if(session()->get("login")->role == "anak") {
                return redirect('anak/pengumuman');
            }
            else if(session()->get("login")->role == "guru") {
                return redirect('guru/kelas');
            }
            else if(session()->get("login")->role == "orangtua") {
                return redirect('orangTua/agenda');
            }
        }
        return $next($request);
    }
}
