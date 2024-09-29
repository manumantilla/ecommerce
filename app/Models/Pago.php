<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $fillable = [
        'compra_id', 
        'monto', 
        'fecha',
        'descripcion',
    ];
    /*
    Aca declaro que un Pago pertenece si o si a 
    una compra
    */
    public function compra()
    {
        return $this->belongsTo(Compra::class,'compra_id');
    }
}
