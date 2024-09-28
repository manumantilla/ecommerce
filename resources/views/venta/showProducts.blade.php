@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-10">
    <h1 class="text-3xl font-bold mb-6">Productos</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6">
                @foreach ($productos as $producto)
                    <form action="{{route('venta.addCart',$producto->id)}}" method="POST">  
                        @csrf   
                        <div class="bg-white rounded-lg shadow-md p-4">
                            <img class="w-full h-48 object-cover rounded-t-md" src="{{ asset('images/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                            <div class="mt-4">
                                <p class="text-sm text-gray-500">{{ $producto->categoria->nombre }}</p> <!-- Mostrar categoría -->
                                <h3 class="text-lg font-semibold text-gray-800">{{ $producto->nombre }}</h3>
                                <p class="text-lg font-bold text-gray-900">${{ number_format($producto->precio) }}</p>
                                
                                <!-- Opcional: Mostrar los colores o variantes si los tienes -->
                                <div class="mt-2 flex items-center space-x-2">
                                    <h5 class="text-sm text-gray-400">{{$producto->descripcion}}</h5>
                                </div>
                            </div>
                            <div class="flex items-center justify-center">
                                <button type="submit" class="m-4 py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Agregar al carrito</button>
                            </div>
                        </div>
                    </form>
                @endforeach         
        </div>

    <div class="mt-8">
        <!-- Paginación -->
        {{ $productos->links() }}
    </div>
</div>
@endsection
