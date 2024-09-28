<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;
class categoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create([
            'nombre'=>'lacteos',
            'descripcion'=>'Derivados de la leche',
        ]);
        
        Categoria::create([
            'nombre'=>'harinas',
            'descripcion'=>'Derivados de legumbres',
        ]);
        
        Categoria::create([
            'nombre'=>'aseo',
            'descripcion'=>'Porductos de aseo del hogar',
        ]);
    }
}
