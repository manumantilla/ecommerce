<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Proveedor;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Producto::create([
            'nombre' => 'Arroz Diana x500g',
            'descripcion' => 'Arroz de la mejor calidad con vitaminas',
            'id_categoria' => 1, // Asegúrate de tener una categoría con este ID
            'id_proveedor' => 1, // Asegúrate de tener un proveedor con este ID
            'cantidad' => 50,
            'precio' => 15000,
            'precio_al_por_mayor' => 12000,
            'fecha_vencimiento' => '2025-01-25',
            'ubicacion' => 'Bodega #1',
            'imagen' => 'imagen.jpg',
        ]);
        Producto::create([
            'nombre' => 'Jabon Fab X300g',
            'descripcion' => 'Jabon en polvo de amplio uso',
            'id_categoria' => 2, // Asegúrate de tener una categoría con este ID
            'id_proveedor' => 1, // Asegúrate de tener un proveedor con este ID
            'cantidad' => 50,
            'precio' => 3400,
            'precio_al_por_mayor' => 2500,
            'fecha_vencimiento' => '2025-01-25',
            'ubicacion' => 'Bodega #2',
            'imagen' => 'imagen1.jpg',
        ]);
        Producto::create([
            'nombre' => 'Crema Dientes Colgate x200g',
            'descripcion' => 'Crema de dientes triple',
            'id_categoria' => 1, // Asegúrate de tener una categoría con este ID
            'id_proveedor' => 2, // Asegúrate de tener un proveedor con este ID
            'cantidad' => 100,
            'precio' => 7900,
            'precio_al_por_mayor' => 6900,
            'fecha_vencimiento' => '2025-01-25',
            'ubicacion' => 'Bodega #4',
            'imagen' => 'imagen2.jpg',
        ]);
        
    }
}
