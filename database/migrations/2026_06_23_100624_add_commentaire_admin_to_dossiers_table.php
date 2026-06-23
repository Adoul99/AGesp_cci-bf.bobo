<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Permet à l'administration de laisser un message au candidat
     * (motif de rejet, ou simple confirmation) lorsqu'elle valide ou
     * rejette le dossier. Ce message est affiché dans l'espace candidat.
     */
    public function up(): void
    {
        Schema::table('dossiers', function (Blueprint $table) {
            $table->text('commentaireAdmin')->nullable()->after('statutDossier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dossiers', function (Blueprint $table) {
            $table->dropColumn('commentaireAdmin');
        });
    }
};