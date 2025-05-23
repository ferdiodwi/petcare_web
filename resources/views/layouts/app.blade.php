<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'PetCare') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" />

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
                       class="transition font-medium {{ Request::is('home') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                       Home
                    </a>
                    <a href="{{ url('/blog') }}"
                       class="transition font-medium {{ Request::is('blog') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                       Blog
                    </a>
                    <a href="{{ url('/consultation') }}"
                       class="transition font-medium {{ Request::is('consultation') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                       Consultation
                    </a>
                    <a href="{{ url('/services') }}"
                       class="transition font-medium {{ Request::is('services') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                       Services
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
                        {{-- <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-600">Login</a>
                        <a href="{{ route('register') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Register</a> --}}
                        <a href="{{ route('filament.admin.auth.login') }}" class="text-sm text-gray-700 hover:text-indigo-600">Admin Login</a>
                    @endauth
                </div>

                <!-- Mobile Hamburger -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" type="button"
                            class="text-gray-700 focus:outline-none focus:text-indigo-600">
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
                   class="block font-medium {{ Request::is('home') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                   Home
                </a>
                <a href="{{ url('/blog') }}"
                   class="block font-medium {{ Request::is('blog') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                   Blog
                </a>
                <a href="{{ url('/consultation') }}"
                   class="block font-medium {{ Request::is('consultation') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                   Consultation
                </a>
                <a href="{{ url('/services') }}"
                    class="block font-medium {{ Request::is('services') ? 'text-indigo-600' : 'text-gray-700 hover:text-indigo-600' }}">
                    Services
                </a>

                @auth
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-500">{{ Auth::user()->name }}</div>
                        </div>
                        <div class="mt-3 space-y-1">
                            @if(Auth::user()->role_id === 1) <!-- Admin -->
                                <a href="{{ url('/admin') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Admin Panel</a>
                            @endif
                            <a href="{{ route('profile.show') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="pt-4 border-t border-gray-200">
                        {{-- <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Login</a>
                        <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Register</a> --}}
                        <a href="{{ route('filament.admin.auth.login') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Admin Login</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        {{ $slot ?? '' }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm">&copy; {{ date('Y') }} PetCare. All rights reserved.</p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
