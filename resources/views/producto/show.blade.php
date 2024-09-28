@extends('layouts.app')

@section('content')
    <div class="m-9">
        <div class="grid grid-cols-3 gap-6">
            <!-- Imagen del producto -->
            <div class="col-span-2 m-10 flex justify-center">
                <img class="w-80 h-auto object-cover rounded-lg shadow-lg" src="{{ asset('images/'.$producto->imagen) }}" alt="{{$producto->imagen}}">
            </div>

            <!-- Información del producto -->
            <div class="flex-1">
                <div class="mb-4">
                    <h2 class="text-3xl text-gray-800 font-bold mb-4">Información Detallada del Producto</h2>

                    @if (auth()->user() && auth()->user()->tipo === 'admin')
                        <p class="mb-1"><span class="font-semibold">ID:</span> {{ $producto->id }}</p>
                    @endif
                    <p class="mb-1  text-lg"><span class="font-semibold">Nombre:</span> {{ $producto->nombre }}</p>
                    <p class="mb-1 text-lg"><span class="font-semibold">Descripción:</span> {{ $producto->descripcion }}</p>

                    @if (auth()->user() && auth()->user()->tipo === 'admin')
                        <p class="mb-1 text-lg"><span class="font-semibold">Precio al Por Mayor </span>{{ $producto->precio_al_por_mayor}}</p>
                    @endif
                    <!-- Mostrar el nombre de la categoría en lugar del ID -->
                    <p class="mb-1 text-lg"><span class="font-semibold">Categoría:</span> {{ $producto->categoria->nombre ?? 'Sin Categoría' }}</p>

                    <p class="mb-1 text-lg"><span class="font-semibold">Fecha de Vencimiento:</span> {{ $producto->fecha_vencimiento }}</p>
                    <p class="mb-1 text-lg"><span class="font-semibold">Fecha de Ingreso:</span> {{ $producto->created_at->format('d-m-Y') }}</p>
                    <p class="mb-1 text-lg"><span class="font-semibold">Cantidad en Stock:</span> {{ $producto->cantidad }}</p>
                    <p class="mb-1 text-lg"><span class="font-semibold">Precio:</span> ${{ number_format($producto->precio) }}</p>
                    <p class="mb-1 text-lg"><span class="font-semibold">Ubicación:</span> {{ $producto->ubicacion }}</p>

                    <!-- Botón para agregar al carrito -->
                    <button class="bg-indigo-600 text-white px-4 py-2 mt-4 rounded-md hover:bg-indigo-700">Agregar al Carrito</button>
                </div>
            </div>
        </div>
    </div>
@endsection
