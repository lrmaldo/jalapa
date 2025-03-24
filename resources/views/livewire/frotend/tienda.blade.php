<div>
    <div class="bg-gradient-to-b from-amber-50 to-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    <span class="block">Nuestros Productos y Servicios</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Descubra nuestra selección de productos y servicios tecnológicos de alta calidad
                </p>
            </div>
        </div>
    </div>

    <!-- Buscador mejorado -->
    <div class="relative max-w-3xl px-4 mx-auto -mt-6 sm:px-6">
        <div class="relative w-full max-w-xl mx-auto bg-white rounded-full shadow-lg h-18 lg:max-w-none">
            <div class="flex items-center">
                <input placeholder="Buscar productos o servicios..."
                    class="rounded-full w-full h-14 bg-transparent py-0 pl-8 pr-32 outline-none border-2 border-amber-100 hover:outline-none focus:ring-amber-400 focus:border-amber-400 transition-all duration-300"
                    type="text" name="query" id="query" wire:model.debounce.300ms='search' autocomplete="off" />

                <button type='submit'
                    class="absolute inline-flex items-center h-12 px-6 py-0 text-sm text-white transition duration-300 ease-in-out rounded-full outline-none right-1 top-1 bg-amber-500 sm:text-base sm:font-medium hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    <svg class="mr-2 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Buscar
                </button>
            </div>

            <!-- Indicador de búsqueda -->
            <div wire:loading wire:target="search" class="absolute left-1/2 -bottom-8 transform -translate-x-1/2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Buscando...
                </span>
            </div>
        </div>
    </div>

    <!-- Filtros y ordenación -->
    <div class="max-w-7xl px-4 pt-12 mx-auto lg:max-w-screen-xl sm:pt-10 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row flex-wrap items-center justify-between gap-6">
            <!-- Ordenación -->
            <div class="w-full md:w-auto">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <label for="orderby" class="text-sm font-medium text-gray-700">Ordenar por:</label>
                    <div class="relative">
                        <select id="orderby"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm rounded-md"
                            wire:model='direction'>
                            <option value="desc">Precio: Mayor a menor</option>
                            <option value="asc">Precio: Menor a mayor</option>
                            <option value="newest">Más recientes</option>
                            <option value="oldest">Más antiguos</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Menú desplegable de categorías (visible solo en móvil) -->
            <div class="w-full md:hidden">
                <label for="categoria-mobile" class="block text-sm font-medium text-gray-700">Seleccionar categoría</label>
                <select id="categoria-mobile"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:ring-amber-500 focus:border-amber-500 sm:text-sm rounded-md"
                        wire:model="select_categoria">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro por categorías con scroll horizontal (visible en pantallas medianas y grandes) -->
            <div class="w-full hidden md:block flex-grow relative">
                <!-- Indicador de scroll a la izquierda -->
                <div class="absolute left-0 top-0 bottom-0 w-8 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>

                <div class="bg-white rounded-lg shadow-sm p-1 overflow-x-auto scrollbar-thin scrollbar-thumb-amber-300 scrollbar-track-gray-100">
                    <div class="flex space-x-1 min-w-max px-2">
                        <button wire:click="resetFilters"
                            class="flex-shrink-0 px-4 py-2 text-sm font-medium rounded-md whitespace-nowrap transition-all duration-200 {{ $select_categoria == null ? 'bg-amber-500 text-white shadow-sm' : 'text-gray-700 hover:bg-amber-100' }}">
                            Todos
                        </button>

                        @forelse($categorias as $categoria)
                            <button wire:click="seleccionarCategoria({{ $categoria->id }})"
                                class="flex-shrink-0 px-4 py-2 text-sm font-medium rounded-md whitespace-nowrap transition-all duration-200 {{ $select_categoria == $categoria->id ? 'bg-amber-500 text-white shadow-sm' : 'text-gray-700 hover:bg-amber-100' }}">
                                {{ $categoria->nombre }}
                            </button>
                        @empty
                            <span class="px-4 py-2 text-sm text-gray-500 italic">No hay categorías disponibles</span>
                        @endforelse
                    </div>
                </div>

                <!-- Indicador de scroll a la derecha -->
                <div class="absolute right-0 top-0 bottom-0 w-8 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>
            </div>
        </div>

        <!-- Indicador de filtros activos -->
        @if($search || $select_categoria)
            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span class="text-sm font-medium text-gray-500">Filtros activos:</span>

                @if($search)
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                        Búsqueda: "{{ $search }}"
                        <button wire:click="$set('search', '')" class="ml-1 text-amber-600 hover:text-amber-800 focus:outline-none">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                @endif

                @if($select_categoria)
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                        Categoría: {{ $categorias->firstWhere('id', $select_categoria)->nombre ?? '' }}
                        <button wire:click="resetFilters" class="ml-1 text-amber-600 hover:text-amber-800 focus:outline-none">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                @endif

                <button
                    wire:click="$set('search', ''); resetFilters()"
                    class="text-sm text-amber-600 hover:text-amber-800 ml-2 focus:outline-none">
                    Limpiar todos
                </button>
            </div>
        @endif
    </div>

    <!-- Grid de productos mejorado -->
    <div class="max-w-7xl px-4 pt-8 pb-16 mx-auto lg:max-w-screen-xl sm:px-6 lg:px-8">
        <!-- Estado de carga para los productos -->
        <div wire:loading wire:target="seleccionarCategoria, resetFilters, direction" class="w-full flex justify-center py-12">
            <div class="flex flex-col items-center">
                <svg class="animate-spin h-10 w-10 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-3 text-sm text-gray-500">Cargando productos...</p>
            </div>
        </div>

        <div wire:loading.remove wire:target="seleccionarCategoria, resetFilters, direction">
            <!-- Mensaje cuando no hay resultados -->
            @if($productos->isEmpty())
                <div class="py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No se encontraron productos</h3>
                    <p class="mt-1 text-sm text-gray-500">Intente con otros términos de búsqueda o filtros.</p>
                    <div class="mt-6">
                        <button
                            wire:click="$set('search', ''); resetFilters()"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Ver todos los productos
                        </button>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-6 gap-y-10">
                    @foreach ($productos as $producto)
                        <div class="group relative bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-300">
                            <div class="aspect-w-4 aspect-h-3 bg-gray-200 group-hover:opacity-90">
                                <img class="w-full h-64 object-cover object-center"
                                    src="{{ asset($producto->imagen_url) }}"
                                    alt="{{ $producto->nombre }}" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <a href="/t/{{ $producto->tienda_id }}/producto/{{$producto->id}}"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md shadow-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 border border-amber-400 transform hover:scale-105 transition-all">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Ver detalles
                                    </a>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-lg font-medium text-gray-900 truncate group-hover:text-amber-600 transition-colors duration-200">
                                        {{ $producto->nombre }}
                                    </h3>
                                    <p class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        ${{ number_format($producto->precio,2) }}
                                    </p>
                                </div>
                                <p class="mt-1 text-sm text-gray-500 line-clamp-2">
                                    {{ $producto->descripcion }}
                                </p>
                                <div class="mt-3 flex items-center justify-between">
                                    @if($producto->categoria_id)
                                        <span class="text-xs text-gray-500">
                                            {{ $categorias->firstWhere('id', $producto->categoria_id)->nombre ?? 'Sin categoría' }}
                                        </span>
                                    @endif
                                    <a href="/t/{{ $producto->tienda_id }}/producto/{{$producto->id}}"
                                        class="text-sm font-medium text-amber-600 hover:text-amber-700">
                                        Más información &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Paginación mejorada -->
        <div class="mt-10">
            {{ $productos->links() }}
        </div>
    </div>
