<div x-data="carousel()"
     class="relative h-[500px] sm:h-[550px] md:h-[600px] overflow-hidden">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/40 z-10"></div>

    <!-- Slides -->
    <div class="relative h-full">
        <!-- Slide Principal -->
        <div x-show="activeSlide === 0"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 transform scale-105"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="absolute inset-0">

            <div class="absolute inset-0 flex items-center justify-center z-20">
                {{ $mainSlot ?? '' }}
            </div>

            <img src="{{ $mainImage }}"
                 class="w-full h-full object-cover object-center"
                 alt="{{ $mainAlt ?? 'Slide principal' }}" />
        </div>

        <!-- Slides adicionales -->
        @foreach($slides as $index => $slide)
            <div x-show="activeSlide === {{ $index + 1 }}"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform scale-105"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="absolute inset-0">

                <div class="absolute inset-0 flex items-center justify-center z-20">
                    {{ $slide['content'] ?? '' }}
                </div>

                <img src="{{ $slide['image'] }}"
                     class="w-full h-full object-cover object-center"
                     alt="{{ $slide['alt'] ?? 'Slide ' . ($index + 1) }}" />
            </div>
        @endforeach
    </div>

    <!-- Controles -->
    <div class="absolute inset-0 flex items-center justify-between z-20">
        <button @click="prevSlide" class="p-2 bg-black/30 text-white rounded-r-md hover:bg-black/50 focus:outline-none ml-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <button @click="nextSlide" class="p-2 bg-black/30 text-white rounded-l-md hover:bg-black/50 focus:outline-none mr-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>

    <!-- Indicadores -->
    <div class="absolute bottom-4 left-0 right-0 flex justify-center z-20">
        <button @click="activeSlide = 0"
                :class="{ 'bg-white': activeSlide === 0, 'bg-white/50': activeSlide !== 0 }"
                class="w-3 h-3 mx-1 rounded-full transition-colors duration-300 hover:bg-white"></button>

        @foreach($slides as $index => $slide)
            <button @click="activeSlide = {{ $index + 1 }}"
                    :class="{ 'bg-white': activeSlide === {{ $index + 1 }}, 'bg-white/50': activeSlide !== {{ $index + 1 }} }"
                    class="w-3 h-3 mx-1 rounded-full transition-colors duration-300 hover:bg-white"></button>
        @endforeach
    </div>
</div>

<script>
    function carousel() {
        return {
            activeSlide: 0,
            totalSlides: {{ count($slides) + 1 }},

            nextSlide() {
                this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
            },

            prevSlide() {
                this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
            },

            // Auto avance del carrusel
            init() {
                setInterval(() => {
                    this.nextSlide();
                }, {{ $interval ?? 5000 }});
            }
        }
    }
</script>
