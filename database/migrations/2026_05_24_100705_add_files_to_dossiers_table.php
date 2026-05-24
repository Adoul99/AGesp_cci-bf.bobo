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
        Schema::table('dossiers', function (Blueprint $table) {
            $table->string('cnib')->nullable();
            $table->string('photo_identite')->nullable();
            $table->string('certificat_medical')->nullable();
            $table->string('acte_naissance')->nullable();
            $table->string('recu_paiement')->nullable();
            $table->string('permis_c')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dossiers', function (Blueprint $table) {
            // On supprime les colonnes ajoutées si on annule la migration
            $table->dropColumn([
                'cnib', 
                'photo_identite', 
                'certificat_medical', 
                'acte_naissance', 
                'recu_paiement', 
                'permis_c'
            ]);
        });
    }
};