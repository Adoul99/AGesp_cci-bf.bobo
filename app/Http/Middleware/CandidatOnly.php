<?php

// ══════════════════════════════════════════════════════════════
// app/Http/Middleware/CandidatOnly.php
// ══════════════════════════════════════════════════════════════

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CandidatOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Si admin → redirige vers le dashboard
        if (in_array($user->role, ['admin', 'moniteur', 'superadmin', 'superviseur'])) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
