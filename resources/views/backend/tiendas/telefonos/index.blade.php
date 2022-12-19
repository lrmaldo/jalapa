

    <div class="py-12">
       
        <div class="max-w-7xl mx-auto sm:px-5 lg:px-4">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mx-1 p-3">
              

                <table id="tabla_telefonos" class="display  " style="width:100%">
                    <a href="javascript:void(0);" onclick="add_telefono();" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mb-3" >Agregar Teléfono</a>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Teléfono</th>
                            <th>Whatsapp</th>
                            <th></th>
                        </tr>
                    </thead>
                   
                </table>
            </div>
        </div>
    </div>

    <script>
        let url_get = "{!! route('api.telefonos',$tienda->id) !!}";

    </script>
    
    <script src="{{asset('js/tiendas/telefonos/index.js')}}" defer></script>

