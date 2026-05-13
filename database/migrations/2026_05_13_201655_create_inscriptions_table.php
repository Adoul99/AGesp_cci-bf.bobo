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
        Schema::create('inscriptions', function (Blueprint $table) {
    $table->id();
    $table->date('dateInscription');
    $table->enum('statutInscription', ['actif', 'abandon', 'ajourne'])->default('actif');
    $table->date('dataDebut_formation')->nullable();
    $table->foreignId('candidat_id')->constrained('candidats')->onDelete('cascade');
    $table->unsignedBigInteger('paiement_id')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
