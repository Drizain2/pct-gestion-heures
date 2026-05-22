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
        Schema::table('activites', function (Blueprint $table) {
            $table->foreignId('ressource_id')
                ->nullable()
                ->after('cours_id')
                ->constrained('ressources')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('activites', function (Blueprint $table) {
            $table->dropForeign(['ressource_id']);
            $table->dropColumn('ressource_id');
        });
    }
};
