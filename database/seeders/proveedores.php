<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Proveedor;
class proveedores extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Proveedor::create([
            'nombre' => 'Meico',
            'descripcion'=>'Empresa nacional de tabaco',
            'email'=>'meico@gmail.com',
            'cuenta1' => '12323',
            'cuenta2' => '123312312',
            'celular' => '321332212',
        ]);
        Proveedor::create([
            'nombre' => 'Coca Cola SAS',
            'email'=>'cocacola@gmail.com',
            'descripcion'=> 'empresa de coca cola',
            'cuenta1' => '2232',
            'cuenta2' => '233223',
            'celular' => '004040404',
        ]);
                
    }
}
