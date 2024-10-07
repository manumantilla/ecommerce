<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
// ! middleare Admin
use App\Http\Middleware\AdminMiddleware;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// * Routes for PRODUCTS
Route::get('/producto/create',[ProductoController::class,'create'])->name('producto.create');
Route::post('/producto/store',[ProductoController::class, 'store'])->name('producto.store');
Route::get('/producto/index',[ProductoController::class, 'index'])->name('producto.index');//esta ruta si requiere que sea admin para que solo el admin mire el precio al por mayor y que tenga posibilidad de hacer acciones crud
Route::get('/producto/{producto}/show',[ProductoController::class,'show'])->name('producto.show');
Route::get('/producto/{producto}/edit', [ProductoController::class, 'edit'])->name('producto.edit');
Route::put('/producto/{producto}',[ProductoController::class,'update'])->name('producto.update');
Route::delete('/producto/{producto}/delete',[ProductoController::class, 'destroy'])->name('producto.destroy');

// * Route for products --side client
Route::get('/allproducts',[VentaController::class,'showProducts'])->name('venta.showProducts');
// ! search
Route::get('/search',[VentaController::class,'search']);
// * Routes for Cart
Route::get('/carrito', [VentaController::class, 'cart'])->name('venta.cart'); // Muestra el carrito
Route::post('/carrito/add/{id}', [VentaController::class,'addCart'])->name('venta.addCart'); // Agrega un producto al carrito

//? Show final Invoice
Route::get('/carrito/checkout',[VentaController::class, 'checkout'])->name('venta.checkout');
Route::post('/venta/update-cart', [VentaController::class, 'updateCart'])->name('venta.updateCart');
Route::delete('/venta/delete-from-cart/{id}', [VentaController::class, 'deleteFromCart'])->name('venta.deleteFromCart');



require __DIR__.'/auth.php';
