<?php

namespace Database\Seeders;

use App\Models\Matiere;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Exemple de données personnalisées pour la table 'matieres'
        $matieres = [
            [
                'libelle' => 'Mathématiques',
                'date_debut' => '2024-09-01',
                'date_fin' => '2024-12-15',
            ],
            [
                'libelle' => 'Physique',
                'date_debut' => '2024-09-01',
                'date_fin' => '2024-12-15',
            ],
            [
                'libelle' => 'Chimie',
                'date_debut' => '2024-09-01',
                'date_fin' => '2024-12-15',
            ],
            [
                'libelle' => 'Biologie',
                'date_debut' => '2024-09-01',
                'date_fin' => '2024-12-15',
            ],
            // Ajoutez d'autres matières ici
        ];

        // Insérer chaque matière dans la base de données
        foreach ($matieres as $matiere) {
            Matiere::create($matiere);
        }
    }
}
