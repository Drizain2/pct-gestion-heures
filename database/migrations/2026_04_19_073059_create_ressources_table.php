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
        Schema::create('ressources', function (Blueprint $table) {
            $table->id();
            $table->foreignId("sequence_id")->constrained("sequences")->onDelete("cascade");
            $table->foreignId("enseignant_id")->constrained("enseignants")->onDelete("cascade");
            $table->string("titre");
            $table->enum(
                "type",
                [
                    "contenu_textuel",
                    "video",
                    "document",
                    "quiz",
                    "activite_interactive",
                    "evaluation"
                ]
            );
            $table->enum("complexite", ["niveau_1", "niveau_2", "niveau_3"]);
            $table->text("description")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ressources');
    }
};
