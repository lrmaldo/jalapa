<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}

    <div class="relative max-w-3xl px-4 mx-auto mt-10 sm:px-6">
        <div class='relative w-full max-w-xl mx-auto bg-white rounded-full h-18 lg:max-w-none'>
            <input placeholder="ejemplo Jalapa"
                class="rounded-full w-full h-14 bg-transparent py-0 pl-8 pr-32 outline-none border-2 border-gray-100 shadow-md hover:outline-none focus:ring-rojo-400 focus:border-rojo-400"
                type="text" name="query" id="query" wire:model.debounce.300ms='search' />

            <button type='button'
                class='absolute inline-flex items-center h-12 px-3 py-0 text-sm text-white transition duration-150  ease-in-out rounded-full outline-none right-1 top-1 bg-yellow-600 sm:px-6 sm:text-base sm:font-medium hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cool-indigo-500'>
                <svg class='-ml-0.8 sm:-ml-1 mr-3 w-4 h-4 sm:h-5 sm:w-5' xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Buscar
            </button>
        </div>
    </div>

    <div class="max-w-3xl px-4 pt-8 mx-auto lg:max-w-screen-xl sm:pt-10 sm:px-6 lg:px-8">
        <div class='flex flex-row flex-wrap items-center justify-between'>
            <div class="sm:w-1/2 lg:w-1/3">
                <p>Ordenar:</p>
                <select
                    class="mt-1 block w-1/2 rounded-md border border-gray-300 bg-white py-2 px-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                    wire:model='direction'>
                    <option value="desc">Descendente</option>
                    <option value="asc">Ascendente</option>
                </select>
            </div>

            <div class="order-last w-full pt-4 mt-4 border-t border-gray-200 lg:border-0 lg:mt-0 lg:pt-0 lg:order-none lg:w-2/3 sm:flex sm:flex-col sm:align-center">
                <p class="mb-2 text-center font-medium">Categorías:
                    <span class="text-sm font-normal text-gray-500">
                        {{ $select_categoria !== null ? '(Filtrando por: ' . collect($categorias)->firstWhere('id', $select_categoria)->nombre . ')' : '' }}
                    </span>
                </p>
                <div class="relative self-center bg-gray-100 rounded-lg p-1 flex flex-wrap gap-1">
                    <button type="button"
                        class="text-center {{ $select_categoria === null ? 'bg-white shadow-sm font-semibold' : 'hover:bg-gray-200' }} border-gray-200 flex justify-center relative w-auto rounded-lg py-2 px-4 text-sm text-gray-700 whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-cool-indigo-400 focus:z-10"
                        wire:click="$set('select_categoria', null)">
                        Todos
                    </button>

                    @foreach($categorias as $categoria)
                        <button type="button"
                            class="text-center {{ (int)$select_categoria === (int)$categoria->id ? 'bg-white shadow-sm font-semibold' : 'hover:bg-gray-200' }} border-gray-200 flex justify-center relative w-auto rounded-lg py-2 px-4 text-sm text-gray-700 whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-cool-indigo-400 focus:z-10"
                            wire:click="$set('select_categoria', {{ $categoria->id }})">
                            {{ $categoria->nombre }}
                        </button>
                    @endforeach
                </div>

                @if($select_categoria !== null || !empty($search))
                    <div class="text-center mt-2">
                        <button type="button"
                            class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300"
                            wire:click="resetFilters">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Limpiar filtros
                        </button>
                    </div>
                @endif
            </div>

            <div class='sm:w-1/2 lg:w-1/3'>
                <div class='ml-auto sm:w-52'></div>
            </div>
        </div>
    </div>

    {{-- resultados --}}
    <div class='max-w-lg px-4 pt-12 mx-auto md:max-w-screen-2xl md:px-6 xl:px-8 2xl:px-12'>
        <div>
            <div class="mb-4 text-center">
                <p class="text-lg text-gray-600">Mostrando {{ count($tiendas) }} resultado(s)</p>
            </div>

            <div id="resources" class='grid gap-6 mx-auto md:grid-cols-2 lg:grid-cols-3 xl:gap-8 2xl:gap-12'>
                @forelse ($tiendas as $tienda)
                    <div>
                        <div class="flex flex-col w-full overflow-hidden bg-gray-100 rounded-2xl h-72 sm:h-80 md:h-72 lg:h-64 xl:h-80">
                            <div
                                class="relative flex items-center justify-center flex-shrink-0 h-full group ">
                                <img class=" w-9/10 sm:w-10/12 lg:w-9/10 xl:w-10/12 h-auto rounded-lg shadow-md mx-auto object-cover object-left-top transition ease-in-out duration-300"

                                     src="{{ asset($tienda->logo_url) }}" />
                                <div
                                    class='absolute inset-0 transition duration-200 bg-gray-900 opacity-0 rounded-2xl group-hover:opacity-60'>
                                </div>
                                <div
                                    class='absolute inset-0 flex flex-col items-center justify-center transition duration-200 opacity-0 group-hover:opacity-100'>
                                    <div class='shadow-sm w-33 rounded-2xl'>
                                        <a class="w-full justify-center inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-2xl shadow-sm text-white transition duration-150 bg-cool-indigo-600 hover:bg-amarillo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cool-indigo-500"
                                            href="/t/{{ $tienda->id }}">Ver tienda</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex flex-col justify-between flex-1 p-6">
                                <div class="flex-1">
                                    <a class="block group" href="/t/{{ $tienda->id }}">
                                        <div class='flex items-center justify-between'>
                                            <h3
                                                class="flex items-center text-xl font-bold leading-7 text-gray-900 group-hover:text-cool-indigo-600">
                                                {{ $tienda->nombre }}
                                            </h3>
                                            <span
                                                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-bold font-display bg-cool-indigo-200 text-cool-indigo-800">
                                                {{ $tienda->categoria->nombre }}
                                            </span>
                                        </div>
                                        <p class="mt-1 text-base font-medium leading-6 text-gray-500">
                                            {{ $tienda->direccion }}
                                        </p>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h2 class="mt-4 text-xl font-medium text-gray-900">No se encontraron resultados</h2>
                        <p class="mt-2 text-gray-600">Intenta con otra búsqueda o categoría</p>
                        <button wire:click="resetFilters" class="mt-4 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                            Ver todas las tiendas
                        </button>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
