<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Middleware untuk memastikan user adalah Admin.
     * Mahasiswa hanya boleh mengakses: dashboard, jadwal (view), krs (view + create).
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak. Halaman ini hanya dapat diakses oleh Admin.');
        }

        return $next($request);
    }
}
