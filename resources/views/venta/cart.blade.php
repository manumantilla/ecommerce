@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Carrito de Compras</h1>

            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Imagen</th>
                        <th class="px-4 py-2">Producto</th>
                        <th class="px-4 py-2">Precio</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carrito as $producto)
                        <tr>
                            <td class="px-4 py-2">
                                <img src="{{ asset('images/'. $producto['imagen']) }}" class="w-20 h-20 object-cover">
                            </td>
                            <td class="px-4 py-2">{{$producto['nombre']}}</td>
                            <td class="px-4 py-2">{{number_format($producto['precio'])}}</td>
                            <td class="px-4 py-2">{{$producto['cantidad']}}</td>
                            <td class="px-4 py-2">{{$producto['precio']*$producto['cantidad']}}</td>
                            <td class="px-4 py-2">
                                <form action="{{route('venta.deleteFromCart',$producto['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

    </div>
@endsection