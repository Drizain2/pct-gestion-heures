<?php

namespace App\Policies;

use App\Models\Ressource;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RessourcePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ressource $ressource): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'secretaire', 'enseignant']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ressource $ressource): bool
    {
        // Admin et secretaire peuvent tout modifier
        if ($user->hasAnyRole(['admin', 'secretaire'])) {
            return true;
        }

        // L'enseignant ne peut modifier que ses propres ressources
        return $user->hasRole('enseignant')
            && $ressource->enseignant_id == $user->enseignant?->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ressource $ressource): bool
    {
        // Admin et secretaire peuvent tout modifier
        if ($user->hasAnyRole(['admin', 'secretaire'])) {
            return true;
        }

        // L'enseignant ne peut modifier que ses propres ressources
        return $user->hasRole('enseignant')
            && $ressource->enseignant_id == $user->enseignant?->id;
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ressource $ressource): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ressource $ressource): bool
    {
        return false;
    }
}
