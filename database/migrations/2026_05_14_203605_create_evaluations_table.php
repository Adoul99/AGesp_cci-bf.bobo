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
       Schema::create('evaluations', function (Blueprint $table) {
    $table->id();
    $table->date('dateEvaluation');
    $table->string('resultat');
    $table->enum('statut', ['reussi', 'echoue', 'en_attente'])->default('en_attente');
    $table->unsignedBigInteger('moniteur_id')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
