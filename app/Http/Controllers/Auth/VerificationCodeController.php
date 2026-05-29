<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\CodeVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class VerificationCodeController extends Controller
{
    /**
     * Génère et envoie un code de vérification par email
     */
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        // Vérifier que l'email n'existe pas déjà
        if (User::where('email', $request->email)->exists()) {
            return response()->json(['success' => false, 'message' => 'Cet email est déjà enregistré.'], 422);
        }

        // Générer un code aléatoire à 6 chiffres
        $code = rand(100000, 999999);

        // Stocker le code en cache pendant 10 minutes
        Cache::put('verification_code_' . $request->email, $code, now()->addMinutes(10));

        try {
            // Utiliser Notification::send() pour envoyer un email sans utilisateur sauvegardé
            Notification::route('mail', $request->email)
                ->notify(new CodeVerification($code));
            
            return response()->json(['success' => true, 'message' => 'Code envoyé par email.'], 200);
        } catch (\Exception $e) {
            Log::error('Erreur envoi code: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erreur lors de l\'envoi du code: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Vérifie le code saisi par l'utilisateur
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255'],
            'code'  => ['required', 'string', 'size:6', 'regex:/^[0-9]{6}$/'],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        // Récupérer le code stocké en cache
        $storedCode = Cache::get('verification_code_' . $request->email);

        if (!$storedCode) {
            return response()->json(['success' => false, 'message' => 'Code expiré. Demandez un nouveau code.'], 422);
        }

        if ($storedCode != $request->code) {
            return response()->json(['success' => false, 'message' => 'Code incorrect.'], 422);
        }

        // Stocker un token pour indiquer que cet email est vérifié
        Cache::put('email_verified_' . $request->email, true, now()->addMinutes(10));

        // Supprimer le code
        Cache::forget('verification_code_' . $request->email);

        return response()->json(['success' => true, 'message' => 'Email vérifié avec succès.'], 200);
    }
}
