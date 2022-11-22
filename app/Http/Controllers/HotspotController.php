<?php

namespace App\Http\Controllers;

use App\Models\Hotspot;
use App\Http\Requests\StoreHotspotRequest;
use App\Http\Requests\UpdateHotspotRequest;

class HotspotController extends Controller
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
     * @param  \App\Http\Requests\StoreHotspotRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHotspotRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hotspot  $hotspot
     * @return \Illuminate\Http\Response
     */
    public function show(Hotspot $hotspot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hotspot  $hotspot
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotspot $hotspot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHotspotRequest  $request
     * @param  \App\Models\Hotspot  $hotspot
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHotspotRequest $request, Hotspot $hotspot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hotspot  $hotspot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotspot $hotspot)
    {
        //
    }
}
