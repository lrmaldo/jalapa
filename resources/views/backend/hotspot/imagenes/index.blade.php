<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Imagenes para  Hotspot') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-5 lg:px-4">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mx-1 p-3">
              

                <table id="tabla_imagenes" class="display  " style="width:100%">
                    <a href="javascript:void(0);" onclick="agregarImagen();" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mb-3" >Agregar Imagen</a>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Estatus</th>
                            <th>Imagen</th>
                            <th>Zonas</th>
                            <th></th>
                        </tr>
                    </thead>
                   
                </table>
            </div>
        </div>
    </div>

    <style>
        .select2-selection__rendered {
            line-height: 31px !important;
        }
    
        .select2-container .select2-selection--single {
            height: 35px !important;
        }
    
        .select2-selection__arrow {
            height: 34px !important;
        }
        .select2-selection__rendered{
            height: 40px !important;
            line-height: 32px !important;
        }
        .select2-container--open {
        z-index: 99999999999999;
        }
    </style>

    <script>
        let url_get = "{!! route('api.hotpots.imagenes') !!}";

        let zonas = {!! json_encode($zonas) !!};

    </script>
    
    <script src="{{asset('js/hotspot/imagenes/index.js')}}" defer></script>

</x-app-layout>