<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        // Si c'est un candidat, on le renvoie à l'inscription publique
        if ($user && $user->role === 'candidat') {
            return redirect()->route('inscription.public');
        }

        // Sinon, on le laisse aller au dashboard (admin/personnel)
        return redirect()->intended(config('fortify.home', '/dashboard'));
    }
}