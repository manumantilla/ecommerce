<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VentaController extends Controller
{
    //Show dashboard panel products
    public function showProducts(){
        $productos = Producto::paginate(10);
        return view('venta.showProducts',compact('productos'));
    }
    // Add the information in the cart
    public function addCart(Request $request, Producto $producto){
        $producto = Producto::find($producto);

        if(!$producto){
            return redirect->back()->with('error','Producto no encontrado');
        }
        $cantidad = $request->input('cantidad',1);
        // * Get the cart from session()
        $carrito = session()->get('carrito',[]);
        // ? Look if products already in cart
        if(isset($carrito[$producto->id])){
            $carrito[$producto->id]['cantidad']+=$cantidad;
        }else{
            $carrito[$producto] = [
                'id' => $producto->id,
                'nombre' =>$producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => $cantidad,
                'imagen' => $producto->imagen,
            ];
        }
        // todo Save the cart in the session
        session()->put('carrito',$carrito);
        return redirect()->route('carrito')->with('success','Producto Agregado al Carrito');

    }
    //Show the cart
    public function cart(){
        $carrito = session()->get('carrito',[]);
        return view('carrito.show', compact('carrito'));
    }

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
}
