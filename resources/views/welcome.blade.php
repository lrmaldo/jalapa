<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RMS</title>

    <!-- Fonts -->
    <meta name="description" content="Sitio web Oficial RMS - San Felipe Jalapa de Díaz">
    <meta property="og:url" content="{{url()->full()}}">
    <meta property="og:title" content="RMS - San Felipe Jalapa de Díaz">
    <meta property="og:type" content="article">
    <meta property="og:description" content="Sitio web Oficial RMS - San Felipe Jalapa de Díaz">
    <meta property="og:site_name" content="RMS">
    <meta property="og:image" content="{{ asset('img/logo.jfif') }}">
    <meta name="site_name" content="RMS - San Felipe Jalapa de Díaz ">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('js/frontend.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js" defer></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.jfif') }}" />
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Alpine.js si no está ya incluido en el stack -->mas -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
</head>

<body class="antialiased font-sans bg-gray-50" data-controller='lazy-loader'>
    <div class="min-h-screen overflow-hidden">
        <!-- Hero Section con Navigation -->
        <div class="relative bg-gradient-to-b from-gray-900 to-gray-800 text-white">
            <div class="relative">
                @include('nav')

                <!-- Hero Content -->
                <main class="relative z-10">
                    <!-- Nuevo Carrusel con Alpine.js -->ado para altura fija -->.js -->
                    <div x-data="carousel()"500px] sm:h-[550px] md:h-[600px] overflow-hidden">
                         class="relative h-[500px] sm:h-[550px] md:h-[600px] overflow-hidden">
                        <!-- Overlay para oscurecer las imágenes -->rousel slide carousel-fade relative h-full" data-bs-ride="carousel">},
                        <div class="absolute inset-0 bg-black/40 z-10"></div>
                            <div class="carousel-indicators absolute right-0 bottom-0 left-0 flex justify-center p-0 mb-6 z-10">                            nextSlide() {
                        <!-- Slides --> type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="0"tiveSlide = (this.activeSlide + 1) % this.totalSlides;
                        <div class="relative h-full"> w-3 h-3 rounded-full bg-white mx-2 hover:bg-amber-400 transition-all duration-300"
                            <!-- Slide Inicial -->nt="true" aria-label="Slide 1"></button>
                            <div x-show="activeSlide === 0"ey => $item)
                                 x-transition:enter="transition ease-out duration-500"mpleCrossfade" data-bs-slide-to="{{$key+1}}"lides) % this.totalSlides;
                                 x-transition:enter-start="opacity-0 transform scale-105"er:bg-amber-400 transition-all duration-300"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-500"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="absolute inset-0">->
                            <div class="carousel-inner relative w-full h-full overflow-hidden">                        }"
                                <div class="absolute inset-0 flex items-center justify-center z-20">
                                    <div class="text-center px-4 max-w-3xl mx-auto">-full">
                                        <h1 class="text-5xl md:text-7xl font-bold tracking-tight mb-6 text-white drop-shadow-lg">
                                            <span class="block text-amber-400">RMS</span>
                                            <span class="block text-3xl md:text-4xl mt-2">Tecnología y Comunicaciones</span>
                                        </h1>"RMS Tecnología" />
                                    <div class="absolute inset-0 flex items-center justify-center z-20">
                                        <div class="text-center px-4 max-w-3xl mx-auto">
                                            <h1 class="text-5xl md:text-7xl font-bold tracking-tight mb-6 text-white drop-shadow-lg">iveSlide === 0"
                                                <span class="block text-amber-400">RMS</span>ute inset-0 transition-opacity duration-500"
                                                <span class="block text-3xl md:text-4xl mt-2">Tecnología y Comunicaciones</span>
                                            </h1>-0"
                                            <p class="text-lg md:text-xl text-gray-100 max-w-lg mx-auto mb-8">ter-end="opacity-100"
                                                Soluciones tecnológicas innovadoras para San Felipe Jalapa de Díaz
                                            </p>="opacity-100"
                                            <div>ave-end="opacity-0">
                                                <a href="#servicios" class="inline-block px-6 py-3 bg-amber-500 text-white rounded-lg font-medium hover:bg-amber-600 transition-all duration-300 mr-4">
                                                    Nuestros Servicios{{asset('img/jaca_fondo.jfif')}}"
                                                </a>lass="w-full h-full object-cover object-center"
                                                <a href="#contacto" class="inline-block px-6 py-3 bg-transparent border-2 border-white text-white rounded-lg font-medium hover:bg-white hover:text-gray-900 transition-all duration-300">                                     alt="RMS Tecnología y Comunicaciones" />
                                                    Contactar
                                                </a>y-center z-20">
                                            </div>-auto">
                                        </div>      <h1 class="text-5xl md:text-7xl font-bold tracking-tight mb-6 text-white drop-shadow-lg">
                                    </div>                                            <span class="block text-amber-400">RMS</span>
                                </div>ss="block text-3xl md:text-4xl mt-2">Tecnología y Comunicaciones</span>

                                <!-- Slides dinámicos -->ay-100 max-w-lg mx-auto mb-8">
                                @foreach($carruseles as $key => $item)elipe Jalapa de Díaz
                                    <div class="carousel-item float-left w-full h-full">
                                        <div class="absolute inset-0 bg-black/40 z-10"></div>
                                        <img src="{{asset($item->imagen_url)}}"  py-3 bg-amber-500 text-white rounded-lg font-medium hover:bg-amber-600 transition-all duration-300 mr-4">
                                             class="block w-full h-full object-cover object-center"
                                             alt="Img-{{$item->id}}" />
                                        <div class="absolute inset-0 flex items-center justify-center z-20">" class="inline-block px-6 py-3 bg-transparent border-2 border-white text-white rounded-lg font-medium hover:bg-white hover:text-gray-900 transition-all duration-300">
                                            <div class="text-center px-4">                                                Contactar
                                                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4 drop-shadow-lg">
                                                    Innovación y Tecnología
                                                </h2>
                                                <p class="text-lg text-gray-100 max-w-lg mx-auto">
                                                    Conectando el futuro de nuestra comunidad
                                                </p>
                                            </div>
                                        </div> as $key => $item)
                                    </div>ctiveSlide === {{ $key + 1 }}"
                                @endforeach="absolute inset-0 transition-opacity duration-500"
                            </div>                                     x-transition:enter="opacity-0"

                            <!-- Controles -->
                            <button0"
                                class="carousel-control-prev absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline left-0"-transition:leave-start="opacity-100"
                                type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide="prev">transition:leave-end="opacity-0">
                                <span class="carousel-control-prev-icon inline-block bg-no-repeat bg-contain w-10 h-10" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>                                    <img src="{{asset($item->imagen_url)}}"
                            </button>h-full object-cover object-center"
                            <button
                                class="carousel-control-next absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline right-0"
                                type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide="next">
                                <span class="carousel-control-next-icon inline-block bg-no-repeat bg-contain w-10 h-10" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>      <h2 class="text-4xl md:text-5xl font-bold text-white mb-4 drop-shadow-lg">
                            </button>           Innovación y Tecnología
                        </div>                                            </h2>
                    </div>
                </main>
            </div>
        </div>  </div>
