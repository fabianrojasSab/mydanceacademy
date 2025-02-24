<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        State::firstOrCreate([
            'name' => 'Activo',
            'description' => 'Usuario activo',
        ]);

        State::firstOrCreate([
            'name' => 'Inactivo',
            'description' => 'Usuario inactivo',
        ]);

        State::firstOrCreate([
            'name' => 'Pre-registro',
            'description' => 'Usuario Pre-registro',
        ]);
    }
}
