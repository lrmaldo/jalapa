<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use App\Http\Requests\StoreZonaRequest;
use App\Http\Requests\UpdateZonaRequest;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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
            'nombre' => $request->nombre
        ]);
        Session::flash('mensaje', 'Zona Creado');
        return response()->json(['message' => 'Zona Creado correctamente'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function show(Zona $zona)
    {
        return view('backend.hotspot.zonas.show', compact('zona'));
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
            'nombre' => $request->nombre
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
        return response()->json(['message' => 'Zona Eliminada Correctamente'], 200);
    }

    public function datatable_zonas()
    {
        $zonas = Zona::all();


        return datatables()->of($zonas)
            ->addColumn('action', function ($data) {

                $btn = '<a href="' . route('zonas.show', $data->id) . '"  class="text-indigo-500 hover:text-indigo-700 mb-2 mr-2" >Archivo </a>';
                $btn .= '<a href="javascript:void(0);" onclick="edit_zona(\'' . $data->id . '\')" class="text-indigo-500 hover:text-indigo-700 mb-2 mr-2" >Editar </a>';
                $btn .= '<a href="javascript:void(0);" class="text-red-500 hover:text-red-900 mb-2 mr-2" onclick="eliminar_zona(\'' . $data->id . '\');" >Eliminar </a>';
                return $btn;
            })
            ->addColumn('preview', function ($data) {
                $html = "<span ><a href='/hotspot/preview/$data->id' target='_blank'>" . URL::to('/hotspot/preview/' . $data->id) . "</a></span>";
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

     public function hotspot_zona($id){
        #$imagenes = Zona::where('id',$id)->where('is_active',1)->get()->imagenes()->shuffle();
        $zona = Zona::with('imagenes')->where('id',$id)->whereHas('imagenes',function ($query) {
            $query->where('is_active',1);
        })->first();
        //return $zona;
        return view('frontend.hotspot.index',compact('zona'));
     }
     public function alogin($id){
        return redirect('/');
     }


    public function descargar_login($id)
    {
        $zona = Zona::find($id);
        $login = "assets/zonas/{$zona->id}/login.html";

        /* crear un archivo login.html y guardarlo */
        #$login_html = $this->escribir_archivo($login);
        Storage::disk('public')->put($login, $this->escribir_archivo_login($zona));
        $login = "public/assets/zonas/{$zona->id}/login.html";
        $archivo = Storage::get($login);

        return Response::make($archivo, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="login.html"',
        ]);
    }
    public function descargar_alogin($id)
    {
        $zona = Zona::find($id);
        $alogin = "assets/zonas/{$zona->id}/alogin.html";
        Storage::disk('public')->put($alogin, $this->escribir_archivo_alogin($zona));

        $alogin = "public/assets/zonas/{$zona->id}/alogin.html";
        $archivo = Storage::get($alogin);

        return Response::make($archivo, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="alogin.html'
        ]);
    }

    private function  escribir_archivo_login($zona)
    {
        $txt = '<html>
        <head> <title> ... </title></head> 
            <body>
                $(if chap-id)
                    <noscript>
                    <center><b>Requiere JavaScript. Habilitar JavaScript para continuar.</b></center>
                    </noscript>
                $(endif)  <center>Si no se redirecciona haga en unos segundos haga clic en continue<br>
                <form name="redirect" action="' . URL::to('/hotspot-zona/' . $zona->id) . '" method="post">' .
            ' <input type="hidden" name="mac" value="$(mac)">
                <input type="hidden" name="ip" value="$(ip)">
                <input type="hidden" name="username" value="$(username)">
                <input type="hidden" name="link-login" value="$(link-login)">
                <input type="hidden" name="link-orig" value="$(link-orig)">
                <input type="hidden" name="error" value="$(error)">
                <input type="hidden" name="chap-id" value="$(chap-id)">
                <input type="hidden" name="chap-challenge" value="$(chap-challenge)">
                <input type="hidden" name="link-login-only" value="$(link-login-only)">
                <input type="hidden" name="link-orig-esc" value="$(link-orig-esc)">
                <input type="hidden" name="mac-esc" value="$(mac-esc)">
                <input type="submit" value="continue">
            </form>' . PHP_EOL .
            ' <script language="JavaScript">
            <!--
                document.redirect.submit();
                //-->
            </script></center>
            </body>
        </html>';
        return $txt;
    }

    private function  escribir_archivo_alogin($zona)
    {
        $txt = '<html>
        <head> <title > ... </title></head> 
            <body>
                $(if chap-id)
                    <noscript>
                    <center><b>Requiere JavaScript. Habilitar JavaScript para continuar..</b></center>
                    </noscript>
                $(endif)
            <center>Espere un momento redireccionando... <br>	
            <form name="redirect" action="' . URL::to('/alogin/' . $zona->id) . '" method="get">
              
               <input type="submit" value="continue">
           </form>
       <script language="JavaScript">
       <!--
           document.redirect.submit();
           //-->
       </script></center>
       </body>
   </html>';
        return $txt;
    }
}
