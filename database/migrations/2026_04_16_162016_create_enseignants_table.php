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
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
               $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nom');
            $table->string('prenom');
            $table->enum("grade",["Assistant","Maitre-Assistant","Professeur"]);
            $table->enum("statut",["Permanent","Vacataire"]);
            $table->string("departement");
            $table->decimal("taux_horaire", 10, 2)->default(0);
            $table->string("email")->unique();
            $table->string("telephone")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignants');
    }
};
