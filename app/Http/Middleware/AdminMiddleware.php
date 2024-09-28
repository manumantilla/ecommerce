<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado y si es un administrador
        if (Auth::check() && Auth::user()->tipo == 'admin') {
            return $next($request);
        }
        
        // Si no es administrador, redirigir al home con un mensaje de error
        return redirect('/')->with('error', 'Acceso Denegado, Solo los administradores pueden entrar');
    }
}
