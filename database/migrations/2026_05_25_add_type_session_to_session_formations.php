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
        Schema::table('session_formations', function (Blueprint $table) {
            $table->unsignedBigInteger('typeSession_id')->nullable()->after('groupe_id');
            $table->foreign('typeSession_id')->references('id')->on('type_sessions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_formations', function (Blueprint $table) {
            $table->dropForeign(['typeSession_id']);
            $table->dropColumn('typeSession_id');
        });
    }
};
