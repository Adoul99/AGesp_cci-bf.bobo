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
        // On vérifie si la table n'existe pas déjà pour éviter l'erreur
        if (!Schema::hasTable('recus')) {
            Schema::create('recus', function (Blueprint $table) {
                $table->id();
                $table->decimal('montant', 10, 2);
                $table->date('dateRecus');
                $table->unsignedBigInteger('paiement_id')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // On utilise le même nom que dans up()
        Schema::dropIfExists('recus');
    }
};