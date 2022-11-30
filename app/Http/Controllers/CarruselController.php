<?php

namespace App\Http\Controllers;

use App\Models\Carrusel;
use App\Http\Requests\StoreCarruselRequest;
use App\Http\Requests\UpdateCarruselRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class CarruselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.banners.index');
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
        //return dd($request->all());
        if (!$request->file('imagen_url')) {
            return response()->json(['error' => "Fallo al cargar la imagen"], 500);
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
        $url_img = Storage::disk('public')->put('images/banners/' . $nameFile, $img, 'public');
        Carrusel::create([
            'imagen_url' => '/storage/images/banners/' . $nameFile,
        ]);
        return response()->json(['message' => 'Banners Subida Correctamente'], 200);
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarruselRequest  $request
     * @param  \App\Models\Carrusel  $carrusel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarruselRequest $request, $carrusel)
    {
        $carrusel = Carrusel::find($carrusel);
        //dd($carrusel->id);
        //dd($request->all());
        if (!$request->file('imagen_url')) {
            return response()->json(['error' => "Fallo al cargar la imagen"], 500);
        }
        Storage::delete(Str::replace('/storage', '/public', $carrusel->imagen_url));
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
        $url_img = Storage::disk('public')->put('images/banners/' . $nameFile, $img, 'public');
        $carrusel->update([
            'imagen_url' => '/storage/images/banners/' . $nameFile,
        ]);
        return response()->json(['message' => 'Banner Actualizado Correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carrusel  $carrusel
     * @return \Illuminate\Http\Response
     */
    public function destroy($carrusel)
    {
      $carrusel = Carrusel::find($carrusel);
      Storage::delete(Str::replace('/storage', '/public', $carrusel->imagen_url));
      $carrusel->delete();
      return response()->json(['message' => 'Se elimino el banner correctamente'],200);
    }


    /* api de datatable */
    public function datatable_banners()
    {
        $banners = Carrusel::all();

        return datatables()->of($banners)
            ->addColumn('action', function ($data) {


                $btn = '<a href="javascript:void(0);" onclick="edit_banner(\'' . $data->id . '\')" class="text-indigo-500 hover:text-indigo-700 mb-2 mr-2" >Editar </a>';
                $btn .= '<a href="javascript:void(0);" class="text-red-500 hover:text-red-900 mb-2 mr-2" onclick="eliminar_banner(\'' . $data->id . '\');" >Eliminar </a>';
                return $btn;
            })
            ->addColumn('imagen', function ($data) {
                $html = "<div class='mt-2 mb-2 p-4'>
            <img src='" . $data->imagen_url . "' alt='imagen_" . $data->id . "'
                class='rounded h-40 w-40 object-cover'>
            </div>";
                return $html;
            })
            ->rawColumns(['action', 'imagen'])
            ->toJson();
    }
}
