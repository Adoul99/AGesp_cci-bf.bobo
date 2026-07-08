<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('session_candidat', function (Blueprint $table) {
            // Mention utilisée pour les sessions Créneau / Conduite
            // (le champ 'note' reste utilisé uniquement pour les sessions Code)
            $table->enum('mention', ['bien', 'passable', 'mediocre'])
                  ->nullable()
                  ->after('note');
        });
    }

    public function down(): void
    {
        Schema::table('session_candidat', function (Blueprint $table) {
            $table->dropColumn('mention');
        });
    }
};
