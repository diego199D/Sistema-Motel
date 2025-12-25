<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Habitacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);



       $habitaciones = [2, 3, 4, 5, 6];

        foreach ($habitaciones as $n) {
        Habitacion::firstOrCreate([
            'numero' => $n,
            'estado' => 'libre'
        ]);
        }
    }
}
