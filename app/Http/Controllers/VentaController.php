<?php
namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Credito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        //calcular total compra
        $total = 0;
        $totalDescuento = 0;
        foreach($carrito as $producto)
        {
            //Calculate the total
            $total +=( $producto['precio'] * $producto['cantidad'])-$producto['descuento'];
            //caltulate the disscount total
            $totalDescuento += $producto['descuento'];
        }
        //retornar la vista de chekcout
        return view('venta.checkout',compact('carrito','total','totalDescuento'));
    }

    //compra
    public function checkout2(Request $request)
    {
        // Validaciones del formulario
        $request->validate([
            'nombre' => 'required|string|max:255', // Asegúrate de validar el campo 'nombre'
            'cedula' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'direccion' => 'required|string|max:255',
            'celular' => 'nullable|numeric|min:0',
            'descripcion' => 'nullable|string', // Descripción puede ser opcional
            'total' => 'required|numeric', // Valida el total correctamente
            'estado' => 'nullable|string',
            'fecha_pago' => 'date',
            'forma_pago' => 'nullable|string',
            'productos' => 'required|array', // Esperamos un array de productos
            'productos.*.cantidad' => 'required|integer|min:1', // Cada producto debe tener una cantidad
            'productos.*.precio' => 'required|numeric|min:0', // Precio de cada producto
            'productos.*.descuento' => 'nullable|numeric|min:0', // Descuento opcional por producto
        ]);
    
        try {
            //dd($request);
            if($request->input('estado') === 'credito'){
                $compra = Compra::create([
                    'nombre' => $request->nombre,
                    'cedula' => $request->cedula,
                    'email' => $request->email,
                    'direccion' => $request->direccion,
                    'descripcion' => $request->descripcion,
                    'celular' => $request->celular,
                    'total' => $request->total, // Asegúrate de que este campo esté en el formulario
                    'estado' => $request->estado,
                    'forma_pago' => $request->forma_pago,
                ]);
                $credito = Credito::create([
                    'compra_id' => $compra->id,
                    'monto_total' => $request->total,
                    'fecha_pago' => $request->fecha_pago,
                ]);
            }else{
                        // Crear la compra
                $compra = Compra::create([
                    'nombre' => $request->nombre,
                    'cedula' => $request->cedula,
                    'email' => $request->email,
                    'direccion' => $request->direccion,
                    'descripcion' => $request->descripcion,
                    'celular' => $request->celular,
                    'total' => $request->total, // Asegúrate de que este campo esté en el formulario
                    'estado' => $request->estado,
                    'forma_pago' => $request->forma_pago,
                ]);
    

            }
                        // Registrar los detalles de cada producto en la compra
                        foreach ($request->productos as $producto) {
                            $subtotal = ($producto['precio'] * $producto['cantidad']) - ($producto['descuento'] ?? 0);
                            DetalleCompra::create([
                                'compra_id' => $compra->id, // Aseguramos que sea la compra correcta
                                'producto_id' => $producto['id'],
                                'cantidad' => $producto['cantidad'],
                                'precio_unitario' => $producto['precio'],
                                'subtotal' => $subtotal,
                                'descuento' => $producto['descuento'] ?? 0,
                            ]);
                            //Actualizar la cantidad
                            $producto['id']->update([
                                'cantidad' => $producto['cantidad'],
                            ]);
                        }
                
                        // Confirmar la transacción
                
                        session()->forget('carrito');
            
                        // Retornar una respuesta exitosa
                        return redirect()->route('venta.showProducts')->with('success', 'Bien');
            
                
            
    
        } catch (\Exception $e) {
            // Handle exceptions gracefully
            return redirect()->back()->withErrors('Error al vender el animal: ' . $e->getMessage());
        }
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
