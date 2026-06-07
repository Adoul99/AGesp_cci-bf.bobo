<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recus', function (Blueprint $table) {
            // Identifiant style CNIB : ex B1234567
            $table->string('numero_recu', 20)->unique()->nullable()->after('id');
            // Motif / libellé du paiement
            $table->string('recus_paiement')->nullable()->after('paiement_id');
        });
    }

    public function down(): void
    {
        Schema::table('recus', function (Blueprint $table) {
            $table->dropColumn(['numero_recu', 'recus_paiement']);
        });
    }
};
