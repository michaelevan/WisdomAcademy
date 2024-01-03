<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogoutMiddleware
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
        if (session()->has('login')) {
            if(session()->get('login')->role == "admin") {
                return redirect("/admin/listPendaftaran")->withErrors('Anda Harus Logout Terlebih Dahulu');
            }
            else if(session()->get('login')->role == "guru") {
                return redirect("/guru/kelas")->withErrors('Anda Harus Logout Terlebih Dahulu');
            }
            else if(session()->get('login')->role == "anak") {
                return redirect("/anak/pengumuman")->withErrors('Anda Harus Logout Terlebih Dahulu');
            }
            else if(session()->get('login')->role == "orangTua") {
                return redirect("/orangTua/agenda")->withErrors('Anda Harus Logout Terlebih Dahulu');
            }
        }
        return $next($request);
    }
}
