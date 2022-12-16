<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CarruselController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CategoriaTiendaController;
use App\Http\Controllers\HotspotController;
use App\Http\Controllers\ImagenHotspotController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TelefonoController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\ZonaController;
use App\Models\Carrusel;
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
    $carruseles = Carrusel::where('is_active',true)->get()->shuffle();
   # dd($carruseles);
    return view('welcome',compact('carruseles'));
});

Route::get('/t/{id}',[TiendaController::class,'vista_frontend'])->name('fronted.tienda');
Route::get('/t/{id_tienda}/producto/{id}',[TiendaController::class,'vista_producto'])->name('fronted.tienda.producto');


/* blogs */

Route::get('/blogs',[BlogController::class,'vista_todos'])->name('fronted.blogs');
Route::get('blogs/{id}',[BlogController::class,'vista_frontend'])->name('fronted.blog.show');

/* hotspot */
Route::get('/hotspot/preview/{id}',[HotspotController::class,'vista_preview'])->name('fronted.hotspot.preview');

Route::post('hotspot-zona/{id}',[ZonaController::class,'hotspot_zona'])->name('zonas.hotspot_zona');
Route::get('alogin/{id}',[ZonaController::class,'alogin'])->name('zonas.alogin');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('zonas/{id}/descargar/login',[ZonaController::class,'descargar_login'])->name('descargar.login');
    Route::get('zonas/{id}/descargar/alogin',[ZonaController::class,'descargar_alogin'])->name('descargar.alogin');

   

    Route::resource('tiendas',TiendaController::class);
    Route::resource('tienda-categorias',CategoriaTiendaController::class);
    Route::resource('tienda-producto',ProductoController::class);
    Route::resource('banners',CarruselController::class);
    Route::resource('giros',CategoriaController::class);
    Route::resource('hotspots',HotspotController::class);
    Route::resource('telefonos',TelefonoController::class);
    Route::resource('blog',BlogController::class);
    Route::resource('zonas',ZonaController::class);
    Route::resource('imagen-hotspot',ImagenHotspotController::class);


    
    

    
});




///t/{{ $producto->tienda_id }}/producto/{{$producto->id}}

Route::get('/cart',[CarritoController::class,'cartList'])->name('carrito.lista');
Route::post('/cart',[CarritoController::class,'addToCart'])->name('carrito.store');


