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
    <meta property="og:url" content="{{ URL::to('/hotspot/preview/'.$zona->id) }}">
    <meta property="og:title" content="preview {{$zona->nombre}}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="Hotspot {{$zona->nombre}}">
    <meta property="og:site_name" content="RMS">
    <meta property="og:image" content="{{ asset('img/logo.jfif') }}">
    <meta name="site_name" content="RMS">
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <!-- Styles -->

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    {{--  <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> --}}
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('js/frontend.js') }}" defer></script>
    <script src="{{asset('js/tw-elements.js')}}" defer></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.jfif') }}" />
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    @livewireStyles
</head>
{{-- valores de hotspot --}}
@php
    $mac=$_POST['mac'];
    $ip=$_POST['ip'];
    $username=$_POST['username'];
    $linklogin=$_POST['link-login'];
    $linkorig=$_POST['link-orig'];
    $error=$_POST['error'];
    $chapid=$_POST['chap-id'];
    $chapchallenge=$_POST['chap-challenge'];
    $linkloginonly=$_POST['link-login-only'];
    $linkorigesc=$_POST['link-orig-esc'];
    $macesc=$_POST['mac-esc'];
    @endphp
<body class="antialiased" >

     <!-- $(if chap-id) -->
  
     <form name="sendin" action="<?php echo $linkloginonly; ?>" method="post">
        <input type="hidden" name="username" />
        <input type="hidden" name="password" />
        <input type="hidden" name="dst" value="<?php echo $linkorig; ?>" />
        <input type="hidden" name="popup" value="true" />
    </form>
    
    <script type="text/javascript" src="{{asset('/js/md5.js')}}"></script>
    <script type="text/javascript">
    
        function doLogin() {
                <?php if(strlen($chapid) < 1) echo "return true;"; ?>
        document.sendin.username.value = document.login.username.value;
        document.sendin.password.value = hexMD5('<?php echo  $chapid; ?>' + document.login.password.value + '<?php echo $chapchallenge; ?>');
        document.sendin.submit();
        return false;
        }
    
    </script>
 <!-- $(endif) -->
    



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
                                        >


                                        <img src="{{ asset('img/logo.jfif') }}" alt="" width="48"
                                            class="object-contain h-10 w-10">
                                    </a>
                                </div>
                                <div class="hidden lg:ml-6 xl:ml-8 lg:flex lg:space-x-8" data-turbo=false>
                                    <!-- Current: "border-indigo-500 text-gray-900", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->
                                    <a class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
                                        href="/">Inicio</a>
                                    {{-- <a class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
                                        href="/">Ventas</a>
                                    <a class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
                                        href="/?type=kit">Agenda</a>
                                    <a class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
                                        href="/?price=free">Blog</a> --}}
                                  {{--   @if (Route::has('login'))

                                        @auth
                                            <a href="{{ url('/dashboard') }}"
                                                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Dashboard</a>
                                        @else
                                            <a href="{{ route('login') }}"
                                                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Login</a>

                                          
                                        @endif


                                        @endif --}}
                                    </div>
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
                               {{--  <a class="block px-3 py-2 rounded-2lg text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50"
                                    href="/?type=template">Templates</a>
                                <a class="block px-3 py-2 rounded-2lg text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50"
                                    href="/?type=kit">UI kits</a> --}}
                              {{--   <a class="block px-3 py-2 rounded-2lg text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50"
                                    href="/blog">Blog</a> --}}
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
                        </nav>


                        <main class="px-4 mx-auto mt-10 max-w-7xl sm:mt-14">

                            <div id="carouselExampleCrossfade" class="carousel slide carousel-fade relative"
                                data-bs-ride="carousel">
                                <div class="carousel-indicators absolute right-0 bottom-0 left-0 flex justify-center p-0 mb-4">
                                    <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="0"
                                        class="active" aria-label="Slide 1"></button>
                                    @forelse ($zona->imagenes as $key => $item)
                                        <button type="button" data-bs-target="#carouselExampleCrossfade"
                                            data-bs-slide-to="{{ $key + 1 }}" {{-- class="active" --}} aria-current="true"
                                            aria-label="Slide {{ $key + 1 }}"></button>
                                    @empty
                                    @endforelse

                                    {{-- <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="1"
                                        aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="2"
                                        aria-label="Slide 3"></button> --}}
                                </div>
                                <div class="carousel-inner relative w-full overflow-hidden">
                                    <div class="carousel-item active float-left w-full">
                                        <img src="{{ asset('img/jaca_fondo.jfif') }}" class="object-contain md:object-scale-down h-48 w-full"
                                            alt="Wild Landscape" />
                                    </div>
                                    @forelse ($zona->imagenes->shuffle() as $item)
                                        <div class="carousel-item float-left w-full">
                                            <img src="{{ asset($item->imagen_url) }}" class="object-contain md:object-scale-down h-48 w-full"
                                                alt="Img-{{ $item->id }}" />
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
                                <!-- $(if trial == 'yes') -->
                                    <h1
                                        class="text-3xl font-extrabold tracking-tight text-gray-900 font-display sm:text-3xl md:text-3xl xl:text-3xl">
                                        {{--  <span class="block xl:inline">Discover the best</span> --}}
                                        <span class="block text-amarillo-600">Internet Gratis</span>
                                    </h1>
                                    <div class="text-center">
                                        {{--  <span class="block text-md font-medium text-amarillo-300">Internet Gratis </span> --}}
                                        <a class="flex justify-center w-80 mx-auto px-4 py-2 my-3 text-sm font-medium text-white bg-amarillo-600 border border-transparent rounded-md shadow-sm hover:bg-amarillo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amarillo-500" id="boton_gratis"><span id="countdown"></span></a>
                                    </div>

                                <!-- $(endif) -->
                                <!-- removed $(if chap-id) $(endif)  around OnSubmit -->
                                <form name="login" action="<?php echo $linkloginonly; ?>" method="post" onSubmit="return doLogin()" >
                                    <input type="hidden" name="dst" value="<?php echo $linkorig; ?>" />
                                    <input type="hidden" name="popup" value="true" />
                                <p
                                    class="max-w-md mx-auto mt-3 text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                                <div class="text-center mx-auto mb-3">
                                        <p>Inicie sesión para utilizar este servicio</p>
                                        <label for="user"
                                            class="block text-sm font-medium text-gray-700">Login
                                        </label>
                                        <div class="mt-1 text-center mx-auto">
                                            <input name="username" type="text" value="<?php echo $username; ?>" 
                                                class="block w-80  md:w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm mx-auto">
                                        </div>
                                    </div>

                                    <div class="space-y-1">
                                        <label for="password"
                                            class="block text-sm font-medium text-gray-700"> Password </label>
                                        <div class="mt-1">
                                            <input id="password" name="password" type="password"
                                                 
                                                class="block w-80 sm:w-80  px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm mx-auto">
                                        </div>
                                    </div> 
                                    <div class="space-y-1 mt-4 ">
                                        <button type="submit"
                                            class="flex justify-center w-80 mx-auto px-4 py-2 my-3 text-sm font-medium text-white bg-amarillo-600 border border-transparent rounded-md shadow-sm hover:bg-amarillo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amarillo-500">Entrar
                                            </button>
                                    </div>
                                    <!-- $(if error) -->
                                    <br /><div style="color: #FF8080; font-size: 14px"><?php echo $error; ?></div>
                                    <!-- $(endif) -->
                                </p>
                                </form>
                                

                            </div>
                        </main>
                    </div>
                </div>

            


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


            @livewireScripts
            <script src="{{asset('/js/hotspot/cuenta_regresiva.js')}}" defer></script>
        </body>

        </html>
