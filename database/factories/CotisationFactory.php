<?php

namespace Database\Factories;

use App\Models\Cotisation;
use App\Models\Membre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cotisation>
 */
class CotisationFactory extends Factory
{
    protected $model = Cotisation::class;

    public function definition(): array
    {
        static $compteur = 0;
        $compteur++;

        return [
            'membre_id' => Membre::factory(),
            'reference' => 'REC-'.now()->year.'-'.str_pad((string) $compteur, 4, '0', STR_PAD_LEFT),
            'montant' => $this->faker->randomElement([1000, 2000, 2500, 5000]),
            'mois' => $this->faker->numberBetween(1, 12),
            'annee' => now()->year,
            'date_paiement' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'mode_paiement' => $this->faker->randomElement(Cotisation::MODES_PAIEMENT),
            'observation' => $this->faker->optional()->sentence(),
        ];
    }
}
