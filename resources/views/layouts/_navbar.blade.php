<nav x-data="navState" @scroll.window="initState" id="main-nav" class="sticky top-0 left-0 right-0 z-50 text-white shadow-md bg-brand-gray">
    <div id="nav" class="container sticky top-0 left-0 w-full py-2 mx-auto">
        <div class="relative flex items-center justify-between h-16">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <button @click="toggleMobileNav()" type="button"
                    class="inline-flex items-center justify-center p-2 text-white border border-gray-300 rounded-md active:text-brand-gray active:bg-brand-cream focus:outline-none focus:border-0 focus:ring-2 focus:ring-inset focus:ring-brand-orange-500 focus:text-brand-gray focus:bg-brand-cream"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">{{ __('Open main menu') }}</span>
                    <svg class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="hidden w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center content-center justify-center flex-1 sm:items-stretch sm:justify-between">
                <div class="hidden sm:block sm:ml-6">
                    <div class="flex space-x-4">
                        <a href="{{ route('home') }}"
                            class="px-3 py-2 text-base font-medium transition duration-300 ease-out hover:text-brand-cream {{ request()->routeIs('home') ?  'text-brand-cream' : '' }}">
                            Beranda
                        </a>
                        <a href="{{ route('pricing') }}"
                            class="px-3 py-2 text-base font-medium transition duration-300 ease-out hover:text-brand-cream {{ request()->routeIs('pricing') ?  'text-brand-cream' : '' }}">
                            Pricing
                        </a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <div class="relative ml-3" x-data="{ isUserMenuOpen: false }">
                    <div class="flex flex-row gap-2">
                        @guest
                        <x-button-a href="{{ route('login') }}"
                            class="invisible px-6 tracking-normal text-brand-gray capitalize transition-colors duration-200 transform !rounded-full bg-white border-white hover:bg-brand-cream sm:visible">
                            <span class="mx-1">Login</span>
                        </x-button-a>
                        @else
                        <button @click="isUserMenuOpen = !isUserMenuOpen" @keydown.escape="isUserMenuOpen = false"
                            type="button"
                            class="flex items-center px-3 py-2 text-base font-medium transition duration-300 ease-out group hover:text-brand-cream focus:ring-0" :class="isUserMenuOpen && 'text-brand-cream'"
                            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            Welcome, {{ strtok(auth()->user()->name, ' ') }} 
                            <svg class="ml-1.5 group-hover:fill-brand-cream" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 256 256"><path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,48,88H208a8,8,0,0,1,5.66,13.66Z"></path></svg>
                        </button>
                        @endguest
                    </div>

                    @auth
                    <template x-if="true">
                        <div x-show="isUserMenuOpen" @click.away="isUserMenuOpen = false" x-transition
                            class="absolute right-0 w-48 py-1 mt-2 origin-top-right rounded-md shadow-lg bg-brand-gray ring-1 ring-brand-cream focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
    
                            @if (auth()->user()->role == "pelukis")
                                <a href="{{ route('dashboard.paintings')}}"
                                    class="block px-4 py-2 text-sm hover:text-brand-cream"
                                    role="menuitem">
                                    <i class="fas fa-user fa-fw"></i>&nbsp;Dashboard Pelukis
                                </a>
                            @elseif (auth()->user()->role == "kurator")
                                <a href="{{ route('dashboard.kurator.paintings') }}"
                                    class="block px-4 py-2 text-sm hover:text-brand-cream"
                                    role="menuitem">
                                    <i class="fas fa-user fa-fw"></i>&nbsp;Dashboard Kurator
                                </a>
                            @endif
                                
                            <a href=""
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="block px-4 py-2 text-sm hover:text-brand-cream"
                                role="menuitem">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>&nbsp;Logout
                            </a>
    
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </template>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    <div class="absolute z-10 w-full p-1 sm:hidden" id="mobile-menu" x-show="showMobileNav"
        @click.away="showMobileNav = false" x-transition>
        <div class="px-2 pt-2 pb-3 space-y-1 text-white border rounded-md shadow-lg bg-brand-gray border-brand-cream">
            <a href="{{ route('home') }}"
                class="block px-3 py-2 text-base font-medium rounded-md hover:text-brand-cream">
                Beranda
            </a>
            <a href="{{ route('pricing')}}"
                class="block px-3 py-2 text-base font-medium rounded-md hover:text-brand-cream">
                Pricing
            </a>
    
            @guest
                <hr>
                <a href="{{ route('login') }}"
                    class="block px-3 py-2 mt-2 text-base font-medium bg-white rounded-md text-brand-gray hover:bg-brand-cream">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-6 h-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span class="mx-1">Login</span>
                </a>
            @endauth
        </div>
    </div>
</nav>

@push('script')
<script>
navState = () => ({
    navTheme: "",
    showMobileNav: false,

    initState() {
        if (window.pageYOffset > 0) {
            this.navTheme = "nav-dark";
        } else {
            this.navTheme = "nav-light";
        }
    },

    toggleMobileNav() {
        this.showMobileNav = !this.showMobileNav
    }
})
</script>
@endpush