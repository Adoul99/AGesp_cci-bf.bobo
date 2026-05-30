<?php

// ══════════════════════════════════════════════════════════════
// app/Http/Responses/RegisterResponse.php
//
// Surcharge la réponse de register de Fortify.
// Redirige vers /s-inscrire au lieu de /dashboard.
// ══════════════════════════════════════════════════════════════

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Après register → toujours rediriger vers /s-inscrire
     * pour que le candidat complète son inscription.
     */
    public function toResponse($request)
    {
        return redirect('/s-inscrire');
    }
}
