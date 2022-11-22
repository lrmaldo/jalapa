<div>
    {{-- In work, do what you enjoy. --}}

    <div>
        {{-- Nothing in the world is as soft and yielding as water. --}}

        <div class="relative max-w-3xl px-4 mx-auto mt-10 sm:px-6">
           

            <div class='relative w-full max-w-xl mx-auto bg-white rounded-full h-18 lg:max-w-none'>
                <input placeholder="ejemplo Jalapa"
                    class="rounded-full w-full h-14 bg-transparent py-0 pl-8 pr-32 outline-none border-2 border-gray-100 shadow-md hover:outline-none focus:ring-rojo-400 focus:border-rojo-400"
                    type="text" name="query" id="query" wire:model='search' />
                {{--  <input type="submit" class="absolute inline-flex items-center h-12 px-4 py-2 text-sm text-white transition duration-150 ease-in-out rouded-full outline-none right-3 top-3 bg-yellow-500" value="Buscar"> --}}
                {{--  <button type="submit"
                        class="absolute inline-flex items-center h-12 px-4 py-2 text-sm text-black transition duration-150  ease-in-out rounded-full outline-none right-3 bg-amarillo-500 sm:px-6">Buscar</button> --}}

                <button type='submit'
                    class='absolute inline-flex items-center h-12 px-3 py-0 text-sm text-white transition duration-150  ease-in-out rounded-full outline-none right-1 top-1 bg-yellow-600 sm:px-6 sm:text-base sm:font-medium hover:bg-cool-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cool-indigo-500'>
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
                    <p>Ordernar:</p>
                    <select
                        class="mt-1 block w-1/2 rounded-md border border-gray-300 bg-white py-2 px-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        wire:model='direction'>
                        <option value="desc">Descendente</option>
                        <option value="asc">Ascendente</option>

                    </select>
                    {{--   {{$direction}} --}}
                </div>



                <div
                    class="order-last w-full pt-4 mt-4 border-t border-gray-200 lg:border-0 lg:mt-0 lg:pt-0 lg:order-none lg:w-1/3 sm:flex sm:flex-col sm:align-center">
                    <div class="relative self-center bg-gray-100 rounded-2lg p-0.5 flex">
                        <a class="{{ $select_categoria == null ? 'bg-white' : '' }} border-gray-200 shadow-sm flex justify-center relative w-1/3 rounded-2lg py-2 text-sm font-medium text-gray-700 whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-cool-indigo-400 focus:z-10 sm:w-1/3 sm:px-8"
                            href="javascript:void(0);" wire:click="resetFilters">Todos</a>
                        @forelse($categorias as $categoria)
                            <a class="border-transparent hover:text-gray-900 flex justify-center relative w-1/3 rounded-2lg py-2 text-sm font-medium text-gray-700 whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-cool-indigo-300 focus:z-10 sm:w-1/3 sm:px-8 ml-0.5"
                                href="javascript:void(0);"
                                wire:click="seleccionarCategoria({{ $categoria->id }})">{{ $categoria->nombre }}</a>

                        @empty
                            <p> sin categorias</p>
                        @endforelse

                    </div>
                </div>

                <div class='sm:w-1/2 lg:w-1/3'>
                    <div class='ml-auto sm:w-52'>

                    </div>
                </div>
            </div>
        </div>

        {{-- resultados --}}



        @forelse ($productos as $producto)
            <div class='max-w-lg px-4 pt-12 mx-auto md:max-w-screen-2xl md:px-6 xl:px-8 2xl:px-12'>
                <div data-controller='pagination lazy-loader'>
                    <div id="resources" class='grid gap-6 mx-auto md:grid-cols-2 lg:grid-cols-3 xl:gap-8 2xl:gap-12'>

                        <div>
                            <div
                                class="flex flex-col w-full overflow-hidden bg-gray-100 rounded-2xl h-72 sm:h-80 md:h-72 lg:h-64 xl:h-80">
                                <div
                                    class="relative flex items-center justify-center flex-shrink-0 h-full group animate-pulse">
                                    <img class="opacity-0 w-9/10 sm:w-10/12 lg:w-9/10 xl:w-10/12 h-auto rounded-lg shadow-md mx-auto object-cover object-left-top transition ease-in-out duration-300"
                                        alt="Banter" data-src="{{ asset($producto->imagen_url) }}"
                                        data-lazy-loader-target="entry" src="" />
                                    <div
                                        class='absolute inset-0 transition duration-200 bg-gray-900 opacity-0 rounded-2xl group-hover:opacity-60'>
                                    </div>
                                    <div
                                        class='absolute inset-0 flex flex-col items-center justify-center transition duration-200 opacity-0 group-hover:opacity-100'>
                                        {{-- <div class='mb-4 shadow-sm w-33 rounded-2xl'>
                                            <a class="inline-flex w-full justify-center items-center px-6 py-2  shadow-sm border border-transparent text-sm font-medium rounded-2xl text-cool-indigo-700 bg-white transition duration-150 hover:bg-cool-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cool-indigo-500"
                                                target="_blank" href="/resources/banter/demo">Preview</a>
                                        </div> --}}
                                        <div class='shadow-sm w-33 rounded-2xl'>
                                            <a class="w-full justify-center inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-2xl shadow-sm text-white transition duration-150 bg-cool-indigo-600 hover:bg-amarillo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cool-indigo-500"
                                                href="/t/{{ $producto->tienda_id }}/producto/{{$producto->id}}">Ver</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex flex-col justify-between flex-1 p-6">
                                    <div class="flex-1">
                                        <a class="block group" href="/t/{{ $producto->tienda_id }}/producto/{{$producto->id}}">
                                            <div class='flex items-center justify-between'>
                                                <h3
                                                    class="flex items-center text-xl font-bold leading-7 text-gray-900 group-hover:text-cool-indigo-600">
                                                    {{ $producto->nombre }}
                                                </h3>
                                                <span
                                                    class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-bold font-display bg-cool-indigo-200 text-cool-indigo-800">
                                                    ${{ number_format($producto->precio,2) }}
                                                </span>
                                            </div>
                                            <p class="mt-1 text-base font-medium leading-6 text-gray-500">
                                                {{ $producto->descripcion }}
                                            </p>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty

            <h2
                class="relative  text-center sm:px-6 max-w-md mx-auto mt-3 text-lg text-gray-900 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl ">
                Sin resultados </h2>
        @endforelse
        {{$productos->links()}}



        {{-- Next pagination --}}
        {{--  <div id="pagination-button" class="flex justify-center mt-14">
                    <button name="button" type="button"
                        class="inline-flex items-center justify-center px-8 h-12 text-base font-medium text-cool-indigo-700 border border-transparent rounded-2xl bg-cool-indigo-100 hover:bg-cool-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-cool-indigo-500"
                        target="_blank" data-action="click-&gt;pagination#loadMore" data-pagination-target="next"
                        data-next-url="/?page=2" data-button-loader-target="button"
                        data-controller="button-loader" data-button-loader-hidden-class="hidden">
                        <svg class="hidden w-5 h-5 animate-spin text-cool-indigo-500"
                            data-button-loader-target='loader' xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span data-button-loader-target='text'>Load more designs</span>
                    </button>
                </div> --}}

    </div>
</div>

</div>
