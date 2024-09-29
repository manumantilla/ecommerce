<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    use HasFactory;
    protected $fillable = [
        'compra_id',
        'monto_total',
        'saldo_pendiente',
        'descripcion',
        'fecha_pago',
    ];
    // un credito pertene a una compra
    public function compra(){
        return $this->belongsTo(Compra::class,'compra_id');
    }
}
