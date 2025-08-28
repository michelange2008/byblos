<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    // Liste des utilisateurs
    public function index()
    {
        $users = User::withCount([
            'books as books_added_count',
            'downloads as downloads_count'
        ])->with('roles')->get();

        return view('users.index', compact('users'));
    }

    // Formulaire d'édition
    public function edit(User $user)
    {
        $roles = \App\Models\Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    // Mise à jour d'un utilisateur
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'roles' => 'array'
        ]);

        $user->update($request->only('name', 'email'));

        // Mise à jour des rôles
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour');
    }


    // Suppression d'un utilisateur
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé');
    }

    function create()
    {
        return View('users.add');    
    }

    function store(Request $request)
    {
        // 1️⃣ Validation des champs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8', // password_confirmation attendu
        ]);

        // 2️⃣ Création de l'utilisateur
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 3️⃣ Redirection avec message de succès
        return redirect()->route('books.index')
                        ->with('success', 'Utilisateur créé avec succès !');
        
    }
}
