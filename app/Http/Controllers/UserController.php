<?php

// ══════════════════════════════════════════════════════════════
// app/Http/Controllers/UserController.php
// ══════════════════════════════════════════════════════════════

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ── Liste des utilisateurs ────────────────────────────────
    public function index(Request $request)
    {
        $query = User::query();

        // Filtre par rôle
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Recherche par nom ou email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('telephone', 'like', "%$search%");
            });
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    // ── Formulaire création utilisateur ──────────────────────
    public function create()
    {
        return view('admin.users.create');
    }

    // ── Créer un utilisateur ──────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:100'],
            'prenom'    => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'telephone' => ['nullable', 'string', 'max:20', 'unique:users,telephone'],
            'role'      => ['required', 'in:admin,moniteur,candidat'],
            'password'  => ['required', 'min:8', 'confirmed'],
        ], [
            'name.required'     => 'Le nom est obligatoire.',
            'prenom.required'   => 'Le prénom est obligatoire.',
            'email.required'    => 'L\'email est obligatoire.',
            'email.unique'      => 'Cet email est déjà utilisé.',
            'telephone.unique'  => 'Ce téléphone est déjà utilisé.',
            'role.required'     => 'Le rôle est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min'      => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed'=> 'Les mots de passe ne correspondent pas.',
        ]);

        User::create([
            'name'      => strtoupper(trim($request->name)) . ' ' . trim($request->prenom),
            'prenom'    => trim($request->prenom),
            'email'     => trim($request->email),
            'telephone' => trim($request->telephone),
            'role'      => $request->role,
            'password'  => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'Utilisateur créé avec succès.');
    }

    // ── Modifier le rôle d'un utilisateur ────────────────────
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'in:admin,moniteur,candidat'],
        ]);

        // Empêcher de changer son propre rôle
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', "Rôle de {$user->name} changé en « {$request->role} » avec succès.");
    }

    // ── Supprimer un utilisateur ──────────────────────────────
    public function destroy(User $user)
    {
        // Empêcher de se supprimer soi-même
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}
