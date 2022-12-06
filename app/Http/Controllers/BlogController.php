<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.blogs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBlogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogRequest $request)
    {
        if (!$request->file('imagen')) {

            return redirect()->back()->withInput()->with('error', "Error al cargar la imagen");
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
        $url_img = Storage::disk('public')->put('images/blogs/' . $nameFile, $img, 'public');


        Blog::create([
            'titulo' => $request->titulo,
            'imagen' => '/storage/images/blogs/' . $nameFile,
            'contenido' => 'contenido',
            'is_active' => $request->is_active,
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->route('blog.index')->with('message', 'Post Creado Correctamente');



        //return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return view('backend.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBlogRequest  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $blog->update([
            'titulo' => $request->titulo,
            # 'imagen'=>'/storage/images/blogs/'.$nameFile,
            'contenido' => 'contenido',
            'is_active' => $request->is_active,
            'user_id' => auth()->user()->id,
        ]);
        if ($request->file('imagen')) {

           Storage::delete(Str::replace('/storage','/public',$blog->imagen));

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
            $url_img = Storage::disk('public')->put('images/blogs/' . $nameFile, $img, 'public');

            $blog->update([
                'imagen'=>'/storage/images/blogs/'.$nameFile
            ]);
        }
        return redirect()->route('blog.index')->with('message','Post actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        Storage::delete(Str::replace('/storage','/public',$blog->imagen));
        $blog->delete();
        return response()->json(['message'=>'Post Eliminado Corrrectamente'],200);
    }

    public function datatable_blogs()
    {
        $blogs = Blog::all();

        return datatables()->of($blogs)
            ->addColumn('action', function ($data) {

                $btn = '<a href="' . route('blog.edit', $data->id) . '"  class="text-indigo-500 hover:text-indigo-700 mb-2 mr-2" >Editar </a>';
                $btn .= '<a href="javascript:void(0);" class="text-red-500 hover:text-red-900 mb-2 mr-2" onclick="eliminar_blog(\'' . $data->id . '\');" >Eliminar </a>';
                return $btn;
            })
            ->addColumn('estatus', function ($data) {
                return $data->is_active ? '<span class="text-green-500">Publicado</span>' :
                    '<span class="text-red-500">No publicado</span>';
            })
            /*  ->addColumn('imagen', function ($data) {
            $html = "<div class='mt-2 mb-2 p-4'>
        <img src='" . $data->imagen_url . "' alt='imagen_" . $data->id . "'
            class='rounded h-40 w-40 object-cover'>
        </div>";
            return $html;
        }) */
            ->rawColumns(['action', 'estatus'])
            ->toJson();
    }
}
