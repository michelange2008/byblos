<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    function add()
    {
        return View('addUser');    
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
