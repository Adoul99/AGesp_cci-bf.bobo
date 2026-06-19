<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE examens MODIFY statutExamen ENUM('ouvert','en_attente','termine') NOT NULL DEFAULT 'ouvert'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE examens MODIFY statutExamen ENUM('en_attente','admis','ajourne','abandon') NOT NULL DEFAULT 'en_attente'");
    }
};