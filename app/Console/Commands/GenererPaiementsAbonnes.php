<?php

namespace App\Console\Commands;

use App\Models\Abonne;
use App\Models\Paiement_abonne;
use Illuminate\Console\Command;

class GenererPaiementsAbonnes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generer-paiements-abonnes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère les paiements mensuels des abonnés actifs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
            $mois = now()->month;
            $annee = now()->year;

            $abonnes = Abonne::get();

            foreach ($abonnes as $abonne) {

                Paiement_abonne::firstOrCreate(
                    [
                        'abonne_id' => $abonne->id,
                        'mois' => $mois,
                        'annee' => $annee,
                    ],
                    [
                        'montant' => 1000, // Montant par défaut, vous pouvez le modifier selon vos besoins
                        'statut' => 'non payé',
                    ]
                );
            }

            $this->info(
                "Les paiements du mois {$mois}/{$annee} ont été générés."
            );

            return Command::SUCCESS;
    }

    
}
