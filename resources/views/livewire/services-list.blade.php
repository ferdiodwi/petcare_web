<div class="min-h-screen bg-gray-50 font-sans">
    <!-- Hero Section -->
    <div class="relative bg-[#4EA757] overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-6 sm:pb-10 md:pb-12 lg:pb-12 xl:pb-8 bg-[#4EA757]">
            <div class="pt-10 sm:pt-14 lg:pt-12 lg:pb-10">
                <div class="mt-8 mx-auto max-w-7xl px-6 sm:mt-10 md:mt-12 lg:mt-14 xl:mt-20">
                    <div class="text-center">
                        <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                            <span class="block">Layanan Perawatan</span>
                            <span class="block text-[#e8f5e9] mt-2">Hewan Peliharaan Terbaik</span>
                        </h1>
                        <p class="mt-5 text-lg text-[#e8f5e9] sm:text-xl md:mt-6 max-w-3xl mx-auto">
                            Kami menyediakan layanan grooming dan boarding professional dengan standar tertinggi untuk kenyamanan hewan peliharaan Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Services Grid -->
    @if(!$selectedService)
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Pilih Layanan Kami
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 mx-auto">
                    Klik pada layanan untuk melihat detail lengkap dan paket yang tersedia
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 max-w-4xl mx-auto">
                @foreach($services as $service)
                <div class="bg-white rounded-xl p-8 hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-[#4EA757] cursor-pointer transform hover:-translate-y-2"
                     wire:click="selectService('{{ $service['id'] }}')">
                    <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-[#4EA757] text-white shadow-md mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $service['icon'] }}" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-2xl font-bold text-gray-900 text-center">{{ $service['title'] }}</h3>
                    <p class="mt-4 text-base text-gray-600 text-center">
                        {{ $service['short_description'] }}
                    </p>
                    <div class="mt-6 text-center">
                        <div class="inline-flex items-center space-x-4 text-sm text-gray-500">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-[#4EA757]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                                {{ $service['price_range'] }}
                            </span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-[#4EA757]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $service['duration'] }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-8 text-center">
                        <span class="inline-flex items-center text-[#4EA757] font-medium text-lg group">
                            Lihat Detail Lengkap
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Service Detail -->
    @if($selectedService)
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <!-- Back Button -->
            <div class="mb-8">
                <button wire:click="closeDetail"
                        class="inline-flex items-center text-[#4EA757] hover:text-[#3e8a4a] font-medium transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Layanan
                </button>
            </div>

            @php $service = $services[$selectedService]; @endphp

            <!-- Service Header -->
            <div class="bg-gradient-to-r from-[#4EA757] to-[#3e8a4a] rounded-2xl p-8 mb-12">
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-4">{{ $service['title'] }}</h1>
                        <p class="text-[#e8f5e9] text-lg mb-6">{{ $service['description'] }}</p>
                        <div class="flex flex-wrap gap-4 text-white">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                                {{ $service['price_range'] }}
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $service['duration'] }}
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <img src="{{ asset($service['image']) }}" alt="{{ $service['title'] }}"
                             class="w-full h-64 object-cover rounded-xl shadow-lg">
                    </div>
                </div>
            </div>

            <!-- Features & Packages -->
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Features -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Yang Kami Berikan</h2>
                    <div class="space-y-4">
                        @foreach($service['features'] as $feature)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#4EA757] mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="ml-3 text-gray-700">{{ $feature }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Packages -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Paket Layanan</h2>
                    <div class="space-y-6">
                        @foreach($service['packages'] as $package)
                        <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-semibold text-gray-900">{{ $package['name'] }}</h3>
                                <span class="text-2xl font-bold text-[#4EA757]">{{ $package['price'] }}</span>
                            </div>
                            <ul class="space-y-2">
                                @foreach($package['includes'] as $include)
                                <li class="flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4EA757] mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ $include }}
                                </li>
                                @endforeach
                            </ul>
                            <button class="mt-4 w-full bg-[#4EA757] text-white py-2 px-4 rounded-lg hover:bg-[#3e8a4a] transition-colors">
                                Pilih Paket Ini
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mt-16 bg-gradient-to-r from-[#4EA757] to-[#3e8a4a] rounded-2xl p-8 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Siap Memberikan yang Terbaik?</h2>
                <p class="text-[#e8f5e9] text-lg mb-8">Hubungi kami sekarang untuk mendapatkan layanan terbaik untuk hewan peliharaan Anda</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <button class="px-8 py-3 bg-white text-[#4EA757] font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                        Hubungi Sekarang
                    </button>
                    <button class="px-8 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-[#4EA757] transition-colors">
                        Lihat Jadwal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Testimonials -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Testimoni Klien
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 mx-auto">
                    Kepuasan mereka adalah prioritas utama kami
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Testimoni 1 -->
                <div class="bg-white rounded-xl p-8 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Sarah">
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Sarah Wijaya</h4>
                            <p class="text-[#4EA757]">Grooming Service</p>
                        </div>
                    </div>
                    <p class="text-gray-600">
                        "Layanan groomingnya luar biasa! Kucing Persia saya selalu terlihat cantik dan sehat setelah grooming di sini. Stafnya sangat profesional dan sabar."
                    </p>
                </div>

                <!-- Testimoni 2 -->
                <div class="bg-white rounded-xl p-8 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Budi">
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Budi Santoso</h4>
                            <p class="text-[#4EA757]">Boarding Service</p>
                        </div>
                    </div>
                    <p class="text-gray-600">
                        "Saya merasa tenang meninggalkan anjing Golden Retriever saya di sini. Fasilitasnya lengkap dan stafnya benar-benar peduli dengan hewan."
                    </p>
                </div>

                <!-- Testimoni 3 -->
                <div class="bg-white rounded-xl p-8 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Dewi">
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Dewi Lestari</h4>
                            <p class="text-[#4EA757]">Grooming & Boarding</p>
                        </div>
                    </div>
                    <p class="text-gray-600">
                        "Sudah 2 tahun menggunakan layanan grooming dan boarding di sini. Selalu puas dengan hasilnya. Harga juga sangat reasonable untuk kualitas yang diberikan."
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
