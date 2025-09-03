<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Déterminer si l'utilisateur peut créer un commentaire.
     */
    public function create(User $user): bool
    {
        return $user !== null; // tout user connecté
    }

    /**
     * Déterminer si l'utilisateur peut mettre à jour un commentaire.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->hasRole('admin');
    }

    /**
     * Déterminer si l'utilisateur peut supprimer un commentaire.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->hasRole('admin');
    }
}
