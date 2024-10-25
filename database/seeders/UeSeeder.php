<?php

namespace Database\Seeders;

use App\Models\Ue;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(){
    // Exemple de données personnalisées pour la table 'ues'
    $ues = [
        [
            'libelle' => 'Mathématiques',
            'date_debut' => '2024-09-01',
            'date_fin' => '2024-12-15',
            'coef' => 4,
            'matiere_id' => 1 // Remplacez par un ID de matière existant
        ],
        [
            'libelle' => 'Physique',
            'date_debut' => '2024-09-01',
            'date_fin' => '2024-12-15',
            'coef' => 3,
            'matiere_id' => 2 // Remplacez par un ID de matière existant
        ],
        [
            'libelle' => 'Chimie',
            'date_debut' => '2024-09-01',
            'date_fin' => '2024-12-15',
            'coef' => 3,
            'matiere_id' => 3 // Remplacez par un ID de matière existant
        ],
        // Ajoutez d'autres UE ici
    ];

    // Insérer chaque UE dans la base de données
    foreach ($ues as $ue) {
        Ue::create($ue);
    }
}
}
