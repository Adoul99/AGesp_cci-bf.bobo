<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        // Candidat → espace personnel de suivi
        if ($user && $user->role === 'candidat') {
            return redirect()->route('candidat.espace'); // → /mon-espace
        }

        // Admin / moniteur / superadmin → tableau de bord
        return redirect()->intended(config('fortify.home', '/dashboard')); // → /dashboard
    }
}
