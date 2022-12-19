<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zonas de hotspot') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-5 lg:px-4">
            <div class="block mb-4">
                <a href="{{ url()->previous() }}" class="bg-gray-200 hover:bg-gray-300 text-black font-bold py-2 px-4 rounded">Regresar</a>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mx-1 p-3">
              

                <table id="tabla_zonas" class="display  " style="width:100%">
                    <a href="javascript:void(0);" onclick="agregarZona();" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mb-3" >Agregar Zona</a>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Preview</th>
                            <th></th>
                        </tr>
                    </thead>
                   
                </table>
            </div>
        </div>
    </div>

    <script>
        let url_get = "{!! route('api.hotpots.zonas') !!}";

    </script>
    
    <script src="{{asset('js/hotspot/zonas/index.js')}}" defer></script>

</x-app-layout>