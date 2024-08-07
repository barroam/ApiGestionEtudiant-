<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Eleve>
 */
class EleveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'adresse' => $this->faker->address,
            'telephone' => $this->faker->phoneNumber, // Assurez-vous que le format est correct
            'matricule' => $this->faker->unique()->word,
            'date_naissance' => $this->faker->date,
            'email' => $this->faker->unique()->safeEmail,
            'photo_path' => $this->faker->imageUrl,
            'user_id' => User::factory(),
        ];
    }
}
