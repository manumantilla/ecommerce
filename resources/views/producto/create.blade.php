@extends('layouts.app')
@section('content')

<div style="width:100%;" class="bg-gray-100">
    <h1 class="text-center text-2xl font-bold py-6">Agregar un nuevo Producto</h1>

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-md mt-10">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Informacion Producto</h2>
        <p class="text-sm text-gray-500 mb-6">Guardar información de los productos.</p>

        <form method="POST" action="{{ route('producto.store') }} "enctype="multipart/form-data">
            @csrf <!-- Token CSRF para proteger contra ataques -->

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Todos los campos de entrada que ya tienes -->
                <!-- Agregar aquí el resto de campos, como ya los tienes en el código anterior -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Descripción</label>
                    <input type="text" name="descripcion" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                    <input type="text" name="cantidad" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Precio</label>
                <input type="text" name="precio" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="">
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Precio al por mayor</label>
                <input type="text" name="precio_al_por_mayor" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="">
            </div>
                <!-- Campos de Fecha -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Fecha Vencimiento</label>
                        <input type="date" name="fecha_vencimiento" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <!-- Campos adicionales -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                <select name="id_proveedor" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"> 
                    @foreach($proveedores as $proveedor)
                        <option value="{{$proveedor->id}}" class="">{{$proveedor->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Categoria</label>
                <select name="id_categoria" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"> 
                    @foreach($categorias as $categoria)
                        <option value="{{$categoria->id}}" class="">{{$categoria->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Ubicación</label>
                <select name="ubicacion" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="estanteria1">Estanteria 1</option>
                    <option value="caja">Caja</option>
                    <option value="estanteria2">Estanteria 2</option>
                </select>
            </div>
            <!--Campo para subir una foto-->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Foto</label>
                <input type="file" name="imagen" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex justify-end">
                <button type="button" class="mr-4 py-2 px-4 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</button>
                <button type="submit" class="py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Save</button>
            </div>
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        </form>
    </div>
</div>

@endsection 