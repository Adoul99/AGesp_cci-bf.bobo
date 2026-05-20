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
        Schema::create('candidat_programmation', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('candidat_id');
    $table->unsignedBigInteger('programmation_id');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidat_programmation');
    }
};