/div>
        <!-- Sección Principal con Componente Livewire -->  </div>
        <div id="servicios" class="py-16 bg-white">                            @endforeach
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        <span class="block">Nuestros Servicios</span>
                    </h2>                            <button @click="prevSlide" class="p-2 rounded-full bg-black/30 text-white hover:bg-black/50 focus:outline-none">
                    <p class="mt-4 text-xl text-gray-500">an>
                        Descubra nuestras soluciones tecnológicasentColor" viewBox="0 0 24 24">
                    </p>
                </div>

                <!-- Livewire Component -->
                <div class="bg-gray-50 rounded-2xl shadow-sm p-6">  <button @click="nextSlide" class="p-2 rounded-full bg-black/30 text-white hover:bg-black/50 focus:outline-none">
                    @livewire('principal')         <span class="sr-only">Siguiente</span>
                </div>              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            </div>                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </div>                                </svg>

        <!-- Footer Mejorado -->
        <footer class="bg-gray-900 text-white" aria-labelledby="footerHeading" id="contacto">
            <h2 id="footerHeading" class="sr-only">Footer</h2>
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">center gap-2 z-20">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-8">
                    <div>           :class="{'bg-white': activeSlide === 0, 'bg-white/50': activeSlide !== 0}"
                        <h3 class="text-xl font-bold mb-4">RMS</h3>-full focus:outline-none"></button>
                        <p class="text-gray-300">
                            Ofreciendo soluciones tecnológicas innovadoras para conectar nuestra comunidad con el futuro.    @foreach($carruseles as $key => $item)
                        </p>          <button @click="activeSlide = {{ $key + 1 }}"
                    </div>                                        :class="{'bg-white': activeSlide === {{ $key + 1 }}, 'bg-white/50': activeSlide !== {{ $key + 1 }}}"
                    <div>ss="w-3 h-3 rounded-full focus:outline-none"></button>
                        <h3 class="text-xl font-bold mb-4">Contacto</h3>
                        <ul class="space-y-2 text-gray-300">
                            <li>San Felipe Jalapa de Díaz</li>div>
                            <li>Tel: (123) 456-7890</li>main>
                            <li>Email: contacto@rms.com</li>div>
                        </ul>        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-4">Síguenos</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-300 hover:text-amber-400">
                                <span class="sr-only">Facebook</span>lass="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">n>
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                                </svg>
                            </a>ubra nuestras soluciones tecnológicas
                            <a href="#" class="text-gray-300 hover:text-amber-400">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path>
                                </svg>-6">
                            </a>
                            <a href="#" class="text-gray-300 hover:text-amber-400">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                                </svg>
                            </a>labelledby="footerHeading" id="contacto">
                        </div>
                    </div> lg:px-8">
                </div>
                <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-base text-gray-400">&copy; {{date('Y')}} RMS Tecnología y Redes. Todos los derechos reservados.</p>t-xl font-bold mb-4">RMS</h3>
                    <div class="flex space-x-6 mt-4 md:mt-0">="text-gray-300">
                        <a href="#" class="text-gray-400 hover:text-gray-300">Política de privacidad</a>ectar nuestra comunidad con el futuro.
                        <a href="#" class="text-gray-400 hover:text-gray-300">Términos de uso</a>
                    </div>
                </div>
            </div>t-xl font-bold mb-4">Contacto</h3>
        </footer>s="space-y-2 text-gray-300">
    </div>

    <!-- Botón de regreso arriba -->
    <button id="back-to-top" class="fixed bottom-6 right-6 bg-amber-500 text-white p-2 rounded-full shadow-lg z-50 hidden hover:bg-amber-600 transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>ass="text-xl font-bold mb-4">Síguenos</h3>
    </button>iv class="flex space-x-4">
      <a href="#" class="text-gray-300 hover:text-amber-400">
    <script>
        // Función del carrusel
        function carousel() { d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
            return {
                activeSlide: 0,
                totalSlides: {{ count($carruseles) + 1 }},  <a href="#" class="text-gray-300 hover:text-amber-400">
          <span class="sr-only">Instagram</span>
                nextSlide() {              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path>   this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
                                </svg>      },
                            </a>
                            <a href="#" class="text-gray-300 hover:text-amber-400">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                                </svg>  // Auto avance del carrusel
                            </a>   init() {
                        </div>                    setInterval(() => {
                    </div>            this.nextSlide();
                </div>
                <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-base text-gray-400">&copy; {{date('Y')}} RMS Tecnología y Redes. Todos los derechos reservados.</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-gray-300">Política de privacidad</a>
                        <a href="#" class="text-gray-400 hover:text-gray-300">Términos de uso</a>        // Botón de regreso arriba
                    </div>er('scroll', function() {
                </div>
            </div>ndow.scrollY > 300) {
        </footer>                backToTop.classList.remove('hidden');
    </div>

    <!-- Botón de regreso arriba -->
    <button id="back-to-top" class="fixed bottom-6 right-6 bg-amber-500 text-white p-2 rounded-full shadow-lg z-50 hidden hover:bg-amber-600 transition-all duration-300">        });
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />al hacer clic
        </svg>o-top').addEventListener('click', function() {
    </button>

    <!-- Scripts -->ehavior: 'smooth'
    <script>);
        // Solo para el botón de regreso arriba);
        window.addEventListener('scroll', function() {    </script>
            var backToTop = document.getElementById('back-to-top');
            if (window.scrollY > 300) {
                backToTop.classList.remove('hidden');
            } else {
                backToTop.classList.add('hidden');
            }on: transform 0.6s ease-in-out;
        });
pacity: 0;
        document.getElementById('back-to-top').addEventListener('click', function() { display: block !important;
            window.scrollTo({        }
                top: 0,
                behavior: 'smooth'
            });e;
        });
    </script>

    @livewireScriptsMejora del manejo de imágenes */
</body>usel-item img {
</html>            object-fit: cover;

        /* Efecto de fade entre diapositivas */
        .carousel-fade .carousel-item {
            opacity: 0;
            transition-property: opacity;
            transform: none;
        }

        .carousel-fade .carousel-item.active {
            opacity: 1;
            z-index: 1;
        }
    </style>
</body>
</html>
