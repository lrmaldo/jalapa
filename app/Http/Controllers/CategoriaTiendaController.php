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
        Categoria_tienda::create($request->toArray());
        return response()->json(['message'=>'Categoria creado Correctamente']);
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
    public function edit($categoria_tienda)
    {
        $categoria_tienda = Categoria_tienda::find($categoria_tienda);
        //dd($categoria_tienda);
       return response()->json($categoria_tienda);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoria_tiendaRequest  $request
     * @param  \App\Models\Categoria_tienda  $categoria_tienda
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoria_tiendaRequest $request, $categoria_tienda)
    {
       $categoria_tienda = Categoria_tienda::find($categoria_tienda);
       $categoria_tienda->update($request->toArray());
       return response()->json(['message' => 'Categoria de tienda actualizado correctamente'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria_tienda  $categoria_tienda
     * @return \Illuminate\Http\Response
     */
    public function destroy( $categoria_tienda)
    {
       Categoria_tienda::destroy($categoria_tienda);
        #$categoria_tienda->delete();
       return response()->json(['message'=>'Categoria de tienda eliminado correctamente']);
       # return $categoria_tienda;
    }


    public function datatable_tienda_categorias($id){
        $categorias = Categoria_tienda::where('tienda_id', $id)->get();
        return datatables()->of($categorias)
        ->addColumn('action',function($data){

            
            $btn = '<a href="javascript:void(0);" onclick="edit_categoria(\''.$data->id.'\')" class="text-indigo-500 hover:text-indigo-700 mb-2 mr-2" >Editar </a>';
            $btn .= '<a href="javascript:void(0);" class="text-red-500 hover:text-red-900 mb-2 mr-2" onclick="eliminar_categoria(\'' . $data->id.'\');" >Eliminar </a>';
            return $btn;
        })
       
        ->rawColumns(['action','is_active'])
        ->toJson();
    }

    /**
     * @param data_categorias function para obtener el data en json para el formulario de  productos cuando cargue el select 
     */
    public function data_categorias($id){
        $categorias = Categoria_tienda::where('tienda_id',$id)->get();
        return response()->json($categorias);
        
    }
}
