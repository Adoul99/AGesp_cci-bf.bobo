<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Donner un numéro unique à chaque user sans téléphone
        $users = DB::table('users')->whereNull('telephone')->get();
        foreach ($users as $user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['telephone' => 'TEL-' . $user->id]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('telephone', 20)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telephone', 20)->nullable()->change();
        });
    }
};