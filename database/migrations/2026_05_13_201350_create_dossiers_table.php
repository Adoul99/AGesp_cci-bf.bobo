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
        Schema::create('dossiers', function (Blueprint $table) {
    $table->id();
    $table->string('nomDossier');
    $table->text('description')->nullable();
    $table->date('dateDepot');
    $table->enum('statutDossier', ['en_attente', 'valide', 'rejete'])->default('en_attente');
    $table->foreignId('candidat_id')->constrained('candidats')->onDelete('cascade');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossiers');
    }
};
