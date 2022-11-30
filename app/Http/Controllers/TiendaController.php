<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use App\Http\Requests\StoreTiendaRequest;
use App\Http\Requests\UpdateTiendaRequest;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Telefono;
use App\Models\User;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

use Illuminate\Support\Str;

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
        $categorias = Categoria::select('id','nombre')->get();
        $users = User::all();
       return view('backend.tiendas.create',compact('categorias','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTiendaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTiendaRequest $request)
    {
      #dd($request->all());
        $url_img= null;
      if($request->hasFile('logo_url')){
        $img = $request->file('logo_url');

        /* comprimir imagen */
        $img = Image::make($img->getRealPath());
        $img->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->orientate();
        $img->stream();
        #$nameFile = Uuid::randomUUID().$request->file('logo_url').getClientOriginalName();
        $nameFile = Str::uuid()->toString().".".$request->file('logo_url')->extension();
        ## $request->file('logo_url')->getClientOriginalName();
        $url_img = Storage::disk('public')->put('images/'.$nameFile,$img,'public');
      }
     
      $tienda = Tienda::create([
        'nombre'=> $request->nombre,
        'direccion' => $request->direccion,
        'latitude'=> $request->lat,
        'longitude' =>$request->long,
        'logo_url'=>!empty($url_img)?"/storage/images/".$nameFile:null,
        'facebook_url'=>$request->facebook_url,
        'tipo_tienda'=>$request->tipo_tienda,
        'categoria_id' =>$request->categoria_id,
        'is_active' =>$request->is_active,
      ]);

      return redirect()->route('tiendas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function show(Tienda $tienda)
    {
        return view('backend.tiendas.show',compact('tienda'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function edit(Tienda $tienda)
    {
        $categorias = Categoria::select('id','nombre')->get();
        $users = User::all();
        return view('backend.tiendas.edit',compact('tienda','categorias', 'users'));
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
        $url_img= null;
      if($request->hasFile('logo_url')){
        $img = $request->file('logo_url');

        !empty($tienda->logo_url)? Storage::delete(Str::replace('/storage','/public',$tienda->logo_url)):null;

        /* comprimir imagen */
        $img = Image::make($img->getRealPath());
        $img->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->orientate();
        $img->stream();
        #$nameFile = Uuid::randomUUID().$request->file('logo_url').getClientOriginalName();
        $nameFile = Str::uuid()->toString().".".$request->file('logo_url')->extension();
        ## $request->file('logo_url')->getClientOriginalName();
        $url_img = Storage::disk('public')->put('images/'.$nameFile,$img,'public');
      }
        
        $tienda->update([
            'nombre'=> $request->nombre,
            'direccion' => $request->direccion,
            'latitude'=> $request->lat,
            'longitude' =>$request->long,
            'logo_url'=>!empty($url_img)?"/storage/images/".$nameFile:null,
            'facebook_url'=>$request->facebook_url,
            'tipo_tienda'=>$request->tipo_tienda,
            'categoria_id' =>$request->categoria_id,
            'is_active' =>$request->is_active,
        ]);
       // $request->session()->put('success',"tienda actualizada");
        return redirect()->route('tiendas.index')->with('message',"Tienda actualizada");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tienda  $tienda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tienda $tienda)
    {
        !empty($tienda->logo_url)? Storage::delete(Str::replace('/storage','/public',$tienda->logo_url)):null;
        
       $tienda->delete();
        return Response::json('Eliminado correctamente',200);
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

            $btn ='<a href="'.route('tiendas.show',$data->id).'" class="text-indigo-500 hover:text-indigo-700 mb-2 mr-2" >Ver </a>';
            $btn .= '<a href="'.route('tiendas.edit',$data->id).'" class="text-indigo-500 hover:text-indigo-700 mb-2 mr-2" >Editar </a>';
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

    public function datatable_telefonos($id){
        $telefonos = Telefono::where('tienda_id',$id)->get();

        return datatables()->of($telefonos)
        ->addColumn('action',function($data){

            
            $btn = '<a href="javascript:void(0);" onclick="edit_telefono(\''.$data->id.'\')" class="text-indigo-500 hover:text-indigo-700 mb-2 mr-2" >Editar </a>';
            $btn .= '<a href="javascript:void(0);" class="text-red-500 hover:text-red-900 mb-2 mr-2" onclick="eliminar_telefono(\'' . $data->id.'\');" >Eliminar </a>';
            return $btn;
        })
        ->editColumn('is_whatsapp',function($data){
            return $data->is_whatsapp?"Sí": "No";
        })
        ->rawColumns(['action'])
        ->toJson();
    }
}
