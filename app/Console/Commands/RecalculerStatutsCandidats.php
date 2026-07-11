<?php

namespace App\Console\Commands;

use App\Models\Candidat;
use Illuminate\Console\Command;

class RecalculerStatutsCandidats extends Command
{
    /**
     * Nom et signature de la commande.
     */
    protected $signature = 'candidats:recalculer-statuts';

    /**
     * Description affichée dans php artisan list.
     */
    protected $description = 'Recalcule le statut de tous les candidats selon leurs examens officiels et leur progression interne, et corrige automatiquement les anomalies (ex: statut "admis" incorrect).';

    public function handle(): int
    {
        $this->info('Recalcul des statuts en cours...');

        $candidats = Candidat::all();
        $corriges  = 0;

        $bar = $this->output->createProgressBar($candidats->count());
        $bar->start();

        foreach ($candidats as $candidat) {
            $ancienStatut   = $candidat->statut;
            $nouveauStatut  = $candidat->recalculerStatutComplet();

            if ($ancienStatut !== $nouveauStatut) {
                $corriges++;
                $this->newLine();
                $this->line("  ⚠️  {$candidat->nom} {$candidat->prenom} : {$ancienStatut} → {$nouveauStatut}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        if ($corriges > 0) {
            $this->info("✅ Terminé. {$corriges} candidat(s) corrigé(s) sur {$candidats->count()}.");
        } else {
            $this->info("✅ Terminé. Aucune anomalie détectée sur {$candidats->count()} candidat(s).");
        }

        return self::SUCCESS;
    }
}