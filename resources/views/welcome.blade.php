<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RMS</title>

    <!-- Fonts -->
    <meta name="description" content="Sitio web Oficial RMS - San Felipe Jalapa de Díaz">
    {{-- <meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@tailwindawesome">
<meta name="twitter:title" content="Tailwind Awesome">
<meta name="twitter:description" content="A curated directory of the best Tailwind templates and UI kits to kickstart your next design.">
<meta name="twitter:creator" content="@tailwindawesome">
<meta name="twitter:image" content="{{asset('img/logo.jpg')}}"> --}}
<meta property="og:url" content="{{url()->full()}}">
<meta property="og:title" content="RMS - San Felipe Jalapa de Díaz">
<meta property="og:type" content="article">
<meta property="og:description" content="Sitio web Oficial RMS - San Felipe Jalapa de Díaz">
<meta property="og:site_name" content="RMS">
<meta property="og:image" content="{{ asset('img/logo.jfif') }}">
<meta name="site_name" content="RMS - San Felipe Jalapa de Díaz ">
<meta name="csrf-token" content="{{ csrf_token() }}">



    <!-- Styles -->

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
   {{--  <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> --}}
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('js/frontend.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js" defer></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.jfif') }}" />
     <!-- Fonts -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
     @livewireStyles
</head>

<body class="antialiased" data-controller='lazy-loader'>
   



    <div class="min-h-screen overflow-hidden">

        <div class="relative mt-16 overflow-hidden md:mt-18 bg-gradient-to-b from-gray-50 to-white">
            <div class="relative pb-4">
                @include('nav')


                        <main class="px-4 mx-auto mt-10 max-w-7xl sm:mt-14">
                            
                            <div id="carouselExampleCrossfade" class="carousel slide carousel-fade relative"
                                data-bs-ride="carousel">
                                <div class="carousel-indicators absolute right-0 bottom-0 left-0 flex justify-center p-0 mb-4">
                                    <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="0"
                                    class="active"
                                    aria-label="Slide 1"></button>
                                    @forelse ($carruseles as $key => $item)

                                    <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="{{$key+1}}"
                                    {{-- class="active" --}} aria-current="true" aria-label="Slide {{$key+1}}"></button>
                                    @empty

                                    @endforelse
                                    
                                    {{-- <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="1"
                                        aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="2"
                                        aria-label="Slide 3"></button> --}}
                                </div>
                                <div class="carousel-inner relative w-full overflow-hidden">
                                    <div class="carousel-item active float-left w-full">
                                        <img src="{{asset('img/jaca_fondo.jfif')}}" class="block w-full"
                                        alt="Wild Landscape" />
                                    </div>
                                    @forelse ($carruseles as $key => $item)
                                    <div class="carousel-item float-left w-full">
                                        <img src="{{asset($item->imagen_url)}}" class="block w-full"
                                            alt="Img-{{$item->id}}" />
                                    </div>
                                    @empty

                                    @endforelse

                                    {{-- <div class="carousel-item float-left w-full">
                                        <img src="https://mdbcdn.b-cdn.net/img/new/slides/043.webp" class="block w-full"
                                            alt="Exotic Fruits" />
                                    </div> --}}
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
                            </div>

                            <div class="text-center">
                                <h1
                                    class="text-4xl font-extrabold tracking-tight text-gray-900 font-display sm:text-5xl md:text-6xl xl:text-7xl">
                                   {{--  <span class="block xl:inline">Discover the best</span> --}}
                                    <span class="block text-amarillo-600">RMS</span>
                                </h1>
                                
                                <p
                                    class="max-w-md mx-auto mt-3 text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                                    Descripcion 
                                </p>
                                
                            </div>
                        </main>
                    </div>
                </div>

                @livewire('principal')

                
                
                <footer class="bg-white" aria-labelledby="footerHeading">
                    <h2 id="footerHeading" class="sr-only">Footer</h2>
                    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
                        <div class="mt-8 border-t border-gray-200 pt-8 md:flex md:items-center md:justify-between">
                            <div class="flex space-x-6 md:order-2">
                              
                            </div>
                            <p class="mt-8 text-base text-gray-400 md:mt-0 md:order-1">
                                &copy; {{date('Y')}} RMS Tecnología y Redes.
                            </p>
                        </div>
                    </div>
                </footer>

            </div>
            {{-- modal puede servir más adelante --}}
       
            <!-- This example requires Tailwind CSS v2.0+ -->
          

           

            @livewireScripts

        </body>

        </html>
