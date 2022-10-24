<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div>
        <x-jet-application-logo class="block h-12 w-auto" />
    </div>

    <div class="mt-8 text-2xl">
       Aplicación Web
    </div>

    <div class="mt-6 text-gray-500">
     
    </div>
</div>

<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
    <div class="p-6">
        <div class="flex items-center">
          
            <x-heroicon-s-user-group class="w-8 h-8 text-gray-400" />
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="{{route('clientes.index')}}">Clientes</a></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                Administrar clientes 
            </div>

            <a href="{{route('clientes.index')}}">
                <div class="mt-3 flex items-center text-sm font-semibold text-primario-700">
                        <div>Ir al módulo de clientes</div>

                        <div class="ml-1 text-primario-500">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </div>
                </div>
            </a>
        </div>
    </div>

    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
            {{-- class="w-8 h-8 text-gray-400" --}}
           
            <x-gmdi-signal-wifi-4-bar-tt  class="w-8 h-8 text-gray-400"/>
            {{-- <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> --}}
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="{{route('paquetes.index')}}">Paquetes</a></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
               Administra los paquetes de diferentes zonas(Coberturas)
            </div>

            <a href="{{route('paquetes.index')}}">
                <div class="mt-3 flex items-center text-sm font-semibold text-primario-700">
                        <div>Ir al módulo de paquetes</div>

                        <div class="ml-1 text-primario-500">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </div>
                </div>
            </a>
        </div>
    </div>

    <div class="p-6 border-t border-gray-200">
        <div class="flex items-center">
            <x-gmdi-place class="w-8 h-8 text-gray-400" />
           {{--  <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> --}}
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="{{route('zonas.index')}}">Zonas</a></div>
        </div>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
               Administra los lugares donde hay cobertura de Sattlink
            </div>

            <a href="{{route('zonas.index')}}">
                <div class="mt-3 flex items-center text-sm font-semibold text-primario-700">
                        <div>Ir al módulo de zonas</div>

                        <div class="ml-1 text-primario-500">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </div>
                </div>
            </a>
        </div>
    </div>
    
    <div class="p-6 border-t border-gray-200 md:border-l">
       <a href="{{route('instalaciones.index')}}">
        <div class="flex items-center">
            <x-gmdi-home-repair-service-r class="w-8 h-8 text-gray-400" />
            {{-- <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg> --}}
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Instalaciones</div>
        </div>
       </a>

        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
              Ver las instalaciones programadas del día de hoy, días posteriores
            </div>

            <a href="{{route('instalaciones.index')}}">
                <div class="mt-3 flex items-center text-sm font-semibold text-primario-700">
                        <div>Ir al módulo de Instalaciones</div>

                        <div class="ml-1 text-primario-500">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </div>
                </div>
            </a>

            {{-- icon de contrato <x-gmdi-contact-mail-tt /> --}}
        </div>
    </div>
    <div class="p-6 border-t border-gray-200 md:border-l">
        <a href="{{route('contrataciones.index')}}">
         <div class="flex items-center">
             <x-heroicon-o-document-text class="w-8 h-8 text-gray-400" />
             {{-- <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg> --}}
             <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Contratos</div>
         </div>
        </a>
 
         <div class="ml-12">
             <div class="mt-2 text-sm text-gray-500">
               Ver los contratos de las instalaciones programadas del día de hoy, días posteriores
             </div>
 
             <a href="{{route('contrataciones.index')}}">
                 <div class="mt-3 flex items-center text-sm font-semibold text-primario-700">
                         <div>Ir al módulo de contratos</div>
 
                         <div class="ml-1 text-primario-500">
                             <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                         </div>
                 </div>
             </a>
 
             {{-- icon de contrato <x-gmdi-contact-mail-tt /> --}}
         </div>
     </div>
     <div class="p-6 border-t border-gray-200 md:border-l">
        <a href="{{route('pagos.index')}}">
         <div class="flex items-center">
             <x-gmdi-payment-r class="w-8 h-8 text-gray-400" />
             {{-- <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg> --}}
             <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Pagos</div>
         </div>
        </a>
 
         <div class="ml-12">
             <div class="mt-2 text-sm text-gray-500">
               Ver los pagos realizados por los clientes
             </div>
 
             <a href="{{route('pagos.index')}}">
                 <div class="mt-3 flex items-center text-sm font-semibold text-primario-700">
                         <div>Ir al módulo de pagos</div>
 
                         <div class="ml-1 text-primario-500">
                             <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                         </div>
                 </div>
             </a>
 
             {{-- icon de contrato <x-gmdi-contact-mail-tt />    <x-gmdi-settings-input-antenna-r /> --}}
             
         </div>
     </div>
     <div class="p-6 border-t border-gray-200 md:border-l">
        <a href="{{route('mikrotik.export')}}">
         <div class="flex items-center">
             <x-gmdi-settings-input-antenna-r class="w-8 h-8 text-gray-400" />
             {{-- <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg> --}}
             <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Mikrotik</div>
         </div>
        </a>
 
         <div class="ml-12">
             <div class="mt-2 text-sm text-gray-500">
               Ver las configuración del servidor  Mikrotik
             </div>
 
             <a href="{{route('mikrotik.export')}}">
                 <div class="mt-3 flex items-center text-sm font-semibold text-primario-700">
                         <div>Ir al módulo de Mikrotik</div>
 
                         <div class="ml-1 text-primario-500">
                             <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                         </div>
                 </div>
             </a>
 
             {{-- icon de contrato <x-gmdi-contact-mail-tt />    <x-gmdi-settings-input-antenna-r /> --}}
             
         </div>
     </div>
</div>
