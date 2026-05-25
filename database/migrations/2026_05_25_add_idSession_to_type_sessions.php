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
        Schema::table('type_sessions', function (Blueprint $table) {
            $table->string('idSession')->unique()->after('id');
            // Rename créneau to creneau for consistency
            if (Schema::hasColumn('type_sessions', 'créneau')) {
                $table->renameColumn('créneau', 'creneau');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('type_sessions', function (Blueprint $table) {
            $table->dropColumn('idSession');
            if (Schema::hasColumn('type_sessions', 'creneau')) {
                $table->renameColumn('creneau', 'créneau');
            }
        });
    }
};
