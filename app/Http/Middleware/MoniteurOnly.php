<?php

// ══════════════════════════════════════════════════════════════
// app/Http/Middleware/MoniteurOnly.php
// ══════════════════════════════════════════════════════════════

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MoniteurOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Seul un moniteur peut accéder à son propre espace
        if ($user->role === 'moniteur') {
            return $next($request);
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'candidat') {
            return redirect()->route('candidat.espace');
        }

        if ($user->role === 'secretaire') {
            return redirect()->route('dashboard');
        }

        abort(403, 'Accès non autorisé.');
    }
}