<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $fillable = ['fecha',
    'total',
    'estado',
    'forma_pago',
    'nombre',
    'cedula',
    'email',
    'direccion',
    'descripcion',
    ];
/*
Aca estamos diciendo que Compra tiene muchos detalles
compra; que puede tener muchos pagos,
que puede tener un solo credito
*/
    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class);
    }
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
    public function credito()
    {
        return $this->hasOne(Credito::class);
    }
}
