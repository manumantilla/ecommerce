@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Carrito de Compras</h1>

        <form action="{{ route('venta.updateCart') }}" method="POST">
    
            @csrf
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th >Imagen</th>
                        <th class="w-25">Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Descuento </th>
                        <th>Subdescuento</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                        $totalDescuento = session('totalDescuento', 0); // Usamos el descuento total del controlador
                    @endphp

                    @foreach ($carrito as $producto)
                        @php
                            $subtotal = $producto['precio'] * $producto['cantidad'];
                            $subdescuento = $producto['descuento'] ?? 0;
                            $total += $subtotal - $subdescuento;
                        @endphp
                        <tr data-producto-id="{{ $producto['id'] }}">
                            <td ><img src="{{ asset('images/'. $producto['imagen']) }}" class="m-3 text-center w-20 h-20 "></td>
                            <td class="w-45">{{ $producto['nombre'] }}</td>
                            <td class="text-center text-lg">{{ number_format($producto['precio']) }}</td>
                            <td class="text-center">
                                <input type="number" name="cantidad[{{ $producto['id'] }}]" value="{{ $producto['cantidad'] }}" class="w-16 text-center border rounded-lg p-1">
                            </td>
                            <td class="text-center">
                                <input type="number" name="descuento[{{ $producto['id'] }}]" value="{{ $producto['descuento'] ?? 0 }}" style="width:124px;" class=" text-center border rounded-lg p-1">
                            </td>
                            <td class="text-center">{{ number_format($subdescuento) }}</td>
                            <td class="text-center text-lg">{{ number_format($subtotal - $subdescuento) }}</td>
                            <td>
                                <button type="button" class="text-red-500 hover:text-red-600 eliminar-btn" data-id="{{ $producto['id'] }}">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Mostrar el total general del carrito y el descuento total -->
            <div class="mt-6 text-right">
                <h3 class="text-xl font-bold">Descuento total: ${{ number_format($totalDescuento) }}</h3>
                <h3 class="text-3xl font-bold">Total: ${{ number_format($total) }}</h3>
            </div>

            <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Actualizar Cantidades/Descuentos
            </button>
            <a href="{{ route('venta.checkout') }}" class="mt-4 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                Proceder a la Compra
            </a>
        </form>
    </div>


    <!-- Script para manejar la eliminación con AJAX -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.eliminar-btn').click(function() {
            const productId = $(this).data('id');
                    
            if (confirm('¿Seguro que deseas eliminar este producto?')) {
                $.ajax({
                    url: `{{ url('venta/delete-from-cart') }}/${productId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.success) {
                            alert('Producto eliminado correctamente');
                            location.reload();
                        } else {
                            alert('Hubo un problema al eliminar el producto');
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    });
</script>

@endsection
