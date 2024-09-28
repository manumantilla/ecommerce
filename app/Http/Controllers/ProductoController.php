<?php

namespace App\Http\Controllers;

use App\Models\Producto;

use App\Models\Categoria;

use App\Models\Proveedor;

use Illuminate\Http\Request;
class ProductoController extends Controller
{
    // * for creation
    public function store(Request $request){
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'id_categoria' => 'numeric',
            'id_proveedor' => 'numeric',
            'cantidad' => 'required|numeric',
            'precio' => 'required|numeric',
            'precio_al_por_mayor' => 'required|numeric',
            'fecha_vencimiento' => 'required|date',
            'ubicacion' => 'required|string',
            'imagen' => 'required|mimes:jpg,jpeg,png,svg',
            
        ]);
        if ($request->hasFile('imagen')) {
            $imageName = time().'.'.$request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(public_path('images'), $imageName);
        }
        else {
            $imageName = null;
        }
        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'id_categoria' => $request->id_categoria,
            'id_proveedor' => $request->id_proveedor,
            'cantidad' => $request->cantidad,
            'precio'=> $request->precio,
            'precio_al_por_mayor' => $request->precio_al_por_mayor,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'ubicacion' => $request->ubicacion,
            'imagen' => $imageName,

        ]);
        return redirect()->route('producto.index')->with('success','Producto Registrado Exitosamente');
    }
    public function create(){
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('producto.create', compact('categorias','proveedores'));
    }
    // * for show
    public function index(){
        $productos = Producto::paginate(20);
        //dd($productos); // Verifica los datos que se están enviando
        return view('producto.index',compact('productos'));
    }
    // * for specific product
    public function show(Producto $producto){
        return view('producto.show', compact('producto'));
    }
   // * for editing a product
   public function update(Producto $producto, Request $request)
   {
       // Validar la entrada
       $request->validate([
           'nombre' => 'required|string',
           'descripcion' => 'required|string',
           'id_categoria' => 'required|numeric',
           'descripcion' => 'required|string',
           'id_proveedor' => 'required|numeric',
           'cantidad' => 'required|integer',
           'precio' => 'required|numeric',
           'precio_al_por_mayor' => 'required|numeric',
           'fecha_vencimiento' => 'required|date',
           'ubicacion' => 'required|string',
           'imagen' => 'nullable|mimes:jpg,jpeg,png,svg',
       ]);
       // TODO Verificar si hay nueva imagen
       if ($request->hasFile('imagen')) {
        // Eliminar la imagen anterior si existe
        if ($producto->imagen) {
            $rutaAnterior = public_path('images/'.$producto->imagen);
            if (file_exists($rutaAnterior)) {
                unlink($rutaAnterior); // Elimina la imagen anterior
            }
        }

        // Guardar la nueva imagen
        $imageName = time().'.'.$request->file('imagen')->getClientOriginalExtension();
        //Movemos la imagen a la carpeta /public/images
        $request->file('imagen')->move(public_path('images'), $imageName);
        // Actualizar el nombre de la imagen en el modelo
        $producto->imagen = $imageName;
    }
   
       // Actualizar el resto de los campos del producto
       $producto->update([
           'nombre' => $request->nombre,
           'descripcion' => $request->descripcion,
           'id_categoria' => $request->id_categoria,
           'id_proveedor' => $request->id_proveedor,
           'cantidad' => $request->cantidad,
           'precio' => $request->precio,
           'precio_al_por_mayor' => $request->precio_al_por_mayor,
           'fecha_vencimiento' => $request->fecha_vencimiento,
           'ubicacion' => $request->ubicacion,
           'imagen' => $producto->imagen,
       ]);
   
       return redirect()->route('producto.index')->with('success', 'Producto Actualizado Correctamente');
   }
    public function edit(Producto $producto)
    {
        // Ya tienes el producto, no necesitas hacer findOrFail de nuevo
        $categorias = Categoria::all(); // Obtiene todas las categorías
        $proveedores = Proveedor::all(); // Obtiene todos los proveedores
        
        return view('producto.edit', compact('producto', 'categorias', 'proveedores'));
    }  
    // * for delete
    public function destroy(Producto $producto){
        $producto->delete();
        return redirect()->route('producto.index')->with('success','Producto Eliminado');
    }

}
