@include('layouts.app')
@section('content')
<div class="">
    <h1>Editar Producto</h1>
</div>
<div class="">
    <form action="{{route('producto.update',$producto->id)}}" method="POST" class=  "">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id" class="">ID</label>
            <input type="text" name="id" class="form-control" value="{{old('id',$producto->id)}}" required>
        </div>
        <div class="form-group">
            <label for="name" class="">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{old('nombre',$producto->nombre)}}" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripcion</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{old('descripcion',$producto->descripcion)}}"></input>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="text" name="cantidad" id="cantidad" class="form-control" value="{{old('cantidad',$producto->cantidad)}}"></input>
        </div>
        <div class="form-group">
            <label for="cantidad">Precio</label>
            <input type="text" name="precio" id="precio" class="form-control" value="{{old('precio',$producto->precio)}}"></input>
        </div>
        <div class="form-group">
            <label for="cantidad">Precio al por Mayor</label>
            <input type="text" name="precio_al_por_mayor" id="precio_al_por_mayor" class="form-control" value="{{old('precio_al_por_mayor',$producto->precio_al_por_mayor)}}"></input>
        </div>
        <div class="form-group">
            <label for="cantidad">Ubicación</label>
            <input type="text" name="ubicacion" id="ubicacion" class="form-control" value="{{old('ubicacion',$producto->ubicacion)}}"></input>
        </div>
        <div class="">
            <button type="button"class="mr-4 py-2 px-4 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</button>
            
            <button type="button"class="mr-4 py-2 px-4 bg-gray-200 text-gray-700 rounded-md hover:bg-indigo-300">Guardar</button>
        </div>

    </form>
</div>
@endsection