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
        Schema::create('session_formations', function (Blueprint $table) {
    $table->id();
    $table->date('dateDebut');
    $table->enum('statutSession', ['ouvert', 'ferme', 'annule'])->default('ouvert');
    $table->unsignedBigInteger('vehicule_id')->nullable();
    $table->unsignedBigInteger('evaluation_id')->nullable();
    $table->unsignedBigInteger('groupe_id')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_formations');
    }
};
