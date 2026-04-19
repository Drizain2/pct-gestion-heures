<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parametre_calcules', function (Blueprint $table) {
            $table->id();
            $table->enum('niveau_complexite', ['niveau_1', 'niveau_2', 'niveau_3']);
            $table->text("description")->nullable();
            $table->decimal('coefficient_creation', 5, 4);
            $table->decimal('coefficient_mise_a_jour', 5, 4);

            $table->timestamps();

            // Combinaison unique 
            $table->unique("niveau_complexite");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametre_calcules');
    }
};
