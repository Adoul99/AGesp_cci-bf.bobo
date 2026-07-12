<?php

// ══════════════════════════════════════════════════════════════
// app/Http/Middleware/Staff.php
// Regroupe tout le personnel back-office (admin, moniteur, secrétaire)
// pour les pages communes : tableau de bord, alertes.
// ══════════════════════════════════════════════════════════════

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Staff
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (in_array($user->role, ['admin', 'superadmin', 'moniteur', 'secretaire'])) {
            return $next($request);
        }

        if ($user->role === 'candidat') {
            return redirect()->route('candidat.espace');
        }

        abort(403, 'Accès non autorisé.');
    }
}
