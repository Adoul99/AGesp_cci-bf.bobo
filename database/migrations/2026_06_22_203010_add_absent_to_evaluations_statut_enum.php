<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * On modifie l'ENUM via une requête SQL brute car Laravel ne sait pas
     * altérer un ENUM avec Schema::table()->enum(...)->change() sans
     * doctrine/dbal (non installé sur ce projet).
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE evaluations MODIFY statut ENUM('reussi', 'echoue', 'en_attente', 'absent') NOT NULL DEFAULT 'en_attente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // On repasse les évaluations 'absent' en 'en_attente' avant de retirer la valeur de l'ENUM
        DB::statement("UPDATE evaluations SET statut = 'en_attente' WHERE statut = 'absent'");
        DB::statement("ALTER TABLE evaluations MODIFY statut ENUM('reussi', 'echoue', 'en_attente') NOT NULL DEFAULT 'en_attente'");
    }
};