</div>

<style>
    /* Estilos para la barra de desplazamiento personalizada */
    .scrollbar-thin::-webkit-scrollbar {
        height: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #fdba74;
        border-radius: 10px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #f97316;
    }

    /* Para Firefox */
    .scrollbar-thin {
        scrollbar-width: thin;
        scrollbar-color: #fdba74 #f1f1f1;
    }
</style>

<script>
    // Script para detectar cuando el scroll ha llegado al final o al inicio
    document.addEventListener('DOMContentLoaded', function() {
        const scrollContainer = document.querySelector('.scrollbar-thin');
        const leftGradient = document.querySelector('.bg-gradient-to-r');
        const rightGradient = document.querySelector('.bg-gradient-to-l');

        if (scrollContainer && leftGradient && rightGradient) {
            // Inicialización
            checkScroll();

            // Comprobar durante el scroll
            scrollContainer.addEventListener('scroll', checkScroll);

            function checkScroll() {
                // El scroll está al principio
                if (scrollContainer.scrollLeft <= 10) {
                    leftGradient.classList.add('opacity-0');
                } else {
                    leftGradient.classList.remove('opacity-0');
                }

                // El scroll está al final
                if (scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth - 10) {
                    rightGradient.classList.add('opacity-0');
                } else {
                    rightGradient.classList.remove('opacity-0');
                }
            }
        }
    });
</script>
