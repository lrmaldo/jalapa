<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Estilos personalizados -->
    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .aspect-square {
            aspect-ratio: 1 / 1;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- Header de la tienda -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $tienda->nombre ?? 'Tienda' }}</h1>
                    <p class="text-gray-600 mt-1">Descubre nuestros productos</p>
                </div>
                <div class="text-right hidden sm:block">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ $productos->total() }} productos
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Buscador mejorado -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input
                    type="text"
                    placeholder="Buscar productos..."
                    wire:model.debounce.300ms="search"
                    class="block w-full pl-12 pr-4 py-4 text-gray-900 placeholder-gray-500 bg-white border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 ease-in-out"
                />
                @if($search)
                    <button
                        wire:click="$set('search', '')"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center">
                        <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    </div>
    <!-- Filtros y ordenamiento mejorados -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">

                <!-- Filtros de categorías -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Categorías</label>
                    <div class="flex flex-wrap gap-2">
                        <button
                            wire:click="resetFilters"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-full transition-all duration-200 {{ $select_categoria == null ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            Todos
                        </button>
                        @forelse($categorias as $categoria)
                            <button
                                wire:click="seleccionarCategoria({{ $categoria->id }})"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-full transition-all duration-200 {{ $select_categoria == $categoria->id ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ $categoria->nombre }}
                            </button>
                        @empty
                            <p class="text-gray-500 text-sm">No hay categorías disponibles</p>
                        @endforelse
                    </div>
                </div>

                <!-- Ordenamiento -->
                <div class="lg:ml-8">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Ordenar por</label>
                    <div class="flex space-x-2">
                        <select
                            wire:model="sort"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                            <option value="id">Fecha</option>
                            <option value="nombre">Nombre</option>
                            <option value="precio">Precio</option>
                        </select>
                        <select
                            wire:model="direction"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                            <option value="desc">Descendente</option>
                            <option value="asc">Ascendente</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Resultados de búsqueda -->
            @if($search || $select_categoria)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            @if($search)
                                Resultados para: <span class="font-semibold">"{{ $search }}"</span>
                            @endif
                            @if($select_categoria)
                                @php
                                    $categoria_seleccionada = $categorias->where('id', $select_categoria)->first();
                                @endphp
                                @if($categoria_seleccionada)
                                    en <span class="font-semibold">{{ $categoria_seleccionada->nombre }}</span>
                                @endif
                            @endif
                            - {{ $productos->total() }} productos encontrados
                        </div>
                        @if($search || $select_categoria)
                            <button
                                wire:click="resetFilters"
                                class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                Limpiar filtros
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Grid de productos mejorado -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        @if($productos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($productos as $producto)
                    <div class="group bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Imagen del producto -->
                        <div class="relative aspect-square bg-gray-100 overflow-hidden">
                            @if($producto->imagen_url)
                                <img
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    src="{{ asset($producto->imagen_url) }}"
                                    alt="{{ $producto->nombre }}"
                                    loading="lazy"
                                />
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Overlay con botón -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center">
                                <a
                                    href="/t/{{ $producto->tienda_id }}/producto/{{ $producto->id }}"
                                    class="bg-white text-gray-900 px-4 py-2 rounded-lg font-medium opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 hover:bg-gray-100">
                                    Ver detalles
                                </a>
                            </div>

                            <!-- Badge de precio -->
                            <div class="absolute top-3 right-3">
                                <span class="bg-blue-600 text-white px-2 py-1 rounded-lg text-sm font-semibold shadow-md">
                                    ${{ number_format($producto->precio, 2) }}
                                </span>
                            </div>
                        </div>

                        <!-- Información del producto -->
                        <div class="p-4">
                            <a href="/t/{{ $producto->tienda_id }}/producto/{{ $producto->id }}" class="block group-hover:text-blue-600 transition-colors duration-200">
                                <h3 class="font-semibold text-gray-900 text-lg mb-2 line-clamp-2">
                                    {{ $producto->nombre }}
                                </h3>
                                <p class="text-gray-600 text-sm line-clamp-3 leading-relaxed">
                                    {{ $producto->descripcion }}
                                </p>
                            </a>

                            <!-- Información adicional -->
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center text-xs text-gray-500">
                                    @if($producto->categoria)
                                        <span class="bg-gray-100 px-2 py-1 rounded-full">
                                            {{ $producto->categoria->nombre }}
                                        </span>
                                    @endif
                                </div>
                                <button
                                    class="text-blue-600 hover:text-blue-800 transition-colors duration-200"
                                    title="Agregar a favoritos">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-8">
                {{ $productos->links() }}
            </div>
        @else
            <!-- Estado vacío mejorado -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron productos</h3>
                    <p class="text-gray-600 mb-6">
                        @if($search || $select_categoria)
                            No hay productos que coincidan con tus filtros de búsqueda.
                        @else
                            Esta tienda aún no tiene productos disponibles.
                        @endif
                    </p>
                    @if($search || $select_categoria)
                        <button
                            wire:click="resetFilters"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Limpiar filtros
                        </button>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Loading state -->
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-25 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 shadow-xl">
            <div class="flex items-center space-x-3">
                <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-900 font-medium">Cargando productos...</span>
            </div>
        </div>
    </div>
</div>
