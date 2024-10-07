@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Confirmación de Compra</h1>
        <div class="">
            <input placeholder="Nombre Completo"></input>
            
            <input placeholder="Cedula"></input>
            
            <input placeholder="Correo Electronico"></input>
        </div>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-4 py-2">Producto</th>
                    <th class="px-4 py-2">Cantidad</th>
                    <th class="px-4 py-2">Precio Unitario</th>
                    <th class="px-4 py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($carrito as $producto)
                    <tr>
                        <td class="px-4 py-2">{{ $producto['nombre'] }}</td>
                        <td class="px-4 py-2">{{ $producto['cantidad'] }}</td>
                        <td class="px-4 py-2">{{ number_format($producto['precio']) }}</td>
                        <td class="px-4 py-2">{{ number_format($producto['precio'] * $producto['cantidad']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            <h3 class="text-xl font-bold">Total a pagar: ${{ number_format($total) }}</h3>
        </div>

        <div class="mt-6">
            <!---
            --->
            <a href="{{ route('venta.procesarCompra') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                Finalizar Compra
            </a>
        </div>
    </div>
@endsection