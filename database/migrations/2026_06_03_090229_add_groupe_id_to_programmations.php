<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Vérifie que la colonne n'existe pas déjà avant de l'ajouter
        if (!Schema::hasColumn('programmations', 'groupe_id')) {
            Schema::table('programmations', function (Blueprint $table) {
                $table->unsignedBigInteger('groupe_id')->nullable()->after('moniteur_id');
                $table->foreign('groupe_id')
                      ->references('id')
                      ->on('groupes')
                      ->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('programmations', 'groupe_id')) {
            Schema::table('programmations', function (Blueprint $table) {
                $table->dropForeign(['groupe_id']);
                $table->dropColumn('groupe_id');
            });
        }
    }
};
