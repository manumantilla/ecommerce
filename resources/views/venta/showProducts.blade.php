@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-10">
    <h1 class="text-3xl font-bold mb-6">Buscar Productos</h1>

    <!-- Formulario de búsqueda -->
    <div class="mb-6">

        <input type="text" id="search" name="search" class="  border rounded w-full py-2 px-3 text-gray-700  focus:outline-none focus:shadow-outline" placeholder="Buscar productos...">
        
    </div>

    <!-- Productos -->
    <div id="productos-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6">
        @foreach ($productos as $producto)
            <div class="bg-white rounded-lg shadow-md p-4">
                <img class="w-full h-48 object-cover rounded-t-md" src="{{ asset('images/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                <div class="mt-4">
                    <p class="text-sm text-gray-500">{{ $producto->categoria->nombre }}</p>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $producto->nombre }}</h3>
                    <p class="text-lg font-bold text-gray-900">${{ number_format($producto->precio) }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $productos->links() }}
    </div>
</div>
<script>
    document.getElementById('search').addEventListener('keyup', function () {
        let query = this.value;

        // Realizar la solicitud AJAX a tu servidor
        fetch(`/search?q=${query}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            let productosList = document.getElementById('productos-list');
            productosList.innerHTML = '';

            // Iterar sobre los productos y mostrarlos
            data.forEach(producto => {
                productosList.innerHTML += `
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <img class="w-full h-48 object-cover rounded-t-md" src="/images/${producto.imagen}" alt="${producto.nombre}">
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">${producto.categoria.nombre}</p>
                            <h3 class="text-lg font-semibold text-gray-800">${producto.nombre}</h3>
                            <p class="text-lg font-bold text-gray-900">$${producto.precio.toFixed(2)}</p>
                        </div>
                    </div>
                `;
            });
        });
    });
</script>

@endsection
