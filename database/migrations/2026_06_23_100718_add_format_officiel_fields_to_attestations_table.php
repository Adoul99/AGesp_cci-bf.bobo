<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Champs nécessaires pour reproduire le format officiel CFTRA :
     * civilité du candidat, catégorie obtenue (E ou D), période de formation,
     * dates d'admission aux examens Code et Conduite, et identité du
     * Directeur Régional signataire.
     */
    public function up(): void
    {
        Schema::table('attestations', function (Blueprint $table) {
            $table->string('civilite')->default('Monsieur')->after('candidat_id');
            $table->string('categorieObtenue')->default('E')->after('civilite');
            $table->date('formationDateDebut')->nullable()->after('categorieObtenue');
            $table->date('formationDateFin')->nullable()->after('formationDateDebut');
            $table->date('dateAdmissionCode')->nullable()->after('formationDateFin');
            $table->date('dateAdmissionConduite')->nullable()->after('dateAdmissionCode');
            $table->string('directeurCivilite')->default('Monsieur')->after('dateAdmissionConduite');
            $table->string('directeurNom')->default('François DRABO')->after('directeurCivilite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attestations', function (Blueprint $table) {
            $table->dropColumn([
                'civilite',
                'categorieObtenue',
                'formationDateDebut',
                'formationDateFin',
                'dateAdmissionCode',
                'dateAdmissionConduite',
                'directeurCivilite',
                'directeurNom',
            ]);
        });
    }
};