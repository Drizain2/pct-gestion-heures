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
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->string("intitule");
            $table->string("filiere");
            $table->enum("niveau", ["L1", "L2", "L3", "M1", "M2", ]);
            $table->enum("semestre", ["S1", "S2", "S3", "S4", "S5","S6","S7","S8","S9","S10" ]);
            $table->integer("nombre_heures");
            $table->integer("nombre_credits");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours');
    }
};
