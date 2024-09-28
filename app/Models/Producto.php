<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Producto extends Model
{
    use HasFactory;
    // Definir los atributos que se pueden asignar masivamente
    protected $table = 'producto';
    protected $fillable = [
        'id_categoria',
        'nombre',
        'id_proveedor',
        'descripcion',
        'cantidad',
        'precio',
        'precio_al_por_mayor',
        'fecha_vencimiento',
        'ubicacion',
        'imagen',
    ];
    // Relación con la tabla 'categoria'
    public function categoria()
    { return $this->belongsTo(Categoria::class, 'id_categoria');
    }
    public function proveedor(){
        return $this->belongsTo(Proveedor::class,'id_proveedor');
    }
}
 