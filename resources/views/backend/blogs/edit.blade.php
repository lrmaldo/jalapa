<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Post: '.$blog->id) }}
        </h2>
    </x-slot>


    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">

                <form action="{{route('blog.update',$blog->id)}}" method="post" enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf
                    <div class="p-3">
                        <x-jet-label for="titulo" value="{{ __('Título') }}" />
                        <x-jet-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" value="{{old('titulo',$blog->titulo)}}"
                            autocomplete="titulo" />
                        
                        <x-jet-input-error for="titulo" class="mt-2" />
                    </div>
                    <div class="p-3">
                        <x-jet-label for="imagen" value="{{ __('Imagen de portada') }}" />
                        <x-jet-input id="imagen" name="imagen" type="file" class="mt-1 block w-full" value=""
                            accept="image/*" />
                        <x-jet-input-error for="imagen" class="mt-2" />
                    </div>
                    <div class="p-3">
                        <x-jet-label for="direccion" value="{{ __('Contenido') }}" />
                        {{-- <textarea id="contenido" class="mt-1 block w-full" placeholder="Escribe aqui el contenido de tu noticia" rows="10" cols="100"></textarea> --}}
                        <textarea cols="80" id="contenido" class="block w-full mt-1 rounded-md" name="contenido" rows="10">{!!$blog->contenido!!}</textarea>
                        <x-jet-input-error for="contenido" class="mt-2" />
                        {{--  <div class="shadow-sm border border-gray-300 rounded-lg py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-full h-13" 
               name="contenido" id="contenido"></div> --}}
                        
                    </div>
                    <div class="flex p-1">
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-30 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="is_active">
                            <option value="1" {{$blog->is_active==1?'checked':""}}>Guardar y publicar</option>
                            <option value="0" {{$blog->is_active==1?'checked':""}}>Solo guardar</option>
                        </select>
                        <button role="submit" class="p-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mb-2" required>Enviar</button>
                    </div>
                </form>

            </div>



        </div>


        <x-jet-section-border />
        <style>
            .ck-editor__editable {
                min-height: 300px;
            }
            
        </style>

    </div>
    </div>
</x-app-layout>
<script>
    let editor;
    ClassicEditor
        .create(document.querySelector('#contenido'), {
            height: 460,
            width: 700,
            toolbar: {
                items: [
                    'heading', '|',
                    'fontfamily', 'fontsize', '|',
                    'alignment', '|',
                    'fontColor', 'fontBackgroundColor', '|',
                    'bold', 'italic', '|',
                    'link', '|',
                    'outdent', 'indent', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',

                    '|',
                    'blockQuote', '|',
                    'undo', 'redo'
                ],
                shouldNotGroupWhenFull: true
            },
            language: 'es',


        }).then(newEditor => {
            editor = newEditor;
        })
        .catch(error => {
            console.error(error);
        });
</script>
