<?php

namespace App\Policies;

use App\Models\Activite;
use App\Models\User;

class ActivitePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Activite $activite): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('secretaire')) {
            return true;
        }

        return $user->hasRole('enseignant') && $user->enseignant?->id === $activite->enseignant_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Activite $activite): bool
    {
        return false;
    }

    public function delete(User $user, Activite $activite): bool
    {
        if ($activite->statut === 'validee') {
            return false;
        }

        if ($user->hasRole('admin') || $user->hasRole('secretaire')) {
            return true;
        }

        return $user->hasRole('enseignant') && $user->enseignant?->id === $activite->enseignant_id;
    }

    public function restore(User $user, Activite $activite): bool
    {
        return false;
    }

    public function forceDelete(User $user, Activite $activite): bool
    {
        return false;
    }
}
