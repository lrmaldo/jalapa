<?php

namespace App\Http\Controllers;

use App\Models\ImagenHotspot;
use App\Http\Requests\StoreImagenHotspotRequest;
use App\Http\Requests\UpdateImagenHotspotRequest;
use App\Models\Zona;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ImagenHotspotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zonas = Zona::select('id','nombre')->get();
      return view('backend.hotspot.imagenes.index',compact('zonas'));
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
     * @param  \App\Http\Requests\StoreImagenHotspotRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImagenHotspotRequest $request)
    {

        //dd($request->zonas);
        $array_zonas  =  explode(",",$request->zonas);
        //dd($array_zonas);
        if(!$request->file('imagen')){
            return response()->json(['message'=>'No se pudo cargar la imaen'],500);
        }
        $img = $request->file('imagen');
        $img = Image::make($img->getRealPath());
        $img->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->orientate();
        $img->stream();
        #$nameFile = Uuid::randomUUID().$request->file('logo_url').getClientOriginalName();
        $nameFile = Str::uuid()->toString() . "." . $request->file('imagen')->extension();
        ## $request->file('logo_url')->getClientOriginalName();
        $url_img = Storage::disk('public')->put('images/hotspot/' . $nameFile, $img, 'public');
        $imagen = ImagenHotspot::create([
            'imagen_url'=>'/storage/images/hotspot/'.$nameFile,
        ]);
        //dd($array_zonas);
        foreach ( $array_zonas as $key => $value ){
            $imagen->zonas()->attach($value);
        }       


        return response()->json(['message' =>'Imagen Subida Correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImagenHotspot  $imagenHotspot
     * @return \Illuminate\Http\Response
     */
    public function show(ImagenHotspot $imagenHotspot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ImagenHotspot  $imagenHotspot
     * @return \Illuminate\Http\Response
     */
    public function edit( $imagenHotspot)
    {
       //dd($imagenHotspot->with('zonas'));
       $imagenHotspot = ImagenHotspot::with('zonas')->find($imagenHotspot);
        return response()->json($imagenHotspot);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateImagenHotspotRequest  $request
     * @param  \App\Models\ImagenHotspot  $imagenHotspot
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImagenHotspotRequest $request, ImagenHotspot $imagenHotspot)
    {
        #dd($request->all());
        if($request->file('imagen')){
            Storage::delete(Str::replace('/storage', '/public', $imagenHotspot->imagen_url));
            $img = $request->file('imagen');
            $img = Image::make($img->getRealPath());
            $img->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
            })->orientate();
            $img->stream();
        #$nameFile = Uuid::randomUUID().$request->file('logo_url').getClientOriginalName();
            $nameFile = Str::uuid()->toString() . "." . $request->file('imagen')->extension();
        ## $request->file('logo_url')->getClientOriginalName();
            $url_img = Storage::disk('public')->put('images/hotspot/' . $nameFile, $img, 'public');
            $imagenHotspot->update([
                'imagen_url'=> '/storage/images/hotspot/' . $nameFile,
            ]);
        }

        //dd($request->is_active);
        $is_active = $request->is_active === "true"? true : false;
        $imagenHotspot->update([
            'is_active'=>$is_active,
        ]);
        //$array_zonas  =  explode(",",$request->zonas);
        #dd($request->all());
        $imagenHotspot->zonas()->sync(json_decode($request->zonas));

        return response()->json(['message'=>'Publicidad actualizada correctamente']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImagenHotspot  $imagenHotspot
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImagenHotspot $imagenHotspot)
    {
        Storage::delete(Str::replace('/storage', '/public', $imagenHotspot->imagen_url));
        $imagenHotspot->delete();
        return response()->json(['message'=>'Imagen de  Hotspot Eliminado Correctamente'],200);
    }

    public function datatable_imagenes(){
        $imagenes = ImagenHotspot::all();
        

        return datatables()->of($imagenes)
        ->addColumn('estatus',function ($data){
            $html = $data->is_active==true ?'<span class="inline-block bg-verde-500 rounded-full px-3 py-1 text-sm font-semibold text-green-500 mr-2">Activo</span>':
            '<span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-500 bg-rojo-600 rounded-full">Suspendido</span>';
           /*  $html .= '<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-green-500 mr-2">'.$data->is_active?'Activo':'Suspendido'."</span></div>"; */
            
            
            return $html;
        })
        ->addColumn('action', function ($data) {


            $btn = '<a href="javascript:void(0);" onclick="edit_imagen(\'' . $data->id . '\')" class="text-indigo-500 hover:text-indigo-700 mb-2 mr-2" >Editar </a>';
            $btn .= '<a href="javascript:void(0);" class="text-red-500 hover:text-red-900 mb-2 mr-2" onclick="eliminar_imagen(\'' . $data->id . '\');" >Eliminar </a>';
            return $btn;
        })
        ->addColumn('imagen', function ($data) {
            $html = "<div class='mt-2 mb-2 p-4'>
        <img src='" . $data->imagen_url . "' alt='imagen_" . $data->id . "'
            class='rounded h-40 w-40 object-cover'>
        </div>";
            return $html;
        })
        ->addColumn('zonas', function ($data) {
            $html ='<div class="px-6 py-4 whitespace-normal text-sm text-gray-900  divide-y divide-gray-200">'; 
            foreach ($data->zonas as $item){
                $html .= '<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">'.$item->nombre."</span>";
            }
            $html.= '</div>';
            return $html;
        })
        ->rawColumns(['action', 'imagen','zonas','estatus'])
        ->toJson();

    }
}
