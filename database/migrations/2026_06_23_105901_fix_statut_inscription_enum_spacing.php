<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * La table inscriptions a été créée avec l'ENUM ['en attente', 'actif',
     * 'abandon', 'ajourne'] (avec un ESPACE), alors que tout le code de
     * l'application (InscriptionController, vues) utilise 'en_attente'
     * (avec un underscore). Cette migration harmonise les deux :
     * 1. On élargit temporairement l'ENUM pour accepter les deux variantes.
     * 2. On corrige les lignes existantes encore au format avec espace.
     * 3. On retire l'ancienne variante de l'ENUM, qui n'est plus utilisée.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE inscriptions MODIFY statutInscription ENUM('en attente', 'en_attente', 'actif', 'abandon', 'ajourne') NOT NULL DEFAULT 'en_attente'");

        DB::statement("UPDATE inscriptions SET statutInscription = 'en_attente' WHERE statutInscription = 'en attente' OR statutInscription = ''");

        DB::statement("ALTER TABLE inscriptions MODIFY statutInscription ENUM('en_attente', 'actif', 'abandon', 'ajourne') NOT NULL DEFAULT 'en_attente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE inscriptions MODIFY statutInscription ENUM('en attente', 'actif', 'abandon', 'ajourne') NOT NULL DEFAULT 'en attente'");

        DB::statement("UPDATE inscriptions SET statutInscription = 'en attente' WHERE statutInscription = 'en_attente'");
    }
};