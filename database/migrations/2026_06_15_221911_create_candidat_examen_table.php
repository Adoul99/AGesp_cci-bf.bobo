<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidat_examen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidat_id');
            $table->unsignedBigInteger('examen_id');
            $table->string('resultat')->nullable(); // Admis, Ajourné, En attente
            $table->decimal('note', 5, 2)->nullable();
            $table->string('observation')->nullable();
            $table->timestamps();

            $table->foreign('candidat_id')->references('id')->on('candidats')->onDelete('cascade');
            $table->foreign('examen_id')->references('id')->on('examens')->onDelete('cascade');
            $table->unique(['candidat_id', 'examen_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidat_examen');
    }
};
