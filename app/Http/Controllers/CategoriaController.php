<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.tiendas.categorias.index');
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
     * @param  \App\Http\Requests\StoreCategoriaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoriaRequest $request)
    {
        Categoria::create($request->all());
        return response()->json(['message' => 'Giro Agregado Correctamente'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit($categoria)
    {
        $categoria = Categoria::find($categoria);
      return response()->json($categoria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoriaRequest  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
       $categoria->update($request->all());
       return response()->json(['message' => 'Giro Actualizado Correctamente'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($categoria)
    {
      Categoria::destroy($categoria);
       return response()->json(['message' => 'Giro Eliminado Correctamente'], 200);
    }

    public function datatable_categorias(){
         $categorias = Categoria::all();
        return datatables()->of($categorias)
        ->addColumn('action',function($data){

            
            $btn = '<a href="javascript:void(0);" onclick="edit_giro(\''.$data->id.'\')" class="text-indigo-500 hover:text-indigo-700 mb-2 mr-2" >Editar </a>';
            $btn .= '<a href="javascript:void(0);" class="text-red-500 hover:text-red-900 mb-2 mr-2" onclick="eliminar_giro(\'' . $data->id.'\');" >Eliminar </a>';
            return $btn;
        })
        ->editColumn('is_active',function($data){
            return $data->is_active?"<span class='text-green-500'>Activo</span>": 
            "<span class='text-red-500'>No activo</span>";
        })
        ->rawColumns(['action','is_active'])
        ->toJson();
    }
}


