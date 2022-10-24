<?php

namespace App\Http\Controllers;

use App\Models\Categoria_tienda;
use App\Http\Requests\StoreCategoria_tiendaRequest;
use App\Http\Requests\UpdateCategoria_tiendaRequest;

class CategoriaTiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoria_tiendaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoria_tiendaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria_tienda  $categoria_tienda
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria_tienda $categoria_tienda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria_tienda  $categoria_tienda
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria_tienda $categoria_tienda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoria_tiendaRequest  $request
     * @param  \App\Models\Categoria_tienda  $categoria_tienda
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoria_tiendaRequest $request, Categoria_tienda $categoria_tienda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria_tienda  $categoria_tienda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria_tienda $categoria_tienda)
    {
        //
    }
}
