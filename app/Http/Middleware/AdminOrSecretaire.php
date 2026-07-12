<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrSecretaire
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (in_array($user->role, ['admin', 'superadmin', 'secretaire'])) {
            return $next($request);
        }

        if ($user->role === 'candidat') {
            return redirect()->route('candidat.espace');
        }

        if ($user->role === 'moniteur') {
            return redirect()->route('moniteur.espace');
        }

        abort(403, 'Accès non autorisé.');
    }
}
