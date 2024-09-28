@extends('layouts.app')

@section('content')
<div class="p-6 bg-white shadow-md rounded-md mt-10">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-600">Lista de Productos</h1>
            <p class="text-sm text-gray-500">Lista de todos los productos en la tienda</p>
        </div>
        <a href="{{ route('producto.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Agregar Producto</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</td>
                    <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</td>
                    <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</td>
                    <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Vencimiento</td>
                    <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</td>                    
                    <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</td>
                    <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</td>
                    <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</td>
                    <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</td>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($productos as $producto)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $producto->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $producto->nombre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $producto->descripcion }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $producto->fecha_vencimiento }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $producto->categoria->nombre ?? 'Sin Categoría' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $producto->cantidad }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $producto->precio }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $producto->ubicacion }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <a href="{{ route('producto.edit', $producto->id) }}" class="">Editar</a>
                        <a href="{{ route('producto.show', $producto->id) }}" class="">Ver más</a>
                        <form action="{{ route('producto.destroy', $producto->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:text-red-900 ml-2" type="submit" onclick="return confirm('¿Estás seguro que quieres eliminar este producto?')">Eliminar</button>
                        </form>
                    </td>
                </tr>        
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
            {{ $productos->links() }} <!-- Esto genera los enlaces de paginación -->
    </div>
</div>
@endsection
    