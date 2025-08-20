<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir n'importe quel livre.
     */
    public function viewAny(User $user)
    {
        return true; // tous les utilisateurs connectés peuvent voir la liste
    }

    /**
     * Détermine si l'utilisateur peut voir un livre spécifique.
     */
    public function view(User $user, Book $book)
    {
        return true; // tous les utilisateurs connectés peuvent voir
    }

    /**
     * Détermine si l'utilisateur peut créer un livre.
     */
    public function create(User $user)
    {
        return true; // tous les utilisateurs connectés peuvent créer un livre
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour un livre.
     */
    public function update(User $user, Book $book)
    {
        // Seul Michel peut modifier
        return $user->email === 'michelange@wanadoo.fr';
    }

    /**
     * Détermine si l'utilisateur peut supprimer un livre.
     */
    public function delete(User $user, Book $book)
    {
        // Seul Michel peut supprimer
        return $user->email === 'michelange@wanadoo.fr';
    }

    /**
     * Détermine si l'utilisateur peut restaurer un livre.
     */
    public function restore(User $user, Book $book)
    {
        return false; // pas utilisé
    }

    /**
     * Détermine si l'utilisateur peut forcer la suppression d'un livre.
     */
    public function forceDelete(User $user, Book $book)
    {
        return false; // pas utilisé
    }
}
