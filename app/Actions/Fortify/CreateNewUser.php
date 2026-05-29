<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Notifications\CodeVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input): User
    {
        // ── Validation : Téléphone facultatif, Email obligatoire ──
        Validator::make($input, [
            'name'      => ['required', 'string', 'max:100'],
            'prenom'    => ['required', 'string', 'max:100'],
            'telephone' => ['nullable', 'string', 'min:8', 'max:20', 'unique:users,telephone', 'regex:/^[0-9]+$/'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'confirmed', Password::defaults()],
        ], [
            'name.required'      => 'Le nom est obligatoire.',
            'prenom.required'    => 'Le prénom est obligatoire.',
            'email.required'     => 'L\'adresse e-mail est obligatoire.',
            'email.unique'       => 'Cette adresse e-mail est déjà utilisée.',
            'telephone.unique'   => 'Ce numéro de téléphone est déjà utilisé.',
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ])->validate();

        // ── Création de l'utilisateur ────────────────────────────
        // On génère le code AVANT la création pour pouvoir le stocker
        $code = rand(100000, 999999);

        $user = User::create([
            'name'              => strtoupper(trim($input['name'])) . ' ' . trim($input['prenom']),
            'prenom'            => trim($input['prenom']),
            'telephone'         => !empty($input['telephone']) ? trim($input['telephone']) : null,
            'email'             => trim($input['email']),
            'password'          => Hash::make($input['password']),
            'role'              => 'candidat',
            'verification_code' => $code, // Assurez-vous d'avoir cette colonne dans votre BDD
        ]);

        // ── Envoi par Mail ──────────────────────────────────────
        $user->notify(new CodeVerification($code));

        return $user;
    }
}