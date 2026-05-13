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
        Schema::create('formations', function (Blueprint $table) {
    $table->id();
    $table->date('dateDebut');
    $table->date('dateFin');
    $table->enum('typeFormation', ['theorique', 'pratique', 'mixte']);
    $table->string('lieu')->nullable();
    $table->unsignedBigInteger('moniteur_id')->nullable();
$table->unsignedBigInteger('vehicule_id')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
