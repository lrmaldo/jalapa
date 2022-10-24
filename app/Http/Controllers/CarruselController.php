<?php

namespace App\Http\Controllers;

use App\Models\Carrusel;
use App\Http\Requests\StoreCarruselRequest;
use App\Http\Requests\UpdateCarruselRequest;

class CarruselController extends Controller
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
     * @param  \App\Http\Requests\StoreCarruselRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarruselRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carrusel  $carrusel
     * @return \Illuminate\Http\Response
     */
    public function show(Carrusel $carrusel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carrusel  $carrusel
     * @return \Illuminate\Http\Response
     */
    public function edit(Carrusel $carrusel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarruselRequest  $request
     * @param  \App\Models\Carrusel  $carrusel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarruselRequest $request, Carrusel $carrusel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carrusel  $carrusel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carrusel $carrusel)
    {
        //
    }
}
