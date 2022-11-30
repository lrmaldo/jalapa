<?php

use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CarruselController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TelefonoController;
use App\Http\Controllers\TiendaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/t/{id}',[TiendaController::class,'vista_frontend'])->name('fronted.tienda');
Route::get('/t/{id_tienda}/producto/{id}',[TiendaController::class,'vista_producto'])->name('fronted.tienda.producto');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('tiendas',TiendaController::class);
    Route::resource('banners',CarruselController::class);
    Route::resource('giros',CategoriaController::class);
    Route::resource('hotspots',HotspotContoller::class);
    Route::resource('telefonos',TelefonoController::class);


    
    

    
});




///t/{{ $producto->tienda_id }}/producto/{{$producto->id}}

Route::get('/cart',[CarritoController::class,'cartList'])->name('carrito.lista');
Route::post('/cart',[CarritoController::class,'addToCart'])->name('carrito.store');


