<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use App\Http\Requests\StoreZonaRequest;
use App\Http\Requests\UpdateZonaRequest;
use Illuminate\Support\Facades\Session;

class ZonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.hotspot.zonas.index');
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
     * @param  \App\Http\Requests\StoreZonaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreZonaRequest $request)
    {
       # dd($request->all());
       Zona::create([
        'nombre'=>$request->nombre
       ]);
       Session::flash('mensaje','Zona Creado');
       return response()->json(['message'=>'Zona Creado correctamente'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function show(Zona $zona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function edit(Zona $zona)
    {
        return response()->json($zona);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateZonaRequest  $request
     * @param  \App\Models\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateZonaRequest $request, Zona $zona)
    {
        $zona->update([
            'nombre'=>$request->nombre
        ]);
        return response()->json(['message' => 'Zona actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zona $zona)
    {
        $zona->delete();
        return response()->json(['message'=>'Zona Eliminada Correctamente'],200);
    }

    public function datatable_zonas(){
        $zonas = Zona::all();


        return datatables()->of($zonas)
        ->addColumn('action', function ($data) {


            $btn = '<a href="javascript:void(0);" onclick="edit_zona(\'' . $data->id . '\')" class="text-indigo-500 hover:text-indigo-700 mb-2 mr-2" >Editar </a>';
            $btn .= '<a href="javascript:void(0);" class="text-red-500 hover:text-red-900 mb-2 mr-2" onclick="eliminar_zona(\'' . $data->id . '\');" >Eliminar </a>';
            return $btn;
        })
        ->addColumn('preview', function ($data) {
            $html = "<span ><a href='' target='_blank'>$data->id</a></span>";
            return $html;
        })
        ->rawColumns(['action', 'preview'])
        ->toJson();
    }
    /*  ->addColumn('imagen', function ($data) {
         $html = "<div class='mt-2 mb-2 p-4'>
     <img src='" . $data->imagen_url . "' alt='imagen_" . $data->id . "'
         class='rounded h-40 w-40 object-cover'>
     </div>";
         return $html;
     }) */
}
