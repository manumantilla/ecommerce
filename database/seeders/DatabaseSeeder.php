<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Proveedor;
use App\Models\Categoria;
use Illuminate\Support\Facades\Hash; // Para usar Hash::make

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            //ProductoSeeder::class,
            proveedores::class,
            categoriasSeeder::class,
        ]);
    }
}
