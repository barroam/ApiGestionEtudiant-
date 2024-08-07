<?php

namespace Database\Factories;

use App\Models\Eleve;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matiere>
 */
class MatiereFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'eleve_id' => Eleve::factory(), // Associe un enregistrement aléatoire de Eleves
            'libelle' => $this->faker->word,
            'date_debut' => $this->faker->date,
            'date_fin' => $this->faker->date,
        ];

    }
}
