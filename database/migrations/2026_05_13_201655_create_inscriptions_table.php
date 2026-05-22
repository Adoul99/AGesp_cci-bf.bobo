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
            
            // Ajout du champ référence (Unique et indexé pour des recherches ultra-rapides)
            $table->string('reference', 20)->unique()->nullable(); 
            
            $table->date('dateInscription');
            
            // Harmonisation de l'ENUM avec l'ajout de 'en attente' pour les inscriptions publiques
            $table->enum('statutInscription', ['en attente', 'actif', 'abandon', 'ajourne'])->default('en attente');
            
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