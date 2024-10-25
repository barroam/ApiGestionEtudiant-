<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Eleve;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EleveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */public function run()
    {
        // Exemple de données personnalisées pour la table 'eleves'
        $eleves = [
            [
                'nom' => 'Moussa',
                'prenom' => 'Ba',
                'adresse' => 'Daker,Senegal',
                'telephone' => '771110011',
                'matricule' => 'E2024001',
                'date_naissance' => '2005-01-15',
                'email' => 'Moussa@example.com',
                'photo' => null, // Si vous n'avez pas d'image, mettez null
                'user_id' => User::inRandomOrder()->first()->id, // Associe un enregistrement d'User aléatoire
            ],
            [
                'nom' => 'Malang',
                'prenom' => 'Marna',
                'adresse' => 'Daker,Senegal',
                'telephone' => '770001100',
                'matricule' => 'E2024002',
                'date_naissance' => '2006-03-22',
                'email' => 'Malang@example.com',
                'photo' => null,
                'user_id' => User::inRandomOrder()->first()->id,
            ],
            [
                'nom' => 'Aliou',
                'prenom' => 'Diop',
                'adresse' => 'Daker,Senegal',
                'telephone' => '0112233445',
                'matricule' => 'E2024003',
                'date_naissance' => '2005-05-10',
                'email' => 'Aliou@example.com',
                'photo' => null,
                'user_id' => User::inRandomOrder()->first()->id,
            ],
            // Ajoutez d'autres élèves ici
        ];

        // Insérer chaque élève dans la base de données
        foreach ($eleves as $eleve) {
            Eleve::create($eleve);
        }
}
}
