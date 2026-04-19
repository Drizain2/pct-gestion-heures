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
        Schema::create('cours_enseignant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
            $table->foreignId('enseignant_id')->constrained('enseignants')->onDelete('cascade');
            $table->string("annee_academique");
            $table->timestamps();

            // Un enseignant ne peut enseigner qu'une seule fois un cours
            $table->unique(['cours_id', 'enseignant_id', 'annee_academique']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours_enseignant');
    }
};
