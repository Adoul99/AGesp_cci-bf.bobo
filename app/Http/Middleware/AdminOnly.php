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

        // Si admin → laisse passer
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Si candidat → redirige vers son espace personnel
        if ($user->role === 'candidat') {
            return redirect()->route('candidat.espace');
        }

        // Si moniteur → redirige vers son propre espace
        if ($user->role === 'moniteur') {
            return redirect()->route('moniteur.espace');
        }

        // Si superviseur → redirige vers le dashboard (elle n'a pas accès à cette section admin-only)
        if ($user->role === 'superviseur') {
            return redirect()->route('dashboard');
        }

        // Tout autre cas → accès refusé
        abort(403, 'Accès non autorisé.');
    }
}