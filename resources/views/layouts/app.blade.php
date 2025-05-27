<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'PetCare') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
    .animate-bounce {
        animation: bounce 1.5s infinite;
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-5px);
        }
    }

    [x-cloak] { display: none !important; }

    .map-container {
        height: 300px;
        width: 100%;
        border-radius: 0.5rem;
        overflow: hidden;
    }
</style>
</head>

<body class="font-sans antialiased">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm" x-data="{ open: false, userMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-xl font-bold text-gray-900">PetCare</a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/home') }}"
                       class="transition font-medium {{ Request::is('home') ? 'text-[#4EA757]' : 'text-gray-700 hover:text-[#4EA757]' }}">
                       Home
                    </a>
                    <a href="{{ url('/blog') }}"
                       class="transition font-medium {{ Request::is('blog') ? 'text-[#4EA757]' : 'text-gray-700 hover:text-[#4EA757]' }}">
                       Blog
                    </a>
                    <a href="{{ url('/services') }}"
                       class="transition font-medium {{ Request::is('services') ? 'text-[#4EA757]' : 'text-gray-700 hover:text-[#4EA757]' }}">
                       Services
                    </a>
                    <a href="{{ url('/consultation') }}"
                       class="transition font-medium {{ Request::is('consultation') ? 'text-[#4EA757]' : 'text-gray-700 hover:text-[#4EA757]' }}">
                       Consultation
                    </a>
                    <a href="{{ url('/about') }}"
                       class="transition font-medium {{ Request::is('About') ? 'text-[#4EA757]' : 'text-gray-700 hover:text-[#4EA757]' }}">
                       About Us
                    </a>
                </div>

                <!-- Desktop Auth -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <span class="text-gray-700">{{ Auth::user()->name }}</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                @if(Auth::user()->role_id === 1) <!-- Admin -->
                                    <a href="{{ url('/admin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Panel</a>
                                @endif
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('filament.admin.auth.login') }}" class="text-sm text-gray-700 hover:text-[#4EA757]">Admin Login</a>
                    @endauth
                </div>

                <!-- Mobile Hamburger -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" type="button"
                            class="text-gray-700 focus:outline-none focus:text-[#4EA757]">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden" x-show="open" @click.away="open = false" x-transition>
            <div class="pt-2 pb-4 space-y-1 px-4">
                <a href="{{ url('/home') }}"
                   class="block font-medium {{ Request::is('home') ? 'text-[#4EA757]' : 'text-gray-700 hover:text-[#4EA757]' }}">
                   Home
                </a>
                <a href="{{ url('/blog') }}"
                   class="block font-medium {{ Request::is('blog') ? 'text-[#4EA757]' : 'text-gray-700 hover:text-[#4EA757]' }}">
                   Blog
                </a>
                <a href="{{ url('/services') }}"
                    class="block font-medium {{ Request::is('services') ? 'text-[#4EA757]' : 'text-gray-700 hover:text-[#4EA757]' }}">
                    Services
                </a>
                <a href="{{ url('/consultation') }}"
                   class="block font-medium {{ Request::is('consultation') ? 'text-[#4EA757]' : 'text-gray-700 hover:text-[#4EA757]' }}">
                   Consultation
                </a>


                @auth
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-500">{{ Auth::user()->name }}</div>
                        </div>
                        <div class="mt-3 space-y-1">
                            @if(Auth::user()->role_id === 1) <!-- Admin -->
                                <a href="{{ url('/admin') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-[#4EA757] hover:bg-gray-50">Admin Panel</a>
                            @endif
                            <a href="{{ route('profile.show') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-[#4EA757] hover:bg-gray-50">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-3 py-2 text-base font-medium text-gray-700 hover:text-[#4EA757] hover:bg-gray-50">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="pt-4 border-t border-gray-200">
                        <a href="{{ route('filament.admin.auth.login') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-[#4EA757] hover:bg-gray-50">Admin Login</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        {{ $slot ?? '' }}
    </main>

    <!-- Enhanced Footer -->
    <footer class="bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 py-12">
                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Us</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1 text-[#4EA757]">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <p class="ml-3 text-base text-gray-600">
                                Jl. Brantas XXIV, Krajan Timur, Sumbersari, Kec. Sumbersari, Kabupaten Jember, Jawa Timur 68121
                            </p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1 text-[#4EA757]">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <p class="ml-3 text-base text-gray-600">
                                +62 822 2810 8805
                            </p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1 text-[#4EA757]">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <p class="ml-3 text-base text-gray-600">
                                petcaregacor05@gmail.com
                            </p>
                        </div>
                        <div class="flex space-x-4 mt-4">
                            {{-- <a href="#" class="text-gray-500 hover:text-[#4EA757]">
                                <i class="fab fa-facebook-f"></i>
                            </a> --}}
                            <a href="https://x.com/ferdiodwi" class="text-gray-500 hover:text-[#4EA757]">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://instagram.com/kelompokgacor5" class="text-gray-500 hover:text-[#4EA757]">
                                <i class="fab fa-instagram"></i>
                            </a>
                            {{-- <a href="#" class="text-gray-500 hover:text-[#4EA757]">
                                <i class="fab fa-linkedin-in"></i>
                            </a> --}}
                            <a href="https://wa.me/6282228108805" target="_blank" class="text-gray-500 hover:text-[#4EA757]">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Links</h3>
                    <div class="space-y-2">
                        <a href="{{ url('/home') }}" class="block text-base text-gray-600 hover:text-[#4EA757]">Home</a>
                        <a href="{{ url('/services') }}" class="block text-base text-gray-600 hover:text-[#4EA757]">Services</a>
                        <a href="{{ url('/blog') }}" class="block text-base text-gray-600 hover:text-[#4EA757]">Blog</a>
                        <a href="{{ url('/consultation') }}" class="block text-base text-gray-600 hover:text-[#4EA757]">Consultation</a>
                        <a href="{{ route('filament.admin.auth.login') }}" class="block text-base text-gray-600 hover:text-[#4EA757]">Admin Login</a>
                    </div>
                </div>

                <!-- Google Maps -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Our Location</h3>
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d648.9950676951127!2d113.70987542202141!3d-8.16465487253016!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd69597fd8a8fd1%3A0xaadeeb6c79d30c79!2sDe%20Las%20Vegas!5e0!3m2!1sid!2sid!4v1748111992137!5m2!1sid!2sid"
                            width="600"
                            height="450"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-200 py-6">
                <p class="text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} PetCare. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
