<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter moniteur_id à session_formations
        Schema::table('session_formations', function (Blueprint $table) {
            $table->unsignedBigInteger('moniteur_id')->nullable()->after('groupe_id');
            $table->foreign('moniteur_id')->references('id')->on('moniteurs')->onDelete('set null');
        });

        // Table pivot : session_candidat (présence/absence + note par candidat par session)
        Schema::create('session_candidat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_formation_id');
            $table->unsignedBigInteger('candidat_id');
            $table->boolean('absent')->default(false);
            $table->decimal('note', 5, 2)->nullable(); // note sur 30
            $table->string('observation')->nullable();
            $table->timestamps();

            $table->foreign('session_formation_id')->references('id')->on('session_formations')->onDelete('cascade');
            $table->foreign('candidat_id')->references('id')->on('candidats')->onDelete('cascade');
            $table->unique(['session_formation_id', 'candidat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_candidat');
        Schema::table('session_formations', function (Blueprint $table) {
            $table->dropForeign(['moniteur_id']);
            $table->dropColumn('moniteur_id');
        });
    }
};