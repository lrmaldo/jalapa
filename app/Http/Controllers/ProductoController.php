<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ProductoController extends Controller
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
     * @param  \App\Http\Requests\StoreProductoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductoRequest $request)
    {
        if(!$request->file('imagen_url')){
            return response()->json(['message'=>'No se pudo cargar la imaen'],500);
        }
        $img = $request->file('imagen_url');
        $img = Image::make($img->getRealPath());
        $img->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->orientate();
        $img->stream();
        #$nameFile = Uuid::randomUUID().$request->file('logo_url').getClientOriginalName();
        $nameFile = Str::uuid()->toString() . "." . $request->file('imagen_url')->extension();
        ## $request->file('logo_url')->getClientOriginalName();
        $url_img = Storage::disk('public')->put('images/tienda/productos/' . $nameFile, $img, 'public');

        Producto::create([
            'nombre'=>$request->nombre,
            'categoria_id'=>$request->categoria_id,
            'descripcion'=>$request->descripcion,
            'existencias'=>$request->existencias,
            'precio'=>$request->precio,
            'imagen_url'=>'/storage/images/tienda/productos/'.$nameFile,
            'tienda_id'=>$request->tienda_id,
        ]);
        return response()->json(['message'=>'Producto creado Correctamente']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit( $producto)
    {
        $producto = Producto::find($producto);
        return response()->json($producto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductoRequest  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductoRequest $request, $producto)
    {
        $producto = Producto::find($producto);
        if($request->file('imagen_url')){
            Storage::delete(Str::replace('/storage', '/public', $producto->imagen_url));
            $img = $request->file('imagen_url');
            $img = Image::make($img->getRealPath());
            $img->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
            })->orientate();
            $img->stream();
        #$nameFile = Uuid::randomUUID().$request->file('logo_url').getClientOriginalName();
            $nameFile = Str::uuid()->toString() . "." . $request->file('imagen_url')->extension();
        ## $request->file('logo_url')->getClientOriginalName();
            $url_img = Storage::disk('public')->put('images/tienda/productos/' . $nameFile, $img, 'public');
            $producto->update([
                'imagen_url'=> '/storage/images/tienda/productos/'.$nameFile,
            ]);
        }
        $producto->update([
            'nombre'=>$request->nombre,
            'categoria_id'=>$request->categoria_id,
            'descripcion'=>$request->descripcion,
            'existencias'=>$request->existencias,
            'precio'=>$request->precio,
            'tienda_id'=>$request->tienda_id,
            'is_active'=>$request->is_active
        ]);
        return response()->json(['message' =>'Producto Actualizado Correctamente']);

       #return $producto;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($producto)
    {
        $producto = Producto::find($producto);
       
        Storage::delete(Str::replace('/storage', '/public', $producto->imagen_url));
        $producto->delete();
        return response()->json(['message'=>'Producto Eliminado Correctamente']);

    }

    public function datatable_tienda_productos($id){
        $productos = Producto::where('tienda_id',$id)->get();
        return datatables()->of($productos)
        ->addColumn('imagen',function($data){
            $html = "<div class='mt-2 mb-2 p-4'>
            <img src='" . $data->imagen_url . "' alt='imagen_" . $data->id . "'
                class='rounded h-20 w-20 object-cover'>
            </div>";
                return $html;

        })
        ->addColumn('categoria',function($data){
            return $data->categoria->nombre;
        })
        ->editColumn('precio',function($data){
            $html ="<span class='text-sm '>Existencias ( ".$data->existencias.")</span> <br/>";
            return $html.number_format($data->precio,2);
        })
        ->addColumn('action',function($data){

            
            $btn = '<a href="javascript:void(0);" onclick="edit_producto(\''.$data->id.'\')" class="text-indigo-500 hover:text-indigo-700 mb-2 mr-2" >Editar </a>';
            $btn .= '<a href="javascript:void(0);" class="text-red-500 hover:text-red-900 mb-2 mr-2" onclick="eliminar_producto(\'' . $data->id.'\');" >Eliminar </a>';
            return $btn;
        })
        ->addColumn('estatus',function($data){
            return $data->is_active? '<span class="inline-block bg-verde-500 rounded-full px-3 py-1 text-sm font-semibold text-green-500 mr-2">Activo</span>':
            '<span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-500 bg-rojo-600 rounded-full">Suspendido</span>';
        })
       
        ->rawColumns(['action','estatus','imagen','precio'])
        ->toJson();
    }
}
