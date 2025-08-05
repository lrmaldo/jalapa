<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    {{-- Hero Section con búsqueda mejorada --}}
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-indigo-600/10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-4">
                    Descubre
                    <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Jalapa
                    </span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Explora las mejores tiendas y servicios de tu ciudad
                </p>
            </div>

            {{-- Barra de búsqueda mejorada con debounce --}}
            <div class="max-w-2xl mx-auto">
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-300"></div>
                    <div class="relative bg-white rounded-2xl shadow-xl border border-gray-200/50">
                        <input placeholder="¿Qué estás buscando en Jalapa?"
                            class="w-full h-16 px-6 pr-32 text-lg bg-transparent rounded-2xl outline-none placeholder-gray-400 focus:ring-0 border-0"
                            type="text"
                            name="query"
                            id="query"
                            wire:model.debounce.500ms="search"
                            autocomplete="off" />

                        {{-- Indicador de loading en la búsqueda --}}
                        <div class="absolute right-16 top-1/2 transform -translate-y-1/2" wire:loading wire:target="search">
                            <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                        <button type='submit'
                            class='absolute right-2 top-2 h-12 px-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed'
                            wire:loading.attr="disabled"
                            wire:target="search">
                            <svg class='w-5 h-5' xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span class="hidden sm:inline">Buscar</span>
                        </button>
                    </div>
                </div>

                {{-- Indicador de búsqueda activa --}}
                @if($search)
                    <div class="mt-4 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-50 text-blue-700 border border-blue-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Buscando: "{{ $search }}"
                            <button wire:click="$set('search', '')" class="ml-2 text-blue-500 hover:text-blue-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{-- Filtros mejorados --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 p-6">
            <div class='flex flex-col lg:flex-row items-center justify-between gap-6'>

                {{-- Ordenar con loading state --}}
                <div class="w-full lg:w-auto">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Ordenar por:
                        <span wire:loading wire:target="direction" class="inline-flex items-center ml-2">
                            <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </label>
                    <div class="relative">
                        <select class="appearance-none bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 min-w-[180px] disabled:opacity-50"
                            wire:model="direction"
                            wire:loading.attr="disabled"
                            wire:target="direction">
                            <option value="desc">Más recientes</option>
                            <option value="asc">Más antiguos</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Categorías mejoradas con loading states --}}
                <div class="w-full lg:w-auto flex-1 lg:max-w-md">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Categorías:
                        <span wire:loading wire:target="seleccionarCategoria" class="inline-flex items-center ml-2">
                            <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </label>
                    <div class="flex flex-wrap gap-2">
                        <button
                            class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $select_categoria == null ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} disabled:opacity-50"
                            wire:click="resetFilters"
                            wire:loading.attr="disabled"
                            wire:target="resetFilters,seleccionarCategoria">
                            <span wire:loading.remove wire:target="resetFilters">Todos</span>
                            <span wire:loading wire:target="resetFilters" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Cargando...
                            </span>
                        </button>
                        @forelse($categorias as $categoria)
                            <button
                                class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $select_categoria == $categoria->id ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} disabled:opacity-50"
                                wire:click="seleccionarCategoria({{ $categoria->id }})"
                                wire:loading.attr="disabled"
                                wire:target="seleccionarCategoria,resetFilters">
                                <span wire:loading.remove wire:target="seleccionarCategoria({{ $categoria->id }})">
                                    {{ $categoria->nombre }}
                                </span>
                                <span wire:loading wire:target="seleccionarCategoria({{ $categoria->id }})" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Cargando...
                                </span>
                            </button>
                        @empty
                            <p class="text-gray-500 text-sm">Sin categorías disponibles</p>
                        @endforelse
                    </div>
                </div>

                {{-- Contador de resultados --}}
                <div class="w-full lg:w-auto">
                    <div class="text-right">
                        <p class="text-sm text-gray-600">
                            <span class="font-semibold">{{ $tiendas->count() }}</span>
                            {{ $tiendas->count() == 1 ? 'tienda encontrada' : 'tiendas encontradas' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grid de tiendas mejorado con loading overlay --}}
    <div class='max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16'>
        <div class="relative">
            {{-- Loading overlay --}}
            <div wire:loading wire:target="search,seleccionarCategoria,resetFilters,direction"
                 class="absolute inset-0 bg-white bg-opacity-75 backdrop-blur-sm z-10 flex items-center justify-center rounded-2xl">
                <div class="text-center">
                    <svg class="animate-spin h-12 w-12 text-blue-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-gray-600 font-medium">Cargando tiendas...</p>
                </div>
            </div>

            <div data-controller='pagination lazy-loader'>
                <div id="resources" class='grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 transition-opacity duration-300'
                     wire:loading.class="opacity-50"
                     wire:target="search,seleccionarCategoria,resetFilters,direction">
                @forelse ($tiendas as $tienda)
                    <div class="group animate-fade-in">
                        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-blue-200 transform hover:-translate-y-3 hover:shadow-glow">
                            {{-- Imagen de la tienda --}}
                            <div class="relative aspect-square overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                     src="{{ asset($tienda->logo_url) }}"
                                     alt="{{ $tienda->nombre }}"
                                     loading="lazy"
                                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMjAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik02MCA2MEM2MCA1NC40NzcyIDY0LjQ3NzIgNTAgNzAgNTBIMTMwQzEzNS41MjMgNTAgMTQwIDU0LjQ3NzIgMTQwIDYwVjE0MEMxNDAgMTQ1LjUyMyAxMzUuNTIzIDE1MCAxMzAgMTUwSDcwQzY0LjQ3NzIgMTUwIDYwIDE0NS41MjMgNjAgMTQwVjYwWiIgZmlsbD0iI0U1RTdFQiIvPgo8Y2lyY2xlIGN4PSI4NSIgY3k9Ijg1IiByPSIxNSIgZmlsbD0iI0Q1RDlERiIvPgo8cGF0aCBkPSJNNzAgMTIwTDg3LjUgMTAyLjVMMTA1IDEyMEwxMzAgMTMwSDcwVjEyMFoiIGZpbGw9IiNENUQ5REYiLz4KPC9zdmc+Cg=='" />

                                {{-- Overlay con efectos mejorado --}}
                                <div class='absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500'>
                                    <div class='absolute bottom-4 left-4 right-4 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500'>
                                        <a class="block w-full bg-white/95 backdrop-blur-sm text-gray-900 text-center py-3 px-4 rounded-xl font-semibold transition-all duration-300 hover:bg-white hover:scale-105 shadow-xl border border-white/20"
                                           href="/t/{{ $tienda->id }}">
                                            <span class="flex items-center justify-center">
                                                Ver tienda
                                                <svg class="w-4 h-4 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>

                                {{-- Badge de categoría con animación --}}
                                <div class="absolute top-4 right-4 transform transition-transform duration-300 group-hover:scale-110">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg backdrop-blur-sm">
                                        {{ $tienda->categoria->nombre }}
                                    </span>
                                </div>

                                {{-- Indicador de estado --}}
                                <div class="absolute top-4 left-4">
                                    <div class="w-3 h-3 bg-green-400 rounded-full shadow-lg animate-pulse"></div>
                                </div>
                            </div>

                            {{-- Información de la tienda mejorada --}}
                            <div class="p-6 bg-gradient-to-br from-white to-gray-50/50">
                                <a class="block group/link" href="/t/{{ $tienda->id }}">
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover/link:text-blue-600 transition-colors duration-300 line-clamp-1">
                                        {{ $tienda->nombre }}
                                    </h3>
                                    <div class="flex items-start space-x-3 mb-4">
                                        <div class="flex-shrink-0 w-5 h-5 mt-0.5 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-2 flex-1">
                                            {{ $tienda->direccion }}
                                        </p>
                                    </div>
                                </a>

                                {{-- Footer de la tarjeta --}}
                                <div class="pt-4 border-t border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <a href="/t/{{ $tienda->id }}"
                                           class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold text-sm transition-all duration-300 group/btn">
                                            Explorar tienda
                                            <svg class="w-4 h-4 ml-1 transition-transform duration-300 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>

                                        {{-- Rating placeholder --}}
                                        <div class="flex items-center space-x-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Estado vacío mejorado --}}
                    <div class="col-span-full">
                        <div class="text-center py-20 animate-fade-in">
                            <div class="mx-auto w-32 h-32 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mb-8 shadow-soft">
                                <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">No se encontraron tiendas</h3>
                            <p class="text-gray-600 mb-8 max-w-md mx-auto text-lg leading-relaxed">
                                Prueba ajustando tus filtros de búsqueda o explora diferentes categorías para descubrir más opciones.
                            </p>
                            <div class="space-y-4">
                                <button wire:click="resetFilters"
                                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Limpiar filtros
                                </button>
                                <p class="text-sm text-gray-500">
                                    o <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold">contacta con nosotros</a> para agregar tu tienda
                                </p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        </div>
    </div>

    {{-- Footer informativo --}}
    <footer class="bg-gradient-to-r from-gray-900 to-gray-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Jalapa</h3>
                    <p class="text-gray-300 mb-4">
                        Descubre las mejores tiendas y servicios de tu ciudad. Conectamos a los comerciantes locales con su comunidad.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Enlaces útiles</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors duration-200">Cómo funciona</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-200">Registra tu tienda</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-200">Categorías</a></li>
                        <li><a href="#" class="hover:text-white transition-colors duration-200">Soporte</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                    <div class="space-y-2 text-gray-300">
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            contacto@jalapa.com
                        </p>
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            +502 1234-5678
                        </p>
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Jalapa, Guatemala
                        </p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Jalapa. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    {{-- Script para mejoras de UX --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mejorar el focus en el input de búsqueda
            const searchInput = document.getElementById('query');
            if (searchInput) {
                // Auto-focus en escritorio
                if (window.innerWidth > 768) {
                    searchInput.focus();
                }

                // Limpiar con Escape
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        this.value = '';
                        this.dispatchEvent(new Event('input'));
                    }
                });
            }

            // Smooth scroll para resultados después de filtrar
            window.addEventListener('livewire:load', function() {
                Livewire.hook('message.processed', (message, component) => {
                    // Scroll suave a los resultados después de filtrar
                    if (message.updateQueue && message.updateQueue.length > 0) {
                        const resultsSection = document.getElementById('resources');
                        if (resultsSection && window.scrollY > resultsSection.offsetTop - 100) {
                            resultsSection.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                });
            });

            // Lazy loading mejorado para imágenes
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.classList.add('animate-fade-in');
                        observer.unobserve(img);
                    }
                });
            });

            // Observar todas las imágenes de tiendas
            document.querySelectorAll('img[loading="lazy"]').forEach(img => {
                imageObserver.observe(img);
            });
        });

        // Función para mejorar la accesibilidad del teclado
        function handleKeyboardNavigation(event) {
            if (event.key === 'Enter' && event.target.tagName === 'BUTTON') {
                event.target.click();
            }
        }

        // Añadir soporte para navegación por teclado
        document.addEventListener('keydown', handleKeyboardNavigation);
    </script>
</div>
