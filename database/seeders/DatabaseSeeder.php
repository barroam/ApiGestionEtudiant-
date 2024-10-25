<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\UeSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\EleveSeeder;
use Database\Seeders\MatiereSeeder;
use Database\Seeders\EvaluationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            EleveSeeder::class,
            MatiereSeeder::class,
            EvaluationSeeder::class,
            UeSeeder::class, // Ajout du seeder pour 'ue'
            // Ajoutez d'autres seeders ici au besoin
        ]);

    }
}
