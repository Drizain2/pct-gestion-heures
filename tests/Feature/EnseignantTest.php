<?php

use App\Models\Enseignant;
use App\Models\User;
use Spatie\Permission\Models\Role;

it('reuses an existing user when creating an enseignant with the same email', function () {
    Role::create(['name' => 'enseignant']);

    $existingUser = User::factory()->create([
        'email' => 'enseignant@example.com',
    ]);

    $this->withoutMiddleware();

    $response = $this->actingAs(User::factory()->create())
        ->post(route('enseignants.store'), [
            'nom' => 'Doe',
            'prenom' => 'Jean',
            'grade' => 'Assistant',
            'statut' => 'Permanent',
            'departement' => 'Informatique',
            'email' => 'enseignant@example.com',
            'telephone' => '+22501234567',
            'taux_horaire' => 10000,
        ]);

    $response->assertRedirect(route('enseignants.index'));

    expect(User::where('email', 'enseignant@example.com')->count())->toBe(1);
    expect(Enseignant::where('email', 'enseignant@example.com')->count())->toBe(1);
    expect($existingUser->fresh()->enseignant)->not->toBeNull();
    expect($existingUser->fresh()->hasRole('enseignant'))->toBeTrue();
});
