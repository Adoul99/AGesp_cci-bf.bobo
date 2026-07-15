<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            if (!Schema::hasColumn('evaluations', 'candidat_id')) {
                $table->foreignId('candidat_id')
                      ->nullable()
                      ->after('id')
                      ->constrained('candidats')
                      ->nullOnDelete();
            }

            if (!Schema::hasColumn('evaluations', 'observation')) {
                $table->text('observation')->nullable()->after('resultat');
            }
        });
    }

    public function down(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            if (Schema::hasColumn('evaluations', 'candidat_id')) {
                $table->dropForeign(['candidat_id']);
                $table->dropColumn('candidat_id');
            }
            if (Schema::hasColumn('evaluations', 'observation')) {
                $table->dropColumn('observation');
            }
        });
    }
};