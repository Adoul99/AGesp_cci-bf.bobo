<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input): User
    {
        Validator::make($input, [
            'name'      => ['required', 'string', 'max:255'],
            'prenom'    => ['nullable', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone' => ['required', 'string', 'min:8', 'max:20', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'telephone.min'      => 'Le numéro doit contenir au moins 8 chiffres.',
            'telephone.unique'   => 'Ce numéro de téléphone est déjà associé à un compte existant.',
        ])->validate();

        return User::create([
            'name'      => $input['name'],
            'prenom'    => $input['prenom'] ?? null,
            'telephone' => $input['telephone'],
            'email'     => $input['email'],
            'password'  => Hash::make($input['password']),
            'role'      => 'candidat',
        ]);
    }
}