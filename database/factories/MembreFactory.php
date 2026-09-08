<?php

namespace Database\Factories;

use App\Models\Membre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Membre>
 */
class MembreFactory extends Factory
{
    protected $model = Membre::class;

    public function definition(): array
    {
        static $compteur = 0;
        $compteur++;

        return [
            'matricule' => 'MB-'.str_pad((string) $compteur, 4, '0', STR_PAD_LEFT),
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'telephone' => '7'.$this->faker->numerify('# ### ## ##'),
            'email' => $this->faker->unique()->safeEmail(),
            'adresse' => $this->faker->address(),
            'date_adhesion' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'statut' => $this->faker->randomElement(['actif', 'actif', 'actif', 'inactif']),
        ];
    }
}
