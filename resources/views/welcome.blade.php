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
<meta name="twitter:image" content="{{asset('img/logo.jpg')}}"> --}}
    <meta property="og:url" content="{{URL::to('/')}}">
    <meta property="og:title" content="test">
    <meta property="og:type" content="article">
    <meta property="og:description" content="test">
    <meta property="og:site_name" content="Test">
    <meta property="og:image" content="{{ asset('img/logo.jfif') }}">
    <meta name="site_name" content="Poner">
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
            <div id="newsletter-modal" data-controller="toggle newsletter"
                data-action="click@window-&gt;toggle#clickAway keyup@window-&gt;toggle#hideWithKeyboard"
                data-newsletter-is-modal-value="true" data-newsletter-is-subscribed-value="false">
                <div class="fixed inset-0 z-40 hidden overflow-y-auto" data-toggle-target='toggleable'
                    x-transition:leave="duration-300">
                    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 hidden transition-opacity" data-toggle-target='toggleable'
                            x-transition:enter-start='opacity-0' x-transition:enter-end='opacity-100'
                            x-transition:enter='ease-out duration-300' x-transition:leave='ease-in duration-200'
                            x-transition:leave-start='opacity-100' x-transition:leave-end='opacity-0'>

                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>

                        <!-- This element is to trick the browser into centering the modal contents. -->
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;

                        <div class="relative hidden inline-block max-w-3xl px-6 py-10 overflow-hidden align-top transition transform shadow-xl rounded-3xl bg-cool-indigo-600 sm:px-12 sm:py-20 sm:align-middle"
                            role="dialog" aria-modal="true" aria-labelledby="modal-headline"
                            data-toggle-target='toggleable toggleArea'
                            x-transition:enter-start='opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95'
                            x-transition:enter-end='opacity-100 translate-y-0 sm:scale-100'
                            x-transition:enter='ease-out duration-300' x-transition:leave='ease-in duration-200'
                            x-transition:leave-start='opacity-100 translate-y-0 sm:scale-100'
                            x-transition:leave-end='opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95'>

                            <div class="absolute top-0 right-0 pt-4 pr-4">
                                <button type="button"
                                    class="relative z-50 text-gray-300 bg-transparent rounded-md cursor-pointer hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cool-indigo-200 ring-offset-transparent"
                                    data-action='click->toggle#hide'>
                                    <span class="sr-only">Close</span>
                                    <!-- Heroicon name: outline/x -->
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div aria-hidden="true" class="absolute inset-0 -mt-72 sm:-mt-32 md:mt-0">
                                <svg class="absolute inset-0 w-full h-full" preserveAspectRatio="xMidYMid slice"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 1463 360">
                                    <path class="text-cool-indigo-500 text-opacity-40" fill="currentColor"
                                        d="M-82.673 72l1761.849 472.086-134.327 501.315-1761.85-472.086z" />
                                    <path class="text-cool-indigo-700 text-opacity-40" fill="currentColor"
                                        d="M-217.088 544.086L1544.761 72l134.327 501.316-1761.849 472.086z" />
                                </svg>
                            </div>
                            <div class="relative">
                                <div class="mb-12 sm:text-center">
                                    <span
                                        class="inline-flex items-center px-4 py-1 font-bold transform rounded-full sm:text-lg font-display bg-cool-indigo-100 text-cool-indigo-800 -rotate-3">
                                        Hey there!
                                    </span>
                                    <h2
                                        class="mt-6 text-3xl font-extrabold text-white tracking-tight sm:text-4.5xl font-display sm:leading-extra-tight">
                                        Want to get notified when I add new Tailwind designs?
                                    </h2>
                                    <p class="max-w-2xl mx-auto mt-6 text-lg text-cool-indigo-100">
                                        Twice a month I share the best Tailwind templates, UI kits and components in <strong>my
                                            newsletter</strong>. <strong>210</strong> Tailwind hackers find it useful. I'd love
                                        you to join.
                                    </p>
                                </div>
                                <form target="_blank"
                                    data-action="submit-&gt;newsletter#onSubmit ajax:success-&gt;newsletter#onSuccess"
                                    data-newsletter-target="form" class="sm:mx-auto sm:max-w-lg sm:flex"
                                    action="https://www.getrevue.co/profile/tailwindawesome/add_subscriber"
                                    accept-charset="UTF-8" method="post"><input type="hidden"
                                        name="authenticity_token"
                                        value="wL2ui3Rl4gEajcvgrUoZu9fyZC6ldQ3Hbucxd6e88K_4QbA9qUxhqmf2T3IlQAgYo96qxRdh9KXrNN-mtZXA2A"
                                        autocomplete="off" />
                                    <div class='relative w-full max-w-xl mx-auto bg-white rounded-full h-14 lg:max-w-none'>
                                        <input
                                            class="rounded-full w-full h-14 bg-transparent py-0 sm:pl-6 pl-5 pr-16 sm:pr-32 outline-none border-2 border-gray-100 shadow-md hover:border-0 hover:ring-0 hover:outline-none focus:ring-cool-indigo-200 focus:border-cool-indigo-200"
                                            data-newsletter-target="email" required="required"
                                            placeholder="Enter your email" autocomplete="email" type="email"
                                            name="member[email]" id="member[email]" />
                                        <button type='submit'
                                            class='absolute inline-flex items-center h-12 p-4 text-sm text-white transition duration-150 duration-300 ease-in-out rounded-r-full rounded-bl-full outline-none right-1 top-1 bg-cool-indigo-600 sm:py-2 sm:px-6 sm:rounded-full sm:text-base sm:font-medium hover:bg-cool-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cool-indigo-500'>

                                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 sm:-ml-1 sm:mr-2 h-5 w-5"
                                                width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <line x1="10" y1="14" x2="21" y2="3" />
                                                <path
                                                    d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5" />
                                            </svg>
                                            <span class='hidden sm:inline-block'>
                                                Try it
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div data-controller="toggle"
                data-action="click@window->toggle#clickAway keyup@window->toggle#hideWithKeyboard">
                <div class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
                    aria-modal="true" data-toggle-target='toggleable' x-transition:leave="duration-300">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
                        <!--
                        Background overlay, show/hide based on modal state.

                        Entering: "ease-out duration-300"
                          From: "opacity-0"
                          To: "opacity-100"
                        Leaving: "ease-in duration-200"
                          From: "opacity-100"
                          To: "opacity-0"
                      -->
                        <div class="fixed inset-0 hidden transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"
                            data-toggle-target='toggleable' x-transition:enter-start='opacity-0'
                            x-transition:enter-end='opacity-100' x-transition:enter='ease-out duration-300'
                            x-transition:leave='ease-in duration-200' x-transition:leave-start='opacity-100'
                            x-transition:leave-end='opacity-0'></div>

                        <!-- This element is to trick the browser into centering the modal contents. -->
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                        <!--
                        Modal panel, show/hide based on modal state.

                        Entering: "ease-out duration-300"
                          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                          To: "opacity-100 translate-y-0 sm:scale-100"
                        Leaving: "ease-in duration-200"
                          From: "opacity-100 translate-y-0 sm:scale-100"
                          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                      -->

                        <div class="hidden inline-block max-w-lg overflow-hidden text-left align-bottom transition-all transform bg-white shadow-xl rounded-2xl sm:my-8 sm:align-middle lg:max-w-6xl sm:w-full"
                            data-toggle-target='toggleable toggleArea'
                            x-transition:enter-start='opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95'
                            x-transition:enter-end='opacity-100 translate-y-0 sm:scale-100'
                            x-transition:enter='ease-out duration-300' x-transition:leave='ease-in duration-200'
                            x-transition:leave-start='opacity-100 translate-y-0 sm:scale-100'
                            x-transition:leave-end='opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95'>

                            <div class="absolute top-0 right-0 pt-4 pr-4 sm:pt-6 sm:pr-6">
                                <button type="button"
                                    class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    data-action='click->toggle#hide'>
                                    <span class="sr-only">Close</span>
                                    <!-- Heroicon name: outline/x -->
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>


                            <div class="lg:grid lg:grid-cols-2">
                                <!-- This example requires Tailwind CSS v2.0+ -->
                                <div class="hidden bg-indigo-700 rounded-l-2xl lg:block">
                                    <div class="px-4 py-14 sm:px-6 lg:px-12">
                                        <h2 class="text-3xl font-extrabold tracking-tight text-white">Inbox support built for
                                            efficiency</h2>
                                        <p class="max-w-3xl mt-4 text-lg text-indigo-200">Ac tincidunt sapien vehicula erat
                                            auctor pellentesque rhoncus. Et magna sit morbi lobortis. Blandit aliquam sit nisl
                                            euismod mattis in.</p>
                                        <div class="grid grid-cols-1 mt-12 gap-y-12">
                                            <div class='flex'>
                                                <div>
                                                    <span
                                                        class="flex items-center justify-center w-12 h-12 bg-white rounded-md bg-opacity-10">
                                                        <!-- Heroicon name: outline/inbox -->
                                                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="ml-6">
                                                    <h3 class="text-lg font-medium text-white">Unlimited Inboxes</h3>
                                                    <p class="mt-2 text-base text-indigo-200">Ac tincidunt sapien vehicula
                                                        erat auctor pellentesque rhoncus. Et magna sit morbi lobortis.</p>
                                                </div>
                                            </div>

                                            <div class='flex'>
                                                <div>
                                                    <span
                                                        class="flex items-center justify-center w-12 h-12 bg-white rounded-md bg-opacity-10">
                                                        <!-- Heroicon name: outline/users -->
                                                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="ml-6">
                                                    <h3 class="text-lg font-medium text-white">Manage Team Members</h3>
                                                    <p class="mt-2 text-base text-indigo-200">Ac tincidunt sapien vehicula
                                                        erat auctor pellentesque rhoncus. Et magna sit morbi lobortis.</p>
                                                </div>
                                            </div>


                                            <div class="flex">
                                                <div>
                                                    <span
                                                        class="flex items-center justify-center w-12 h-12 bg-white rounded-md bg-opacity-10">
                                                        <!-- Heroicon name: outline/pencil-alt -->
                                                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="ml-6">
                                                    <h3 class="text-lg font-medium text-white">Compose in Markdown</h3>
                                                    <p class="mt-2 text-base text-indigo-200">Ac tincidunt sapien vehicula
                                                        erat auctor pellentesque rhoncus. Et magna sit morbi lobortis.</p>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="flex flex-col justify-center flex-1 px-8 py-10 sm:py-14 lg:flex-none sm:px-12 xl:px-24">
                                    <div class="w-full max-w-lg mx-auto lg:w-96">
                                        <div>
                                            <h2 class="text-3xl font-extrabold text-gray-900">Sign in to your account</h2>
                                            <p class="mt-2 text-sm text-gray-600">
                                                Or
                                                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                                    start your 14-day free trial </a>
                                            </p>
                                        </div>

                                        <div class="mt-8">
                                            <div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-700">Sign in with</p>

                                                    <div class="grid grid-cols-3 gap-3 mt-1">
                                                        <div>
                                                            <a href="#"
                                                                class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                                                                <span class="sr-only">Sign in with Facebook</span>
                                                                <svg class="w-5 h-5" fill="currentColor"
                                                                    viewBox="0 0 20 20" aria-hidden="true">
                                                                    <path fill-rule="evenodd"
                                                                        d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </a>
                                                        </div>

                                                        <div>
                                                            <a href="#"
                                                                class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                                                                <span class="sr-only">Sign in with Twitter</span>
                                                                <svg class="w-5 h-5" fill="currentColor"
                                                                    viewBox="0 0 20 20" aria-hidden="true">
                                                                    <path
                                                                        d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" />
                                                                </svg>
                                                            </a>
                                                        </div>

                                                        <div>
                                                            <a href="#"
                                                                class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                                                                <span class="sr-only">Sign in with GitHub</span>
                                                                <svg class="w-5 h-5" fill="currentColor"
                                                                    viewBox="0 0 20 20" aria-hidden="true">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="relative mt-6">
                                                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                                        <div class="w-full border-t border-gray-300"></div>
                                                    </div>
                                                    <div class="relative flex justify-center text-sm">
                                                        <span class="px-2 text-gray-500 bg-white"> Or continue with </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-6">
                                                <form action="#" method="POST" class="space-y-6">
                                                    <div>
                                                        <label for="name"
                                                            class="block text-sm font-medium text-gray-700"> Name </label>
                                                        <div class="mt-1">
                                                            <input id="name" name="name" type="text"
                                                                autocomplete="name" required
                                                                class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for="email"
                                                            class="block text-sm font-medium text-gray-700"> Email address
                                                        </label>
                                                        <div class="mt-1">
                                                            <input id="email" name="email" type="email"
                                                                autocomplete="email" required
                                                                class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                        </div>
                                                    </div>

                                                    <div class="space-y-1">
                                                        <label for="password"
                                                            class="block text-sm font-medium text-gray-700"> Password </label>
                                                        <div class="mt-1">
                                                            <input id="password" name="password" type="password"
                                                                autocomplete="current-password" required
                                                                class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center">
                                                            <input id="remember-me" name="remember-me" type="checkbox"
                                                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                            <label for="remember-me"
                                                                class="block ml-2 text-sm text-gray-900"> Remember me </label>
                                                        </div>

                                                        <div class="text-sm">
                                                            <a href="#"
                                                                class="font-medium text-indigo-600 hover:text-indigo-500">
                                                                Forgot your password? </a>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <button type="submit"
                                                            class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Sign
                                                            in</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <!-- Global toast live region -->
            <div aria-live="assertive"
                class="fixed inset-0 z-50 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start">
                <div id='flash-messages' class="flex flex-col items-center w-full space-y-4 sm:items-end">


                </div>
            </div>

            @livewireScripts

        </body>

        </html>
