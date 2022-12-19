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
                                    href="/ventas">Ventas</a>
                                <a class="block px-3 py-2 rounded-2lg text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50"
                                    href="/agenda">Agenda</a>
                                <a class="block px-3 py-2 rounded-2lg text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50"
                                    href="/blog">Blog</a>
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