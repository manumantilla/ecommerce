<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedor';
    // Definir las columnas que pueden ser asignadas masivamente
    protected $fillable = ['nombre', 'direccion', 'celular', 'email','descripcion','cuenta1','cuenta2','referencia']; // Ajusta estos campos según tu tabla

    // Relación con productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_proveedor');
    }
}
