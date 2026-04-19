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
        Schema::create('parametre_systemes', function (Blueprint $table) {
            $table->id();
            $table->string('cle')->unique(); // ex:seuil_heure_complementaire
            $table->text('valeur');
            $table->string('description')->nullable();
            $table->string("groupe")->default("general");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametre_systemes');
    }
};
