<?php

namespace Database\Factories;

use App\Models\Matiere;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ue>
 */
class UeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matiere_id' => Matiere::factory(), // Associe un enregistrement aléatoire de Matiere
            'libelle' => $this->faker->word,
            'date_debut' => $this->faker->date,
            'date_fin' => $this->faker->date,
           'coef'=> $this->faker->numberbetween(0,5),
        ];
    }
}
