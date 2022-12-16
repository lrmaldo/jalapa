<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tienda: ' . $tienda->nombre) }}
        </h2>
    </x-slot>

    <script>
        let tienda_id = "{{$tienda->id}}";
    </script>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <x-jet-form-section submit="updateProfileInformation">
                <x-slot name="title">
                    {{ __('Información de la tienda') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Estos son los datos de la tienda') }}
                </x-slot>

                <x-slot name="form">

                    <!-- Name -->
                    <div class="col-span-9 sm:col-span-4">

                        <div class="mt-2 mb-2 p-4">
                            <img src="{{ $tienda->logo_url }}" alt="{{ $tienda->nombre }}"
                                class="rounded h-40 w-40 object-cover">
                        </div>

                        <x-jet-label for="name" value="{{ __('Nombre') }}" />
                        <x-jet-input id="name" type="text" class="mt-1 block w-full"
                            value="{{ $tienda->nombre }}" autocomplete="name" disabled/>
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="direccion" value="{{ __('Direccion') }}" />
                        <x-jet-input id="direccion" type="text" class="mt-1 block w-full"
                           value="{{$tienda->direccion}}"  disabled/>
                        <x-jet-input-error for="direccion" class="mt-2" />
                    </div>
                    {{-- tipo_tienda --}}
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="direccion" value="{{ __('Tipo de tienda') }}" />
                        <x-jet-input id="direccion" type="text" class="mt-1 block w-full"
                           value="{{$tienda->tipo_tienda==1?'Directorio': 'Tienda de productos'}}"  disabled/>
                        <x-jet-input-error for="direccion" class="mt-2" />
                    </div>
                    {{-- Categoria --}}
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="Categoria" value="{{ __('Categoria') }}" />
                        <x-jet-input id="categorias" type="text" class="mt-1 block w-full"
                           value="{{$tienda->categoria->nombre}}" disabled/>
                        <x-jet-input-error for="direccion" class="mt-2" />
                    </div>

                    {{-- facebook --}}
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="facebook" value="{{ __('Facebook') }}" />
                        <x-jet-input id="facebook" type="text" class="mt-1 block w-full"
                           value="{{$tienda->facebook_url}}" disabled/>
                        <x-jet-input-error for="facebook" class="mt-2" />
                    </div>
                    {{-- estatus --}}
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="estatus" value="{{ __('Estatus') }}" />

                        <span class="px-2 inline-flex text-lg leading-5 font-semibold rounded-full   {{$tienda->is_active ? "bg-green-100 text-green-500": " bg-red-100 text-red-500"}}">{{$tienda->is_active == 1 ? "Activo" : "Suspendido" }}</span>
             
                       
                    </div>
                </x-slot>
            </x-jet-form-section>

            <x-jet-section-border />

            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Telefonos</h3>
            
                    <p class="mt-1 text-sm text-gray-600">
                        Agrega y edita  los telefonos de la tienda
                    </p>
                </div>
            
                <div class="px-4 sm:px-0">
                    
                </div>
            </div>
            
                <div class="mt-5 md:mt-0 md:col-span-2">
                    @include('backend.tiendas.telefonos.index',['tiendas'=>$tienda])
                </div>
            </div>
        
            <x-jet-section-border />

            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Categorias</h3>
            
                    <p class="mt-1 text-sm text-gray-600">
                        Agrega y edita  las categorias de productos de esta tienda
                    </p>
                </div>
            
                <div class="px-4 sm:px-0">
                    
                </div>
            </div>
            
                <div class="mt-5 md:mt-0 md:col-span-2">
                    @include('backend.tiendas.categorias.index',['tiendas'=>$tienda])
                </div>
            </div>

            <x-jet-section-border />

            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Productos o servicios</h3>
            
                    <p class="mt-1 text-sm text-gray-600">
                        Agrega y edita  los productos o servicios de esta tienda
                    </p>
                </div>
            
                <div class="px-4 sm:px-0">
                    
                </div>
            </div>
            
                <div class="mt-5 md:mt-0 md:col-span-2">
                    @include('backend.tiendas.productos.index',['tienda'=>$tienda])
                </div>
            </div>

           
        </div>
    </div>
</x-app-layout>
