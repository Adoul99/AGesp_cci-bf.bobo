<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmailForInscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier que l'utilisateur est authentifié
        if (!$request->user()) {
            return redirect()->route('login')
                ->with('status', __('Please create an account first to register for a training.'));
        }

        // Vérifier que l'email est confirmé
        if (!$request->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')
                ->with('status', __('Please verify your email address to register for a training.'));
        }

        return $next($request);
    }
}
