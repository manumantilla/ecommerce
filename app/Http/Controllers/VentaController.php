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
                'existencia' => $producto->cantidad, //We pass on the stock to calc if the stoch isnot sufficient
                'cantidad' => 1,
                'descuneto' => 0,
                'precio_al_por_mayor' => $producto->precio_al_por_mayor,//for calculta the top disscount
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
    public function deleteFromCart($id)
    {
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$id])) {

            unset($carrito[$id]);
            session()->put('carrito', $carrito);
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'Producto no encontrado']);
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
    public function updateCart(Request $request)
    {
        // Obtener el carrito de la sesión
        $carrito = session()->get('carrito', []);
        $cantidades = $request->input('cantidad');
        $descuentos = $request->input('descuento');
        $totalDescuento = 0;
    
        // Iterar sobre las cantidades para verificar disponibilidad y actualizar el carrito
        foreach ($cantidades as $id => $cantidadSolicitada) {
            if (isset($carrito[$id])) { //check if the product exists in the cart
                $producto = $carrito[$id];
                $existencia = $producto['existencia']; // we call the existence
    
                //Validate if quantity requested exceeds stock
                if ($cantidadSolicitada > $existencia) {
                    return redirect()->route('venta.cart')->with([
                        'error' => "La cantidad solicitada para el producto {$producto['nombre']} excede la existencia disponible de $existencia unidades."
                    ]);
                }
    
                // Update the quantity requested in the cart
                $carrito[$id]['cantidad'] = max(1, (int)$cantidadSolicitada);
    
                // Validate the disscount and put in the cart
                $descuento = $descuentos[$id] ?? 0;
                $precioTotal = $producto['precio'] * $cantidadSolicitada;
                $precioMayor = $producto['precio_al_por_mayor'] * $cantidadSolicitada;
                /**
                 The rest of $a y $b give us the profit margin
                 */
                $descuentoPermitido = $precioTotal - $precioMayor;
    
                if ($descuento <= $descuentoPermitido) {
                    $carrito[$id]['descuento'] = $descuento;
                    $totalDescuento += $descuento;
                } else {
                    return redirect()->route('venta.cart')->with([
                        'error' => "El descuento para el producto {$producto['nombre']} excede el margen de ganancia."
                    ]);
                    $carrito[$id]['descuento'] = 0; // Manejo del descuento inválido
  
                }
            }
        }
    
        // Guardar el carrito actualizado en la sesión
        session()->put('carrito', $carrito);
    
        // Redirigir de nuevo al carrito con un mensaje de éxito
        return redirect()->route('venta.cart')->with([
            'success' => 'Cantidad(es) y descuento(s) actualizados correctamente',
            'totalDescuento' => $totalDescuento
        ]);
    }
     
    // ? Mostrar factura final
    public function checkout(){
        $carrito = session()->get('carrito',[]);
        if(empty($carrito))
        {
            return redirect()->route('venta.showProducts')->with('success','No hay productos en el carrito');
        }

        //calcular
        $total = 0;
        foreach($carrito as $producto)
        {
            //agregar descuento y contarlo
            $total += $producto['precio'] * $producto['cantidad'];
        }
        //retornar la vista de chekcout
        return view('venta.checkout',compact('carrito','total'));
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
