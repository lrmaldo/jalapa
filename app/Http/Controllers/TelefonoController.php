<?php

namespace App\Http\Controllers;

use App\Models\Telefono;
use App\Http\Requests\StoreTelefonoRequest;
use App\Http\Requests\UpdateTelefonoRequest;
use App\Models\Tienda;
use Illuminate\Http\Response;

class TelefonoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $tienda = Tienda::find($id);
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
     * @param  \App\Http\Requests\StoreTelefonoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTelefonoRequest $request)
    {
       Telefono::create($request->all());
       return response()->json(['message' => 'Telefono Creado Correctamente'],200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Telefono  $telefono
     * @return \Illuminate\Http\Response
     */
    public function show(Telefono $telefono)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Telefono  $telefono
     * @return \Illuminate\Http\Response
     */
    public function edit(Telefono $telefono)
    {
        return response()->json($telefono);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTelefonoRequest  $request
     * @param  \App\Models\Telefono  $telefono
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTelefonoRequest $request, Telefono $telefono)
    {
       $telefono->update($request->all());
       return response()->json(['message' =>"Teléfono Actualizado Correctamente"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Telefono  $telefono
     * @return \Illuminate\Http\Response
     */
    public function destroy(Telefono $telefono)
    {
       $telefono->delete();
       return response()->json(['message' =>"Telefono Eliminado Correctamente"]);
    }
}
