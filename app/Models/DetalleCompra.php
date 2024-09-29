<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;
    protected $fillable=[
        'compra_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'descuento',
    ];
    /*
    Aca decimos que DetalleCompra pertenece a
    una compra
    */
    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }
    /*
    Aca decimos que pun dealle compra esta asociado
    a un
    producto
    */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
