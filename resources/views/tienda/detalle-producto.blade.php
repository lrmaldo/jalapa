<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RMS</title>

    <!-- Fonts -->
    <meta name="description" content="{{$producto->descripcion}}">
    {{-- <meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@tailwindawesome">
<meta name="twitter:title" content="Tailwind Awesome">
<meta name="twitter:description" content="A curated directory of the best Tailwind templates and UI kits to kickstart your next design.">
<meta name="twitter:creator" content="@tailwindawesome">
<meta name="twitter:image" content="{{asset('img/logo.jpg')}}"> --}}
    <meta property="og:url" content="{{url()->full()}}">
    <meta property="og:title" content="{{$producto->nombre}}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="{{$producto->descripcion}} - ${{number_format($producto->precio,2)}}">
    <meta property="og:site_name" content="RMS">
    <meta property="og:image" content="{{ asset($producto->imagen_url) }}">
    <meta name="site_name" content="RMS">
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
    {{--  <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endif
                </div>
            @endif
              --}}



    <!-- Estilos personalizados -->
    <style>
        .product-image {
            transition: transform 0.3s ease-in-out;
        }

        .product-image:hover {
            transform: scale(1.05);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">

        <!-- Header con navegación -->
        <div class="relative">
            @include('nav')
        </div>

        <!-- Breadcrumb y botón regresar -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
                <a href="/" class="hover:text-blue-600 transition-colors">Inicio</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ url()->previous() }}" class="hover:text-blue-600 transition-colors">Tienda</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">{{ $producto->nombre }}</span>
            </div>

            <button
                onclick="history.back()"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 mb-6">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Regresar
            </button>
        </div>

        <!-- Contenido principal del producto -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">

                <!-- Imagen del producto -->
                <div class="flex flex-col-reverse">
                    <div class="w-full max-w-md mx-auto lg:max-w-lg">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-6 fade-in">
                            @if($producto->imagen_url)
                                <img
                                    src="{{ asset($producto->imagen_url) }}"
                                    alt="{{ $producto->nombre }}"
                                    class="w-full h-64 sm:h-80 lg:h-96 object-cover object-center product-image rounded-xl cursor-pointer"
                                />
                            @else
                                <div class="w-full h-64 sm:h-80 lg:h-96 bg-gray-200 rounded-xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Información del producto -->
                <div class="mt-8 px-4 sm:px-0 sm:mt-12 lg:mt-0 lg:pl-8">
                    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 fade-in glass-effect">

                        <!-- Nombre del producto -->
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                            {{ $producto->nombre }}
                        </h1>

                        <!-- Precio -->
                        <div class="mb-6">
                            <div class="flex items-baseline space-x-2">
                                <span class="text-3xl sm:text-4xl lg:text-5xl font-bold gradient-text">
                                    ${{ number_format($producto->precio, 2) }}
                                </span>
                                <span class="text-base sm:text-lg text-gray-500">MXN</span>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Descripción</h3>
                            <p class="text-gray-700 leading-relaxed text-base">
                                {{ $producto->descripcion }}
                            </p>
                        </div>

                        <!-- Información adicional -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            @if($producto->categoria)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Categoría</h4>
                                <p class="text-base font-semibold text-gray-900">{{ $producto->categoria->nombre }}</p>
                            </div>
                            @endif

                            @if($producto->existencias)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Disponibilidad</h4>
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                    <p class="text-base font-semibold text-gray-900">En stock</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Botones de acción -->
                        <div class="space-y-3">
                            <!-- Botón principal de contacto -->
                            <button
                                data-whatsapp
                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.479 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.304 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                                <span>Contactar por WhatsApp</span>
                            </button>

                            <!-- Botones secundarios -->
                            <div class="grid grid-cols-2 gap-3">
                                <button
                                    data-favorite
                                    class="bg-white border-2 border-gray-300 text-gray-700 font-semibold py-2.5 px-4 rounded-xl hover:border-gray-400 hover:bg-gray-50 transition-all duration-200 flex items-center justify-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    <span class="hidden sm:inline text-sm">Favoritos</span>
                                </button>

                                <button
                                    data-share
                                    class="bg-white border-2 border-gray-300 text-gray-700 font-semibold py-2.5 px-4 rounded-xl hover:border-gray-400 hover:bg-gray-50 transition-all duration-200 flex items-center justify-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                    </svg>
                                    <span class="hidden sm:inline text-sm">Compartir</span>
                                </button>
                            </div>
                        </div>

                        <!-- Información de la tienda -->
                        @if($producto->tienda)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="text-base font-semibold text-gray-900 mb-3">Información de la tienda</h4>
                            <div class="flex items-center space-x-3">
                                @if($producto->tienda->logo_url)
                                    <img src="{{ asset($producto->tienda->logo_url) }}" alt="{{ $producto->tienda->nombre }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H7m2 0v-5a2 2 0 012-2h2a2 2 0 012 2v5"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">{{ $producto->tienda->nombre }}</p>
                                    @if($producto->tienda->direccion)
                                        <p class="text-xs text-gray-600">{{ $producto->tienda->direccion }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Productos relacionados o sugeridos -->
            <div class="mt-12">
                <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4">Productos similares</h2>
                    <div class="text-center py-8">
                        <svg class="mx-auto h-10 w-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <p class="text-gray-600 text-sm">Próximamente productos relacionados</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer mejorado -->
        <footer class="bg-gradient-to-r from-gray-900 to-gray-800 text-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    <!-- Información de la empresa -->
                    <div class="col-span-1">
                        <h3 class="text-lg font-semibold mb-4">RMS Tecnología y Redes</h3>
                        <p class="text-gray-300 text-sm leading-relaxed">
                            Conectando negocios con sus clientes a través de soluciones tecnológicas innovadoras.
                        </p>
                    </div>

                    <!-- Enlaces rápidos -->
                    <div class="col-span-1">
                        <h3 class="text-lg font-semibold mb-4">Enlaces rápidos</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="/" class="text-gray-300 hover:text-white transition-colors">Inicio</a></li>
                            <li><a href="/tiendas" class="text-gray-300 hover:text-white transition-colors">Tiendas</a></li>
                            <li><a href="/productos" class="text-gray-300 hover:text-white transition-colors">Productos</a></li>
                            <li><a href="/contacto" class="text-gray-300 hover:text-white transition-colors">Contacto</a></li>
                        </ul>
                    </div>

                    <!-- Redes sociales -->
                    <div class="col-span-1">
                        <h3 class="text-lg font-semibold mb-4">Síguenos</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21-.36.1-.74.15-1.13.15-.27 0-.54-.03-.8-.08.54 1.69 2.11 2.95 4 2.98-1.46 1.16-3.31 1.84-5.33 1.84-.35 0-.69-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.219-.359-1.219c0-1.142.662-1.995 1.488-1.995.219 0 .406.164.406.406 0 .219-.145.537-.219.835-.199.855.406 1.55 1.219 1.55 1.463 0 2.588-1.544 2.588-3.77 0-1.97-1.415-3.348-3.439-3.348-2.344 0-3.717 1.759-3.717 3.575 0 .219.083.406.199.537.199.246.199.406.145.662-.041.199-.145.406-.359.406-.199 0-.406-.83-.406-1.219 0-2.588 1.879-4.966 5.422-4.966 2.847 0 5.061 2.026 5.061 4.731 0 2.826-1.783 5.097-4.26 5.097-.83 0-1.612-.43-1.879-.95 0 0-.406 1.583-.502 1.879-.219.855-.83 1.925-1.243 2.588C9.626 23.815 10.8 24.001 12.017 24.001c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Línea divisoria y copyright -->
                <div class="mt-8 pt-8 border-t border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <p class="text-sm text-gray-400">
                            &copy; {{ date('Y') }} RMS Tecnología y Redes. Todos los derechos reservados.
                        </p>
                        <div class="mt-4 md:mt-0">
                            <div class="flex space-x-6 text-sm">
                                <a href="/privacidad" class="text-gray-400 hover:text-white transition-colors">Privacidad</a>
                                <a href="/terminos" class="text-gray-400 hover:text-white transition-colors">Términos</a>
                                <a href="/cookies" class="text-gray-400 hover:text-white transition-colors">Cookies</a>
                            </div>
                        </div>
                    </div>
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

            <!-- JavaScript personalizado para interactividad -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Función para compartir producto
                    const shareButton = document.querySelector('[data-share]');
                    if (shareButton) {
                        shareButton.addEventListener('click', function() {
                            if (navigator.share) {
                                navigator.share({
                                    title: '{{ $producto->nombre }}',
                                    text: '{{ $producto->descripcion }}',
                                    url: window.location.href
                                });
                            } else {
                                // Fallback para navegadores que no soportan Web Share API
                                const url = window.location.href;
                                navigator.clipboard.writeText(url).then(function() {
                                    showToast('Enlace copiado al portapapeles');
                                });
                            }
                        });
                    }

                    // Función para agregar a favoritos
                    const favoriteButton = document.querySelector('[data-favorite]');
                    if (favoriteButton) {
                        favoriteButton.addEventListener('click', function() {
                            // Aquí puedes agregar la lógica para favoritos
                            this.classList.toggle('text-red-500');
                            const icon = this.querySelector('svg');
                            icon.classList.toggle('fill-current');

                            const isFavorite = this.classList.contains('text-red-500');
                            showToast(isFavorite ? 'Agregado a favoritos' : 'Removido de favoritos');
                        });
                    }

                    // Función para contacto por WhatsApp
                    const whatsappButton = document.querySelector('[data-whatsapp]');
                    if (whatsappButton) {
                        whatsappButton.addEventListener('click', function() {
                            const productName = '{{ $producto->nombre }}';
                            const productPrice = '{{ number_format($producto->precio, 2) }}';
                            const message = `Hola, estoy interesado en el producto: ${productName} con precio $${productPrice}. ¿Podrías darme más información?`;
                            const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
                            window.open(whatsappUrl, '_blank');
                        });
                    }

                    // Función para mostrar toast notifications
                    function showToast(message) {
                        const toast = document.createElement('div');
                        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full';
                        toast.textContent = message;

                        document.body.appendChild(toast);

                        setTimeout(() => {
                            toast.classList.remove('translate-x-full');
                        }, 100);

                        setTimeout(() => {
                            toast.classList.add('translate-x-full');
                            setTimeout(() => {
                                document.body.removeChild(toast);
                            }, 300);
                        }, 3000);
                    }

                    // Efecto de zoom en la imagen
                    const productImage = document.querySelector('.product-image');
                    if (productImage) {
                        productImage.addEventListener('click', function() {
                            // Crear modal para imagen ampliada
                            const modal = document.createElement('div');
                            modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4';
                            modal.innerHTML = `
                                <div class="relative max-w-4xl max-h-full">
                                    <img src="${this.src}" alt="${this.alt}" class="max-w-full max-h-full object-contain rounded-lg">
                                    <button class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center hover:bg-opacity-75 transition-all duration-200">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            `;

                            document.body.appendChild(modal);

                            // Cerrar modal al hacer clic en el botón o fuera de la imagen
                            modal.addEventListener('click', function(e) {
                                if (e.target === modal || e.target.closest('button')) {
                                    document.body.removeChild(modal);
                                }
                            });
                        });
                    }

                    // Animaciones de entrada
                    const animatedElements = document.querySelectorAll('.fade-in');
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0)';
                            }
                        });
                    });

                    animatedElements.forEach(el => {
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(20px)';
                        el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                        observer.observe(el);
                    });
                });
            </script>

        </body>
    </html>
