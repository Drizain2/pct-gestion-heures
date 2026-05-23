<?php

namespace Database\Seeders;

use App\Models\Activite;
use App\Models\AnneeAcademique;
use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\Ressource;
use App\Models\Sequence;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
         // appeler les autres seeder pour le systeme
        $this->call([
            ParametreSystemeSeeder::class,
            ParametreCalculeSeeder::class,
        ]);
        
        // 1. Rôles et permissions
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleSecretaire = Role::firstOrCreate(['name' => 'secretaire']);
        $roleEnseignant = Role::firstOrCreate(['name' => 'enseignant']);

        $permValider = Permission::firstOrCreate(['name' => 'valider_activite']);
        $permGerer = Permission::firstOrCreate(['name' => 'gerer_cours']);

        $roleAdmin->givePermissionTo([$permValider, $permGerer]);
        $roleSecretaire->givePermissionTo($permValider);

        // 2. Comptes fixes
        $admin = User::firstOrCreate(['email' => 'admin@uvci.edu.ci'], [
            'name' => 'Administrateur',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($roleAdmin);

        $secretaire = User::firstOrCreate(['email' => 'secretaire@uvci.edu.ci'], [
            'name' => 'Secrétaire',
            'password' => bcrypt('password'),
        ]);
        $secretaire->assignRole($roleSecretaire);

        // 3. Validateurs supplémentaires
        $validateurs = collect([$admin, $secretaire]);

        $admin1 = User::firstOrCreate(['email' => 'admin1@uvci.edu.ci'], [
            'name' => 'Koné Mamadou',
            'password' => bcrypt('password'),
        ]);
        $admin1->assignRole($roleAdmin);
        $validateurs->push($admin1);

        $admin2 = User::firstOrCreate(['email' => 'admin2@uvci.edu.ci'], [
            'name' => 'Traoré Ibrahima',
            'password' => bcrypt('password'),
        ]);
        $admin2->assignRole($roleAdmin);
        $validateurs->push($admin2);

        $sec2 = User::firstOrCreate(['email' => 'secretaire2@uvci.edu.ci'], [
            'name' => 'Coulibaly Aminata',
            'password' => bcrypt('password'),
        ]);
        $sec2->assignRole($roleSecretaire);
        $validateurs->push($sec2);

        // 4. Années académiques
        $anneesData = [
            ['libelle' => '2022-2023', 'date_debut' => '2022-10-01', 'date_fin' => '2023-07-31', 'active' => false],
            ['libelle' => '2023-2024', 'date_debut' => '2023-10-01', 'date_fin' => '2024-07-31', 'active' => false],
            ['libelle' => '2024-2025', 'date_debut' => '2024-10-01', 'date_fin' => '2025-07-31', 'active' => true],
        ];
        foreach ($anneesData as $data) {
            AnneeAcademique::firstOrCreate(['libelle' => $data['libelle']], $data);
        }
        $annees = AnneeAcademique::whereIn('libelle', ['2022-2023', '2023-2024', '2024-2025'])->get();

        // 5. 10 enseignants avec leurs comptes utilisateurs
        $enseignants = Enseignant::factory(10)->create();
        foreach ($enseignants as $enseignant) {
            $enseignant->user->assignRole($roleEnseignant);
            
        }

        // 6. 10 cours réalistes via factory, assignés à 1-3 enseignants par année académique
        $cours = Cours::factory(10)->create();
        foreach ($cours as $cour) {
            foreach ($enseignants->random(rand(1, 3)) as $enseignant) {
                foreach ($annees->shuffle()->take(rand(1, 2)) as $annee) {
                    try {
                        $cour->enseignants()->attach($enseignant->id, ['annee_academique_id' => $annee->id]);
                    } catch (\Illuminate\Database\QueryException $e) {
                        // Ignorer les doublons (contrainte unique cours/enseignant/année)
                    }
                }
            }
        }

        // 7. 12 séquences par cours (ordre fixe 1 à 12)
        foreach ($cours as $cour) {
            foreach (range(1, 12) as $ordre) {
                Sequence::factory()->pourCours($cour->id)->create(['ordre' => $ordre]);
            }
        }

        // 8. 10 ressources par séquence, enseignant aléatoire
        $sequences = Sequence::whereIn('cours_id', $cours->pluck('id'))->get();
        foreach ($sequences as $sequence) {
            for ($i = 0; $i < 10; $i++) {
                Ressource::factory()
                    ->pourSequence($sequence->id)
                    ->pourEnseignant($enseignants->random()->id)
                    ->create();
            }
        }

        // 9. 17 activités par enseignant
        foreach ($enseignants as $enseignant) {
            for ($k = 0; $k < 17; $k++) {
                Activite::factory()->create([
                    'enseignant_id' => $enseignant->id,
                    'cours_id' => $cours->random()->id,
                    'validee_par' => $validateurs->random()->id,
                ]);
            }
        }

       

        $this->command->info('✅ Seeding terminé avec succès !');
        $this->command->info('- Utilisateurs      : '.User::query()->count());
        $this->command->info('- Enseignants       : '.Enseignant::query()->count());
        $this->command->info('- Années académiques: '.AnneeAcademique::query()->count());
        $this->command->info('- Cours             : '.Cours::query()->count());
        $this->command->info('- Séquences         : '.Sequence::query()->count().' (12 par cours)');
        $this->command->info('- Ressources        : '.Ressource::query()->count().' (10 par séquence)');
        $this->command->info('- Activités         : '.Activite::query()->count().' (17 par enseignant)');
    }
}
