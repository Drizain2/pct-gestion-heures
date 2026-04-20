<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enseignant_id')->constrained('enseignants')->cascadeOnDelete();
            $table->foreignId('ressource_id')->constrained('ressources')->cascadeOnDelete();
            $table->enum('type_action', ['creation', 'mise_a_jour']);
            $table->decimal('heures_calculees', 5, 2)->default(0);
            $table->date('date_activite');
            $table->text('commentaire')->nullable();
            $table->enum('statut', ['en_attente', 'validee', 'rejetee'])->default('en_attente');
            $table->foreignId('validee_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('validee_le')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activites');
    }
};
