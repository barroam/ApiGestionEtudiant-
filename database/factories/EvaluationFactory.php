<?php

namespace Database\Factories;

use App\Models\Eleve;
use App\Models\Matiere;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matiere_id' => Matiere::factory(), // Associe un enregistrement de Matiere
            'eleve_id' => Eleve::factory(), // Associe un enregistrement d'Eleves
        'date' => $this->faker->date,
        'valeurs' => $this->faker->numberbetween(0,20),
        ];
    }
}
