<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ajouter la FK nullable (si pas déjà présente)
        if (! Schema::hasColumn('cours_enseignant', 'annee_academique_id')) {
            Schema::table('cours_enseignant', function (Blueprint $table) {
                $table->foreignId('annee_academique_id')
                    ->nullable()
                    ->after('enseignant_id')
                    ->constrained('annee_academiques')
                    ->nullOnDelete();
            });
        }

        // 2. Remplir depuis le libellé existant
        DB::statement('
            UPDATE cours_enseignant ce
            INNER JOIN annee_academiques aa ON aa.libelle = ce.annee_academique
            SET ce.annee_academique_id = aa.id
        ');

        // 3. Créer le nouvel index unique AVANT de supprimer l'ancien
        // (MySQL refuse de supprimer un index qui couvre des colonnes FK sans qu'un autre index les couvre)
        Schema::table('cours_enseignant', function (Blueprint $table) {
            $table->unique(['cours_id', 'enseignant_id', 'annee_academique_id'], 'ce_unique_annee_fk');
        });

        // 4. Maintenant on peut supprimer l'ancien index unique
        Schema::table('cours_enseignant', function (Blueprint $table) {
            $table->dropUnique(['cours_id', 'enseignant_id', 'annee_academique']);
        });

        // 5. Supprimer l'ancienne colonne string
        Schema::table('cours_enseignant', function (Blueprint $table) {
            $table->dropColumn('annee_academique');
        });
    }

    public function down(): void
    {
        Schema::table('cours_enseignant', function (Blueprint $table) {
            $table->dropUnique('ce_unique_annee_fk');
        });

        Schema::table('cours_enseignant', function (Blueprint $table) {
            $table->string('annee_academique')->nullable()->after('enseignant_id');
        });

        DB::statement('
            UPDATE cours_enseignant ce
            INNER JOIN annee_academiques aa ON aa.id = ce.annee_academique_id
            SET ce.annee_academique = aa.libelle
        ');

        Schema::table('cours_enseignant', function (Blueprint $table) {
            $table->dropForeign(['annee_academique_id']);
            $table->dropColumn('annee_academique_id');
            $table->unique(['cours_id', 'enseignant_id', 'annee_academique']);
        });
    }
};
