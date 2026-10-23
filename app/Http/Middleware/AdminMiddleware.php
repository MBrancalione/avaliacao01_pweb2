<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // CORREÇÃO: bloqueia quem não está logado ou não é admin
        if (!$request->user() || !$request->user()->is_admin) {
            abort(403, 'Acesso restrito a administradores.');
        }
        return $next($request);
    }
}