@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto mt-10">
    <form action="{{route('venta.checkout2')}}" method="POST">
        @csrf
                <!-- Mostrar errores generales -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Mostrar errores de validación de campos (por ejemplo, nombre, cedula, etc.) -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <h1 class="text-3xl font-bold mb-6">Confirmación de Compra</h1>
            <h2>Fecha y Hora</h2>
            <p id="fechaHora"></p>

            <div class="">
                <input name="nombre" class="m-4 rounded"placeholder="Nombre Completo" type="text"></input>
                <input name="cedula" class="m-4 rounded"placeholder="Cedula" type="number"></input>
                <input name="email"class="m-4 rounded"placeholder="Correo Electronico" type="email"></input>
                <input name="direccion"class="m-4 rounded" placeholder="Direccion" type="text">
                <input name="celular" class="m-4 rounded" placeholder="Celular" type="number">
                <input name="descripcion" class="m-4 rounded" placeholder="Descripcion" >
                <select name="estado" id="estado">
                    <option value="pagada">Contado</option>
                    <option value="credito" >Credito</option>
                </select>

                <div id="fecha_pago_container" style="display:none;">
                    <label for="fecha_pago">Fecha Limite Pago</label>
                    <input type="date" name="fecha_pago" id="fecha_pago">
                </div>
            
                <select name="forma_pago" id="forma_pago">
                    <option value="efectivo">Efectivo</option>
                    <option value="transferencia">Transferencia</option>
                </select>
            </div>
            <div class="">
        
            </div>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Producto</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Precio Unitario</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Descuento </th>
                    </tr>
                </thead>
                <tbody>
                
                @php
                    $totalCompra = 0;
                @endphp
                @foreach ($carrito as $index => $producto)
                    @php
                        // Calcular el subtotal con descuento si aplica
                        $subtotal = ($producto['precio'] * $producto['cantidad']) - ($producto['descuento'] ?? 0);
                        $totalCompra += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $producto['nombre'] }}</td>
                        <td>{{ $producto['cantidad'] }}</td>
                        <td>{{ number_format($producto['precio'], 2) }}</td>
                        <td>{{ number_format($subtotal, 2) }}</td>
                        <td>{{ number_format($producto['descuento'] ?? 0, 2) }}</td>

                        <!-- Campos ocultos con información de cada producto -->
                        <input type="hidden" name="productos[{{ $index }}][id]" value="{{ $producto['id'] }}">
                        <input type="hidden" name="productos[{{ $index }}][cantidad]" value="{{ $producto['cantidad'] }}">
                        <input type="hidden" name="productos[{{ $index }}][precio]" value="{{ $producto['precio'] }}">
                        <input type="hidden" name="productos[{{ $index }}][descuento]" value="{{ $producto['descuento'] ?? 0 }}">
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-6">
                  <!-- Campo oculto para enviar el total al servidor -->
                <input type="hidden" name="total" value="{{ $totalCompra }}">
                <h3 class="text-xl font-bold">Total a pagar: ${{ number_format($total) }}</h3>
                <h4 class="text-xl font-bold">Descuento total: ${{number_format($totalDescuento)}}</h4>
            </div>
        </div>
        <button type="submit">Finalizar</button>
    </form>
      
<!--Show the time-->
<script>
      $(document).ready(function(){
            // Evento change cuando se selecciona un estado
            $('#estado').on('change', function(){
                var estadoSeleccionado = $(this).val();

                // Si el valor seleccionado es "credito", mostrar el campo de fecha
                if(estadoSeleccionado === 'credito') {
                    $('#fecha_pago_container').show();
                } else {
                    // Si es cualquier otro valor, ocultar el campo de fecha
                    $('#fecha_pago_container').hide();
                }
            });

            // Llamada inicial para que al cargar la página, dependiendo del valor seleccionado, se oculte o muestre el campo
            $('#estado').trigger('change');
        });


    function mostrarFechaHora() {
        const fechaHora = new Date();
        const opciones = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
        document.getElementById('fechaHora').textContent = fechaHora.toLocaleDateString('es-ES', opciones);
    }
    // Llama a la función para mostrar la fecha y hora
    mostrarFechaHora();
</script>
@endsection