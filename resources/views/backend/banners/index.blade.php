<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tiendas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-5 lg:px-4">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mx-1 p-3">
              

                <table id="tabla_tiendas" class="display  " style="width:100%">
                    <a href="javascript:void(0);" onclick="addBanner();" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mb-3" >Agregar tienda</a>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th></th>
                        </tr>
                    </thead>
                   
                </table>
            </div>
        </div>
    </div>

    <script>
        let url_get = "{!! route('api.banners') !!}";

    </script>
    
    <script src="{{asset('js/banners/index.js')}}" defer></script>

</x-app-layout>