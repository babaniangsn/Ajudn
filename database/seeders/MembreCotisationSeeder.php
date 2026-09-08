<?php

namespace Database\Seeders;

use App\Models\Cotisation;
use App\Models\Membre;
use Illuminate\Database\Seeder;

/**
 * Alimente la base avec des membres et des cotisations de démonstration.
 */
class MembreCotisationSeeder extends Seeder
{
    public function run(): void
    {
        $membres = Membre::factory()->count(25)->create();

        $reference = 1;

        foreach ($membres as $membre) {
            $nombreMois = random_int(0, 6);
            $moisDejaUtilises = [];

            for ($i = 0; $i < $nombreMois; $i++) {
                $mois = random_int(1, now()->month);

                if (in_array($mois, $moisDejaUtilises, true)) {
                    continue;
                }

                $moisDejaUtilises[] = $mois;

                Cotisation::factory()->create([
                    'membre_id' => $membre->id,
                    'reference' => 'REC-'.now()->year.'-'.str_pad((string) $reference++, 4, '0', STR_PAD_LEFT),
                    'mois' => $mois,
                    'annee' => now()->year,
                ]);
            }
        }
    }
}
