<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('examens', function (Blueprint $table) {
            // Type d'examen (Code / Créneau / Conduite) — indispensable pour savoir
            // quels candidats programmés doivent apparaître, et pour ne pas exclure
            // un candidat qui a déjà passé un AUTRE type d'examen.
            $table->foreignId('typeSession_id')->nullable()->after('libelle')
                  ->constrained('type_sessions')->nullOnDelete();

            // Date de fin retirée du formulaire (un examen se tient sur une seule
            // date en pratique) — on la garde en base par sécurité mais optionnelle.
            $table->date('dateFin')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('examens', function (Blueprint $table) {
            $table->dropForeign(['typeSession_id']);
            $table->dropColumn('typeSession_id');
            $table->date('dateFin')->nullable(false)->change();
        });
    }
};
