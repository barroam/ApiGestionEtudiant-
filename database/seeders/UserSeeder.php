<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */ /*
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Amadou',
                'prenom' => 'Barro',
                'email' => 'barro@example.com',
                'password' => Hash::make('12345678'),
           ]

]);*/
public function run()
    {
        // Exemple d'utilisateurs personnalisés
        $users = [
            [
                'name' => 'Amadou',
                'prenom' => 'Barro',
                'email' => 'Barro@example.com',
                'password' => Hash::make('12345678'), // Mot de passe sécurisé
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Cheikh',
                'prenom' => 'Sane',
                'email' => 'Cheikh@example.com',
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Mareme',
                'prenom' => 'Diallo',
                'email' => 'Mareme@example.com',
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10),
            ],
            // Ajoutez d'autres utilisateurs ici
        ];

        // Insérer chaque utilisateur dans la base de données
        foreach ($users as $user) {
            User::create($user);
        }
    }
}

