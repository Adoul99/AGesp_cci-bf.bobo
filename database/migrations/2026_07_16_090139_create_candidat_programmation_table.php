<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table pivot manquante entre candidats et programmations.
     * Le modèle Programmation::candidats() l'attendait déjà
     * (belongsToMany(Candidat::class, 'candidat_programmation')),
     * mais elle n'avait jamais été créée en base — d'où l'erreur
     * "Base table or view not found: candidat_programmation".
     */
    public function up(): void
    {
        Schema::create('candidat_programmation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidat_id');
            $table->unsignedBigInteger('programmation_id');
            $table->timestamps();

            $table->foreign('candidat_id')->references('id')->on('candidats')->onDelete('cascade');
            $table->foreign('programmation_id')->references('id')->on('programmations')->onDelete('cascade');

            // Un candidat ne peut être ajouté qu'une seule fois à la même programmation
            $table->unique(['candidat_id', 'programmation_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidat_programmation');
    }
};