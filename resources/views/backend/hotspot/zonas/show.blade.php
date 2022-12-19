<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zonas de hotspot') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="block mb-8">
        </div>
        <div class="max-w-7xl mx-auto sm:px-5 lg:px-4">
            <div class="block mb-4">
                <a href="{{ url()->previous() }}" class="bg-gray-200 hover:bg-gray-300 text-black font-bold py-2 px-4 rounded">Regresar</a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mx-1 p-3">

               
                <div class="mt-3">
                    <h2 class="text-4xl  text-black font-bold my-3 text-center">Login.html</h2>
                    Configuración zona {{ $zona->nombre }}: descarga el siguiente archivo <strong>login.html</strong> y
                    arrastralo hacia tu carpeta hotspot de tu mikrotik
                    como en la siguiente animación
                </div>
                <img src="{{ asset('img/gif/login.gif') }}" width="80%" alt=""
                    class="rounded h-80 w-full object-cover">
                <div class="flex flex-row mt-5 my-2">
                    <div>
                        <a href="{{ route('descargar.login', $zona->id) }}"
                            class="bg-amarillo-500 hover:bg-amarillo-700 text-black font-bold py-2 px-4 rounded mx-2 my-4">Descargar
                            login.html</a>
                    </div>
                </div>


                {{-- border --}}
                <x-jet-section-border />

                <div class="mt-3">
                    <h2 class="text-4xl  text-black font-bold my-3 text-center">Login.html</h2>
                    Configuración zona {{ $zona->nombre }}: descarga el siguiente archivo <strong>alogin.html</strong> y
                    arrastralo hacia tu carpeta hotspot de tu mikrotik
                    como en la siguiente animación
                </div>
                <img src="{{asset('img/gif/alogin.gif')}}" width="80%"  alt="" class="rounded h-80 w-full object-cover">
                <div class="flex flex-row mt-5 my-2">
                    <div>
                        <a href="{{ route('descargar.alogin', $zona->id) }}"
                            class="bg-amarillo-500 hover:bg-amarillo-700 text-black font-bold py-2 px-4 rounded mx-2 my-4">Descargar
                            alogin.html</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script></script>



</x-app-layout>
