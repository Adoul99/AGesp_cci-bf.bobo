<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->unsignedBigInteger('categoriePermis_id')->nullable()->after('candidat_id');
            $table->foreign('categoriePermis_id')->references('id')->on('categorie_permis')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->dropForeign(['categoriePermis_id']);
            $table->dropColumn('categoriePermis_id');
        });
    }
};