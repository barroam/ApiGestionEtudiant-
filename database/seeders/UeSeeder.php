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
    public function run(): void
    {
        Ue::factory()->count(10)->create();
    }
}
