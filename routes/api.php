<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CarruselController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CategoriaTiendaController;
use App\Http\Controllers\ImagenHotspotController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\ZonaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('tiendas/all',[TiendaController::class,'datatable_tienda'])->name('api.tiendas');

Route::get('telefonos/{id}',[TiendaController::class,'datatable_telefonos'])->name('api.telefonos');
Route::get('tienda/{id}/categorias',[CategoriaTiendaController::class,'datatable_tienda_categorias'])->name('api.tienda.categorias');
Route::get('tienda/{id}/categorias/all',[CategoriaTiendaController::class,"data_categorias"])->name('api.tienda.categorias.all');
Route::get('tienda/{id}/productos',[ProductoController::class,'datatable_tienda_productos'])->name('api.tienda.productos');

Route::get('giros/all',[CategoriaController::class,'datatable_categorias'])->name('api.giros');
Route::get('banners/all',[CarruselController::class,'datatable_banners'])->name('api.banners');
Route::get('blog/all',[BlogController::class,'datatable_blogs'])->name('api.blogs');
Route::get('hotstpot/zonas/all',[ZonaController::class,'datatable_zonas'])->name('api.hotpots.zonas');
Route::get('hotstpot/imagenes/all',[ImagenHotspotController::class,'datatable_imagenes'])->name('api.hotpots.imagenes');