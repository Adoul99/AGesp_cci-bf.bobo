<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('notes_evaluation', function (Blueprint $table) {
        $table->id();
        $table->foreignId('candidat_id')->constrained('candidats')->onDelete('cascade');
        $table->foreignId('evaluation_id')->constrained('evaluations')->onDelete('cascade');
        $table->date('date_note');
        $table->decimal('note', 5, 2); // note sur 30 par exemple
        $table->string('observation')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes_evaluation');
    }
};
