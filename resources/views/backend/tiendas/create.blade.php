<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agregar Tienda') }}
        </h2>
    </x-slot>
    <style>
        .map-responsive {
            overflow: hidden;
            padding-bottom: 36.25%;
            position: relative;
            height: 0;
        }
        @media screen and (max-width: 600px){
            .map-responsive {
            overflow: hidden;
            padding-bottom: 66.25%;
            position: relative;
            height: 0;
        }   
        }

    </style>
    
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDS9ZIrYxrNhDYACm11Vxaw1c_jhpsvMk"></script>

    <script>
        mapa = {
            map: false,
            marker: false,
            initMap: function() {
                // Creamos un objeto mapa y especificamos el elemento DOM donde se va a mostrar. 18.0709008,-96.5349083
                mapa.map = new google.maps.Map(document.getElementById('mapa'), {
                    center: {
                        lat: 18.0709008,
                        lng: -96.5349083
                    },
                    scrollwheel: false,
                    zoom: 15,
                    zoomControl: true,
                    rotateControl: false,
                    mapTypeControl: true,
                    streetViewControl: false,
                });
                // Creamos el marcador
                mapa.marker = new google.maps.Marker({
                    position: {
                        lat: 18.0709008,
                        lng: -96.5349083
                    },

                    draggable: true
                });
                // Le asignamos el mapa a los marcadores.
                mapa.marker.setMap(mapa.map);
                mapa.marker.addListener('dragend', function(event) {
                    //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
                    document.getElementById("lat").value = this.getPosition().lat();
                    document.getElementById("long").value = this.getPosition().lng();
                });
            },
            // función que se ejecuta al pulsar el botón buscar dirección
            getCoords: function() {
                // Creamos el objeto geodecoder
                var geocoder = new google.maps.Geocoder();
                address = document.getElementById('search').value;
                document.getElementById("coordenadas").innerHTML = 'Coordenadas:   ' + results[0].geometry.location
                    .lat() + ', ' + results[0].geometry.location.lng();
                if (address != '') {
                    // Llamamos a la función geodecode pasandole la dirección que hemos introducido en la caja de texto.
                    geocoder.geocode({
                        'address': address
                    }, function(results, status) {
                        if (status == 'OK') {
                            // Mostramos las coordenadas obtenidas en el p con id coordenadas
                            document.getElementById("coordenadas").innerHTML = 'Coordenadas:   ' + results[
                                0].geometry.location.lat() + ', ' + results[0].geometry.location.lng();
                            // Posicionamos el marcador en las coordenadas obtenidas
                            mapa.marker.setPosition(results[0].geometry.location);
                            // Centramos el mapa en las coordenadas obtenidas
                            mapa.map.setCenter(mapa.marker.getPosition());
                            agendaForm.showMapaEventForm();
                        }
                    });
                }
            }
        }
    </script>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form method="post" action="{{ route('tiendas.store') }}" enctype ='multipart/form-data'>
                    @csrf
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="nombre" class="block font-medium text-sm text-gray-700">Nombre de la tienda</label>
                            <input type="text" placeholder="Nombre de la tienda" name="nombre" id="nombre" class="form-control rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('nombre', '') }}" />
                            @error('nombre')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="usuario" class="block font-medium text-sm text-gray-700">Logo</label>
                            <input type="file" name="logo_url" id="logo_url" class="block w-full text-md text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept="image/png, image/jpeg, image/jpg, image/jiff" >
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="direccion" class="block font-medium text-sm text-gray-700">Direccion</label>
                            <input type="text" name="direccion" id="direccion" class="form-control rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('direccion', '') }}" />
                            @error('usuario')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="ubicacion" class="block font-medium text-sm text-gray-700">Ubicación en el mapa</label>

                            <div class="map-responsive">
                                <div id="mapa" style="width: 100%; height: 350px;"> </div>
                            </div>
                            <input type="hidden" id="lat" class="form-control" name="lat" value="18.0864363"
                                placeholder="Como se llama la tienda" required>
                            <input type="hidden" id="long" class="form-control" name="long" value="-96.1248874"
                                placeholder="Como se llama la tienda" required>

                        </div>

                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="categoria_id" class="block font-medium text-sm text-gray-700">Categoria de tienda</label>
                            <select name="categoria_id" id="categoria_id" class="form-multiselect  rounded-md shadow-sm mt-1 block w-full" >
                                <option disabled selected>Seleccionar</option>
                                @foreach($categorias as  $categoria)
                                    <option value="{{ $categoria->id }}"{{  old('categoria_id', '') ? ' selected' : '' }}>{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>  
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="users" class="block font-medium text-sm text-gray-700">Tipo de tienda</label>
                            <select name="tipo_tienda" id="tipo_tienda" class="form-multiselect  rounded-md shadow-sm mt-1 block w-full" >
                                <option disabled selected>Seleccionar</option>
                                <option value="1">Directorio</option>
                                <option value="2">Tienda con productos </option>
                            </select>
                            @error('tipo_tienda')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="facebook_url" class="block font-medium text-sm text-gray-700">Facebook url</label>
                            <input type="text" name="facebook_url" id="facebook_url" placeholder="https://www.facebook.com/XXXXXXXX" class="form-control rounded-md shadow-sm mt-1 block w-full"
                                   value="{{ old('facebook_url', '') }}" />
                            @error('facebook_url')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="descripcion" class="block font-medium text-sm text-gray-700">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control rounded-md shadow-sm mt-1 block w-full" placeholder="Escribe una descripción de la tienda">{{old('descripcion','')}}</textarea>
                            @error('ip')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>



                        

                        @can('admin')
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <label for="users" class="block font-medium text-sm text-gray-700">Usuario Plataforma</label>
                            <select name="user_id" id="user_id" class="form-multiselect  rounded-md shadow-sm mt-1 block w-full" >
                                @foreach($users as $id => $user)
                                    <option value="{{ $id }}"{{  old('users', '') ? ' selected' : '' }}>{{ $user }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>                            
                        @else
                            <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
                        @endcan

                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button class="inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-yellow-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Crear
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
