<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RMS</title>

    <!-- Fonts -->
    <meta name="description" content="test">
    {{-- <meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@tailwindawesome">
<meta name="twitter:title" content="Tailwind Awesome">
<meta name="twitter:description" content="A curated directory of the best Tailwind templates and UI kits to kickstart your next design.">
<meta name="twitter:creator" content="@tailwindawesome">
<meta name="twitter:image" content="{{asset('img/logo.')}}"> --}}
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:title" content="{{ $tienda->nombre }}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="Sitio web Oficial RMS - San Felipe Jalapa de Díaz">
    <meta property="og:site_name" content="RMS">
    <meta property="og:image" content="{{ asset('img/logo.jfif') }}">
    <meta name="site_name" content="RMS - San Felipe Jalapa de Diáz ">
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <!-- Styles -->

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    {{--  <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> --}}
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('js/frontend.js') }}" defer></script>
    <script src="{{ asset('js/tw-elements.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js" defer></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.jfif') }}" />
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
   {{--  <link href="{{ asset('/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/vendor/simple-line-icons/css/simple-line-icons.css') }}"> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/brands.min.css" integrity="sha512-G/T7HQJXSeNV7mKMXeJKlYNJ0jrs8RsWzYG7rVACye+qrcUhEAYKYzaa+VFy6eFzM2+/JT1Q+eqBbZFSHmJQew==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @livewireStyles
</head>

<body class="antialiased" onload="mapa.initMap()">
    <style>
        .map-responsive {
            overflow: hidden;
            padding-bottom: 36.25%;
            position: relative;
            height: 0;
        }

        @media screen and (max-width: 600px) {
            .map-responsive {
                overflow: hidden;
                padding-bottom: 66.25%;
                position: relative;
                height: 0;
            }
        }
    </style>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDS9ZIrYxrNhDYACm11Vxaw1c_jhpsvMk&libraries=places&sensor=false&callback=initMap"></script>

    <script>
        var latitude2 = {!! json_encode($tienda->latitude) !!};
        var longitude2 = {!! json_encode($tienda->longitude) !!};

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
                        lat: latitude2 ? parseFloat(latitude2) : 18.0709008,
                        lng: longitude2 ? parseFloat(longitude2) : -96.5349083
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




    <div class="min-h-screen overflow-hidden">

        <div class="relative mt-16 overflow-hidden md:mt-18 bg-gradient-to-b from-gray-50 to-white">
            <div class="relative pb-4">
                <nav
                    class="backdrop-filter backdrop-blur-xl border-b border-slate-900/5 z-50 bg-gray-50/90 fixed top-0 w-full">
                    <div class="px-2 mx-auto max-w-screen-2xl sm:px-4 lg:px-8">
                        <div class="flex justify-between h-16 md:h-18">
                            <div class="flex px-2 lg:px-0">
                                <div class="flex items-center flex-shrink-0">
                                    <a class="inline-flex items-center font-black font-display text-amarillo-800 text-xl"
                                        href="/">


                                        <img src="{{ asset('img/logo.jfif') }}" alt="" width="48"
                                            class="object-contain h-10 w-10">
                                    </a>
                                </div>
                                <div class="hidden lg:ml-6 xl:ml-8 lg:flex lg:space-x-8" data-turbo=false>
                                    <!-- Current: "border-indigo-500 text-gray-900", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->
                                    <a class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
                                        href="/">Inicio</a>
                                    <a class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
                                        href="/?type=template">Ventas</a>
                                    <a class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
                                        href="/?type=kit">Agenda</a>
                                    <a class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
                                        href="/?price=free">Blog</a>
                                    @if (Route::has('login'))

                                        @auth
                                            <a href="{{ url('/dashboard') }}"
                                                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Dashboard</a>
                                        @else
                                            <a href="{{ route('login') }}"
                                                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Login</a>

                                            {{-- @if (Route::has('register'))
                                                    <a href="{{ route('register') }}"
                                                        class="ml-4 text-sm text-gray-700 underline">Register</a> --}}
                                        @endif


                                        @endif
                                    </div>
                                </div>
                                <div
                                    class="flex  items-center justify-end flex-1 px-2 sm:justify-center lg:ml-6 lg:justify-end">
                                    <div class='relative hidden w-full h-12 max-w-lg rounded-full sm:block'>
                                        <form target="_blank" data-controller="newsletter"
                                            data-action="submit-&gt;newsletter#onSubmit" data-newsletter-target="form"
                                            action="" accept-charset="UTF-8" method="post">
                                            <div
                                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <!-- Heroicon name: solid/mail -->
                                                <svg class='w-5 h-5 text-gray-400' xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <input
                                                class="w-full pl-10 pr-24 py-3.5 border-0 bg-gray-100 border-transparent rounded-full leading-5 transition duration-150 placeholder-gray-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-rojo-200 focus:border-rojo-200 sm:text-sm"
                                                data-newsletter-target="email" required="required"
                                                placeholder="Reciba Notificaciones " autocomplete="email" type="email"
                                                name="member[email]" id="member[email]" />
                                            <button type='submit'
                                                class='absolute inline-flex items-center h-10 px-4 py-2 text-sm text-white transition duration-150  ease-in-out rounded-full outline-none right-1 top-1 bg-amarillo-600 md:px-6 sm:font-medium hover:bg-amarillo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amarillo-500'>
                                                Suscribete
                                            </button>

                                            {{-- <a href="" class='absolute inline-flex items-center h-10 px-4 py-2 text-sm text-white transition duration-150  ease-in-out rounded-full outline-none right-1 top-1 bg-amarillo-500 md:px-6 sm:font-medium hover:bg-amarillo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amarillo-500' >test </a> --}}

                                        </form>
                                    </div>

                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-white border border-transparent rounded-full shadow-sm sm:hidden bg-naranja-600 hover:bg-naranja-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-naranja-500"
                                        data-controller='toggle newsletter' data-toggle-remote='#newsletter-modal'
                                        data-action='click->toggle#toggleRemote click->newsletter#removePopupTimeout'>
                                        <!-- Heroicon name: solid/mail -->
                                        <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                        Suscribete
                                    </button>
                                </div>


                                <div class="flex items-center">

                                    <!-- Mobile menu button -->
                                    <button type="button"
                                        class="inline-flex items-center justify-center p-2 ml-3 text-gray-400 rounded-full lg:hidden hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cool-indigo-500"
                                        aria-controls="mobile-menu" aria-expanded="false" data-controller='toggle'
                                        data-toggle-remote='#mobile-menu' data-action='click->toggle#toggleRemote'
                                        data-action='click->toggle#toggle'>
                                        <span class="sr-only">Open main menu</span>
                                        <svg class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"
                                            data-toggle-target='toggleable'>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>

                                        <svg class="hidden w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"
                                            data-toggle-target='toggleable'>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile menu, show/hide based on menu state. -->
                        <div class="hidden lg:hidden bg-white/90 backdrop-filter backdrop-blur-xl" id="mobile-menu"
                            data-controller='toggle' data-toggle-target='toggleable'>
                            <div class="px-2 pt-2 pb-3">
                                <a class="block px-3 py-2 rounded-2lg text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50"
                                    href="/">Inicio</a>
                                <a class="block px-3 py-2 rounded-2lg text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50"
                                    href="/?type=template">Templates</a>
                                <a class="block px-3 py-2 rounded-2lg text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50"
                                    href="/?type=kit">UI kits</a>
                                <a class="block px-3 py-2 rounded-2lg text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50"
                                    href="/?price=free">Blog</a>
                                @if (Route::has('login'))

                                    @auth
                                        <a href="{{ url('/dashboard') }}"
                                            class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Login</a>

                                        {{-- @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="ml-4 text-sm text-gray-700 underline">Register</a> --}}
                                    @endif


                                    @endif

                                </div>
                                <a class="inline-flex justify-center items-center w-full px-5 py-3 text-center font-medium text-cool-indigo-600 bg-gray-50 hover:bg-gray-100"
                                    href="https://twitter.com/intent/tweet?text=Check+out+Tailwind+Awesome&amp;url=https%3A%2F%2Fwww.tailwindawesome.com%2F&amp;via=tailwindawesome">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 -ml-1 opacity-80"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c-.002 -.249 1.51 -2.772 1.818 -4.013z">
                                        </path>
                                    </svg>

                                </a>
                            </div>
                        </nav>


                        <main class="px-4 mx-auto mt-10 max-w-7xl sm:mt-14">
                            {{-- carrusel --}}
                            {{--  <div id="carouselExampleCrossfade" class="carousel slide carousel-fade relative"
                                data-bs-ride="carousel">
                                <div class="carousel-indicators absolute right-0 bottom-0 left-0 flex justify-center p-0 mb-4">
                                    <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="0"
                                        class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="1"
                                        aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="2"
                                        aria-label="Slide 3"></button>
                                </div>
                                <div class="carousel-inner relative w-full overflow-hidden">
                                    <div class="carousel-item active float-left w-full">
                                        <img src="{{asset('img/jaca_fondo.jfif')}}" class="block w-full"
                                            alt="Wild Landscape" />
                                    </div>
                                    <div class="carousel-item float-left w-full">
                                        <img src="https://mdbcdn.b-cdn.net/img/new/slides/042.webp" class="block w-full"
                                            alt="Camera" />
                                    </div>
                                    <div class="carousel-item float-left w-full">
                                        <img src="https://mdbcdn.b-cdn.net/img/new/slides/043.webp" class="block w-full"
                                            alt="Exotic Fruits" />
                                    </div>
                                </div>
                                <button
                                    class="carousel-control-prev absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline left-0"
                                    type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon inline-block bg-no-repeat"
                                        aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button
                                    class="carousel-control-next absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline right-0"
                                    type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide="next">
                                    <span class="carousel-control-next-icon inline-block bg-no-repeat"
                                        aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div> --}}

                            <div class="text-center">
                                <div class=" mx-auto w-80 max-h-50">
                                    <img src="{{ $tienda->logo_url }}" class="block w-full"
                                        alt="imagen_{{ $tienda->nombre }}" />
                                </div>
                                <h1
                                    class="text-4xl font-extrabold tracking-tight text-gray-900 font-display sm:text-5xl md:text-6xl xl:text-7xl">
                                    {{--  <span class="block xl:inline">Discover the best</span> --}}
                                    <span class="block text-amarillo-600">{{ $tienda->nombre }}</span>
                                </h1>

                                <p
                                    class="max-w-md mx-auto mt-3 text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                                    {{ $tienda->direccion }}
                                </p>

                                {{-- Mapa --}}

                                @if ($tienda->latitude)
                                    <div class="map-responsive">
                                        <div id="mapa" style="width: 100%; height: 350px;"> </div>
                                    </div>

                                @endif

                                {{-- botones de  contacto --}}
                                <div class="inline-flex  shadow-sm">
                                    <div class="sharing-buttons flex flex-wrap">
                                        {{-- facebook --}}
                                        @if(!empty($tienda->facebook_url))
                                        <a class="border-2 duration-200 ease inline-flex items-center mb-1 mr-1 transition py-3 px-5 rounded-lg text-white border-amarillo-600 bg-amarillo-600 hover:bg-amarillo-700 hover:border-amarillo-700" target="_blank" rel="noopener" href="{{$tienda->facebook}}" aria-label="Share on Facebook">
                                          <svg aria-hidden="true" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6">
                                            <title>Facebook</title>
                                            <path d="M379 22v75h-44c-36 0-42 17-42 41v54h84l-12 85h-72v217h-88V277h-72v-85h72v-62c0-72 45-112 109-112 31 0 58 3 65 4z">
                                            </path>
                                          </svg>
                                          <span class="ml-2">Facebook</span>
                                        </a>
                                        @endif
                                        {{-- telefono --}}
                                        @if($telefono)
                                        <a class="border-2 duration-200 ease inline-flex items-center mb-1 mr-1 transition py-3 px-5 rounded-lg text-white border-amarillo-600 bg-amarillo-600 hover:bg-amarillo-700 hover:border-amarillo-700" target="_blank" rel="noopener" href="tel:{{$telefono->telefono}}" aria-label="Share on Tumblr" draggable="false">
                                          <svg aria-hidden="true" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6">
                                            <title>Teléfono</title>
                                            <path d="M406 480c-14 15-50 32-98 32-120 0-147-89-147-141V227h-47c-6 0-10-4-10-10v-68c0-7 4-13 11-16 62-21 82-76 85-117 0-11 6-16 16-16h71c5 0 10 4 10 10v115h83c5 0 10 5 10 10v82c0 5-5 10-10 10h-84v133c0 34 24 54 68 36 5-2 9-3 13-2 3 1 6 3 7 8l22 64c2 5 4 10 0 14z">
                                            </path>
                                          </svg>
                                          <span class="ml-2">Teléfono</span>
                                        </a>
                                        @endif

                                        {{-- whatsapp --}}
                                        @if ($whatsapp)
                                            
                                        
                                        <a class="border-2 duration-200 ease inline-flex items-center mb-1 mr-1 transition py-3 px-5 rounded-lg text-white border-amarillo-600 bg-amarillo-600 hover:bg-amarillo-700 hover:border-amarillo-700" target="_blank" rel="noopener" href="https://api.whatsapp.com/send?phone={{$whatsapp->telefono}}&text=Quiero%20saber%20m%C3%A1s%20informaci%C3%B3n" aria-label="Share on Whatsapp" draggable="false">
                                          <svg aria-hidden="true" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6">
                                            <title>Whatsapp</title>
                                            <path d="M413 97A222 222 0 0 0 64 365L31 480l118-31a224 224 0 0 0 330-195c0-59-25-115-67-157zM256 439c-33 0-66-9-94-26l-7-4-70 18 19-68-4-7a185 185 0 0 1 287-229c34 36 56 82 55 131 1 102-84 185-186 185zm101-138c-5-3-33-17-38-18-5-2-9-3-12 2l-18 22c-3 4-6 4-12 2-32-17-54-30-75-66-6-10 5-10 16-31 2-4 1-7-1-10l-17-41c-4-10-9-9-12-9h-11c-4 0-9 1-15 7-5 5-19 19-19 46s20 54 23 57c2 4 39 60 94 84 36 15 49 17 67 14 11-2 33-14 37-27s5-24 4-26c-2-2-5-4-11-6z">
                                            </path>
                                          </svg>
                                          <span class="ml-2">Whatsapp</span>
                                        </a>
                                        @endif
                                      </div>
                            </div>
                        </main>
                    </div>
                </div>
                @if ($tienda->tipo_tienda == 2)
                    @livewire('frotend.tienda', ['id_tienda' => $tienda->id])
                @endif


                <footer class="bg-white" aria-labelledby="footerHeading">
                    <h2 id="footerHeading" class="sr-only">Footer</h2>
                    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
                        <div class="mt-8 border-t border-gray-200 pt-8 md:flex md:items-center md:justify-between">
                            <div class="flex space-x-6 md:order-2">

                            </div>
                            <p class="mt-8 text-base text-gray-400 md:mt-0 md:order-1">
                                &copy; {{ date('Y') }} RMS Tecnología y Redes.
                            </p>
                        </div>
                    </div>
                </footer>

            </div>
            {{-- modal puede servir más adelante --}}



            <!-- Global toast live region -->
            <div aria-live="assertive"
                class="fixed inset-0 z-50 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start">
                <div id='flash-messages' class="flex flex-col items-center w-full space-y-4 sm:items-end">


                </div>
            </div>

            @livewireScripts

            @if ($whatsapp)

                <style>
                    .whatsapp {
                        position: fixed;
                        width: 60px;
                        height: 60px;
                        bottom: 40px;
                        right: 40px;
                        background-color: #25d366;
                        color: #FFF;
                        border-radius: 50px;
                        text-align: center;
                        font-size: 30px;
                        z-index: 100;
                    }

                    .whatsapp-icon {
                        margin-top: 14px;
                    }
                </style>

                <a href="https://api.whatsapp.com/send?phone={{$whatsapp->telefono}}&text=Quiero%20saber%20m%C3%A1s%20informaci%C3%B3n"
                    class="whatsapp" target="_blank">
                    {{-- <i class="fa fa-whatsapp whatsapp-icon"></i> --}}
                    <i class="fa-brands fa-whatsapp whatsapp-icon"></i>
                    {{-- <img src="{{asset('img/whatsapp_logo.png')}}" width="40" height="40"> --}}
                </a>

            @endif



        </body>

        </html>
