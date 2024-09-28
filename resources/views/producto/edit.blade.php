@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Editar Producto</h1>
        <form action="{{ route('producto.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')             
            <!-- Campo ID -->
            <div class="mb-4">
                <label for="id" class="block text-gray-700 text-sm font-bold mb-2">ID</label>
                <input type="text" id="id" name="id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('id', $producto->id) }}" required readonly>
            </div>

            <!-- Campo Nombre -->
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('nombre', $producto->nombre) }}" required>
            </div>

            <!-- Campo Precio -->
            <div class="mb-4">
                <label for="precio" class="block text-gray-700 text-sm font-bold mb-2">Precio</label>
                <input type="text" id="precio" name="precio" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('precio', $producto->precio) }}" required>
            </div>

            <!-- Campo Fecha Vencimiento -->
            <div class="mb-4">
                <label for="fecha_vencimiento" class="block text-gray-700 text-sm font-bold mb-2">Fecha Vencimiento</label>
                <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('fecha_vencimiento', $producto->fecha_vencimiento) }}" required>
            </div>

            <!-- Campo Ubicación -->
            <div class="mb-4">
                <label for="ubicacion" class="block text-gray-700 text-sm font-bold mb-2">Ubicación</label>
                <input type="text" id="ubicacion" name="ubicacion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('ubicacion', $producto->ubicacion) }}" required>
            </div>

            <!-- Campo Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('descripcion', $producto->descripcion) }}" required>
            </div>

            <!-- Campo Categoría -->
            <div class="mb-4">
                <label for="id_categoria" class="block text-gray-700 text-sm font-bold mb-2">Categoría</label>
                <select id="id_categoria" name="id_categoria" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ $categoria->id == $producto->id_categoria ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Campo Precio al Por Mayor -->
            <div class="mb-4">
                <label for="precio_al_por_mayor" class="block text-gray-700 text-sm font-bold mb-2">Precio al por Mayor</label>
                <input type="text" id="precio_al_por_mayor" name="precio_al_por_mayor" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('precio_al_por_mayor', $producto->precio_al_por_mayor) }}" required>
            </div>

            <!-- Campo Proveedor -->
            <div class="mb-4">
                <label for="id_proveedor" class="block text-gray-700 text-sm font-bold mb-2">Proveedor</label>
                <select id="id_proveedor" name="id_proveedor" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ $proveedor->id == $producto->id_proveedor ? 'selected' : '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Campo Cantidad -->
            <div class="mb-4">
                <label for="cantidad" class="block text-gray-700 text-sm font-bold mb-2">Cantidad</label>
                <input type="text" id="cantidad" name="cantidad" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('cantidad', $producto->cantidad) }}" required>
            </div>

            <!-- Mostrar la imagen actual -->
            @if($producto->imagen)
                <div class="mb-4">
                    <label for="imagen_actual" class="block text-gray-700 text-sm font-bold mb-2">Imagen Actual</label>
                    <img id="imagen_actual" src="{{ asset('images/'.$producto->imagen) }}" class="w-40 h-40 object-cover rounded-md">
                </div>
            @endif

            <!-- Campo para subir una nueva imagen -->
            <div class="mb-4">
                <label for="imagen" class="block text-gray-700 text-sm font-bold mb-2">Subir Nueva Imagen (Opcional)</label>
                <input type="file" id="imagen" name="imagen" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- Botón para guardar cambios -->
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Guardar Cambios
            </button>
        </form>
    </div>
@endsection
