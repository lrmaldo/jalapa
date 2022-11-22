<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use App\Http\Requests\StoreTiendaRequest;
use App\Http\Requests\UpdateTiendaRequest;
use App\Models\Producto;

class TiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.tiendas.index');
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
     * @param  \App\Http\Requests\StoreTiendaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTiendaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function show(Tienda $tienda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function edit(Tienda $tienda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTiendaRequest  $request
     * @param  \App\Models\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTiendaRequest $request, Tienda $tienda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tienda $tienda)
    {
        //
    }

    public function vista_frontend($id){
        $tienda = Tienda::find($id);
        //dd($tienda->id);
        return view('tienda.frontend',compact('tienda'));
    }

    public function vista_producto($id_tienda, $id){
        #return Producto::find($id);
        $producto = Producto::find($id);
        return view('tienda.detalle-producto',compact('producto'));
    }


    /* api  */
    public function datatable_tienda(){


        $tiendas = Tienda::all();

        return datatables()->of($tiendas)
        ->addColumn('action',function($data){
            $btn = '<a href="'.route('tiendas.edit',$data->id).'" class="text-indigo-500 hover:text-indigo-700 mb-2 mr-2" >Editar </a>';
            $btn .= '<a href="javascript:void(0);" class="text-red-500 hover:text-red-900 mb-2 mr-2" onclick="eliminar(\'' . $data->id.'\');" >Eliminar </a>';
            return $btn;
        })
        ->addColumn('categoria',function($data){
            return $data->categoria->nombre;
        })
        ->addColumn('estatus',function($data){
            return $data->is_active ?
            '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full  bg-green-100 text-green-500">Activo</span>'
             : '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full  bg-red-100 text-red-500">Suspendido</span>';
             
        })
        ->addColumn('tipo',function($data){
            return $data->tipo_tienda;
        })
        ->rawColumns(['action','estatus'])
        ->toJson();
    }
}
