<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blogs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-5 lg:px-4">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mx-1 p-3">
              

                <table id="tabla_blogs" class="display  " style="width:100%">
                    <a href="{{route('blog.create')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mb-3" >Agregar Post</a>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Estatus</th>
                            <th>Título</th>
                            {{-- <th>Tipo</th>
                            <th>Estatus</th> --}}
                            <th></th>
                        </tr>
                    </thead>
                   
                </table>
            </div>
        </div>
    </div>

    <script>
        let url_get = "{!! route('api.blogs') !!}";

    </script>
    
    <script src="{{asset('js/blogs/index.js')}}" defer></script>

</x-app-layout>