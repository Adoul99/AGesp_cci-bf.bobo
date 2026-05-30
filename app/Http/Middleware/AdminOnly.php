<?php

// ══════════════════════════════════════════════════════════════
// app/Http/Middleware/AdminOnly.php
// ══════════════════════════════════════════════════════════════

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Si pas connecté → login
        if (!$user) {
            return redirect()->route('login');
        }

        // Si candidat → redirige vers son espace personnel
        if ($user->role === 'candidat') {
            return redirect()->route('candidat.espace');
        }

        // Si admin ou moniteur → laisse passer
        return $next($request);
    }
}
