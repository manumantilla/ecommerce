<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Para usar Hash::make

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un usuario administrador
        User::create([
            'name' => 'manu',
            'email' => 'manu@gmail.com',
            'password' => Hash::make('qwerty123'), // Asegúrate de usar Hash para la contraseña
            'tipo' => 'admin',
        ]);
  
    }
}
