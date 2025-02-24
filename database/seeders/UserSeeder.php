<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrNew([
            'email' => env('ADMIN_EMAIL', 'bytecreacolombia@gmail.com'),
        ], [
            'name' => env('ADMIN_NAME', 'Administrador'),
            'password' => bcrypt(env('ADMIN_PASSWORD', 'bytecreacolombia@gmail.com')),
            'date_of_birth' => env('ADMIN_DATE_OF_BIRTH', '1990-01-01'),
            'phone' => env('ADMIN_PHONE', '1234567890'),
            'state_id' => env('ADMIN_STATE_ID', 1),
        ]);

        // Si el usuario no existe, se guardará.
        if (!$user->exists) {
            $user->save();
        }

        // Asignar el rol al usuario
        $user->assignRole('SuperAdmin');
    }
}
