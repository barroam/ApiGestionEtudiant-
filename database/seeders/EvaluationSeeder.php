<?php

namespace Database\Seeders;

use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Evaluation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Exemple de données personnalisées pour la table 'evaluations'
        $evaluations = [
            [
                'matiere_id' => Matiere::inRandomOrder()->first()->id, // Associe un enregistrement de Matiere aléatoire
                'eleve_id' => Eleve::inRandomOrder()->first()->id, // Associe un enregistrement d'Eleves aléatoire
                'date' => '2024-10-01',
                'valeurs' => rand(0, 20), // Valeur aléatoire entre 0 et 20
            ],
            [
                'matiere_id' => Matiere::inRandomOrder()->first()->id,
                'eleve_id' => Eleve::inRandomOrder()->first()->id,
                'date' => '2024-10-15',
                'valeurs' => rand(0, 20),
            ],
            [
                'matiere_id' => Matiere::inRandomOrder()->first()->id,
                'eleve_id' => Eleve::inRandomOrder()->first()->id,
                'date' => '2024-10-20',
                'valeurs' => rand(0, 20),
            ],
            // Ajoutez d'autres évaluations ici
        ];

        // Insérer chaque évaluation dans la base de données
        foreach ($evaluations as $evaluation) {
            Evaluation::create($evaluation);
        }
}
}
