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
        Schema::create('paiements', function (Blueprint $table) {
    $table->id();
    $table->decimal('montant', 10, 2);
    $table->date('datePaiement');
    $table->enum('statut', ['paye', 'en_attente', 'annule'])->default('en_attente');
    $table->foreignId('candidat_id')->constrained('candidats')->onDelete('cascade');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
