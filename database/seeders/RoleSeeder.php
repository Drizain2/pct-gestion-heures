<?php

namespace Database\Seeders;

use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Réinitialiser le cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Création des rôles
        $admin = Role::create(["name"=>"admin"]);
        $secretaire = Role::create(["name"=>"secretaire"]);
        $enseignant = Role::create(["name"=>"enseignant"]);

        //Administrateur
        User::create([
            "name"=>"Administrateur Test",
            "email"=>"admin@uvci.edu.ci",
            "password"=>"password"
        ])->assignRole($admin);

        //Secretaire
        User::create([
            "name"=>"Secretaire Test",
            "email"=>"secretaire@uvci.edu.ci",
            "password"=>"password"
        ])->assignRole($secretaire);

        //Enseignant
       $enseignantTest= User::create([
            "name"=>"Enseignant Test",
            "email"=>"enseignant@uvci.edu.ci",
            "password"=>"password"
        ])->assignRole($enseignant);

        // creer le compte enseignant pour les enseignants
        Enseignant::create([
            "user_id"=>$enseignantTest->id,
            "nom"=>$enseignantTest->name,
            "prenom"=>$enseignantTest->name,
            "grade"=>"Professeur",
            "statut"=>"Permanent",
            "departement"=>"Informatique",
            "email"=>$enseignantTest->email,
            "telephone"=>"0000000000",
            "taux_horaire"=>5000
        ]);
    }
}
