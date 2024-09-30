<?php
namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Http\Request;
class VentaController extends Controller
{
    //Show dashboard panel products
    public function showProducts(){
        $productos = Producto::paginate(10);

        //dd($productos);
        return view('venta.showProducts',compact('productos'));
    }
    // Add the information in the cart
    public function addCart($id)
    {
        // Buscar el producto por ID
        $producto = Producto::find($id);
        if(!$producto){
            return redirect()->back()->with('error','Producto no encontrado');
        }
        // Obtener el carrito de la sesión (o un array vacío si no existe)
        $carrito = session()->get('carrito', []);
        // Verificar si el producto ya está en el carrito
        if(isset($carrito[$producto->id])){
            // Mensaje para cuando el producto ya estaba y se ha incrementado la cantidad
            session()->put('carrito', $carrito);
            return redirect()->route('venta.showProducts')->with('success', 'Ya tienes agregado este producto en tu carrito');
        } else {
            // Agregar el producto al carrito
            $carrito[$producto->id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'imagen' => $producto->imagen,
            ];
        }
        // Guardar el carrito actualizado en la sesión
        session()->put('carrito', $carrito);

        // Redirigir a la vista del carrito
        return redirect()->route('venta.cart')->with('success', 'Producto agregado al carrito');
    }
    //Show the cart
    public function cart(){
        $carrito = session()->get('carrito',[]);
        return view('venta.cart', compact('carrito'));
    }
    //delete on item for the cart
    public function delete($id){
        //recuperar el carrito
        $carrito = session()->get('carrito',[]);
        //verificar
        if(isset($carrito[$id])){
            unset($carrito[$id]);
            session()->put('carrito',$carrito);//actualizar
        }
        return redirect()->route('venta.showProducts')->with('success','Eliminado');
    }
    //delete all the cart
    public function realizarCompra(Request $request){
        $request ->validate([
            'nombre' => 'required|string',
            'cedula' => 'required|numeric',
            'celular' => 'nullable|numeric',
            'email' => 'nullable|string|email',
            'direccion' => 'nullable|string',
        ]);
        //Get the session of the cart
        $carrito = session()->get('carrito',[]);
        if(empty($carrito)){
            return redirect()->back()->with('error','El carrito esta vacio');
        }
        // * Create a new bill
        $venta = new \App\Models\FacturaVenta();
        $venta -> nombre = $request->nombre;
        $venta -> cedula = $request->cedula;
        $venta -> celular = $request->celular;
        $venta -> email = $request->email;
        $venta -> direccion = $request->direccion;
        $venta -> fecha = now();
        $venta -> save();
        
        // Agregar los detalles de la venta
        foreach ($carrito as $id => $detalle) {
            $detalleFactura = new \App\Models\DetalleFacturaVenta();
            $detalleFactura->id_factura_venta = $venta->id;
            $detalleFactura->id_producto = $id;
            $detalleFactura->cantidad = $detalle['cantidad'];
            $detalleFactura->precio = $detalle['precio'];
            $detalleFactura->total = $detalle['cantidad'] * $detalle['precio'];
            $detalleFactura->save();
        }

        // Vaciar el carrito
        session()->forget('carrito');

        return redirect()->route('ventas')->with('success', 'Compra realizada exitosamente');
            
    }
    //compra
    public function compra(Request $request){

    }
    //*search
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        // Buscar productos cuyo nombre coincida con la búsqueda
        $productos = Producto::where('nombre', 'LIKE', "%{$query}%")
            ->with('categoria') // Traer la relación de categoría
            ->get();
    
        // Retornar los productos como JSON
        return response()->json($productos);
    }
    
        

}
