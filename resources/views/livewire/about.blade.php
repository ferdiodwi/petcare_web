<div class="min-h-screen bg-gray-50 font-sans">
    <!-- Hero Section -->
    <div class="relative bg-[#4EA757] overflow-hidden">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-20"
                 src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80"
                 alt="Pet care background">
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-6 sm:py-32 sm:px-8 lg:px-10">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                    <span class="block animate-fade-in-down">Tentang Kami</span>
                    <span class="block text-[#e8f5e9] mt-2">Dedikasi untuk Hewan Peliharaan</span>
                </h1>
                <p class="mt-6 max-w-3xl text-xl text-[#e8f5e9] mx-auto">
                    Sejak 2016, kami telah berkomitmen memberikan perawatan terbaik untuk hewan peliharaan dengan penuh kasih sayang dan profesionalisme tinggi.
                </p>
            </div>
        </div>
    </div>

    <!-- Company Story -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl mb-6">
                        Kisah Kami
                    </h2>
                    <div class="space-y-4 text-gray-600 text-lg">
                        <p>
                            PetCare lahir dari kecintaan mendalam terhadap hewan peliharaan. Dimulai dengan sebuah klinik kecil, kami memiliki visi sederhana namun mulia: memberikan perawatan terbaik untuk setiap hewan yang dipercayakan kepada kami.
                        </p>
                        <p>
                            Dengan tim yang terdiri dari dokter hewan berpengalaman, groomer bersertifikat, dan caregiver yang penuh kasih sayang, kami telah melayani ribuan hewan peliharaan dan keluarga mereka.
                        </p>
                        <p>
                            Hari ini, PetCare telah berkembang menjadi pusat layanan pet care terpercaya dengan fasilitas modern dan teknologi terdepan, namun nilai-nilai inti kami tetap sama: kasih sayang, profesionalisme, dan dedikasi.
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                         alt="Pet care story"
                         class="w-full h-96 object-cover rounded-2xl shadow-lg">
                    <div class="absolute -bottom-6 -right-6 bg-[#4EA757] text-white p-6 rounded-xl shadow-lg">
                        <div class="text-center">
                            <div class="text-3xl font-bold">8+</div>
                            <div class="text-sm">Tahun Melayani</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics -->
    <section class="py-16 bg-[#4EA757]">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    Pencapaian Kami
                </h2>
                <p class="mt-4 text-xl text-[#e8f5e9]">
                    Angka-angka yang membanggakan dari perjalanan kami
                </p>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($stats as $stat)
                <div class="text-center">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-white/20 text-white mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}" />
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-white mb-2">{{ $stat['number'] }}</div>
                    <div class="text-[#e8f5e9]">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Nilai-Nilai Kami
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 mx-auto">
                    Prinsip yang memandu setiap langkah perjalanan kami
                </p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($values as $value)
                <div class="bg-white rounded-xl p-8 text-center hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-[#4EA757] text-white mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $value['icon'] }}" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $value['title'] }}</h3>
                    <p class="text-gray-600">{{ $value['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Timeline -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Perjalanan Kami
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 mx-auto">
                    Milestone penting dalam sejarah PetCare
                </p>
            </div>
            <div class="relative">
                <!-- Timeline line -->
                <div class="absolute left-1/2 transform -translate-x-px h-full w-0.5 bg-[#4EA757]"></div>

                <div class="space-y-12">
                    @foreach($milestones as $index => $milestone)
                    <div class="relative flex items-center {{ $index % 2 == 0 ? 'justify-start' : 'justify-end' }}">
                        <!-- Timeline dot -->
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-[#4EA757] rounded-full border-4 border-white shadow-lg z-10"></div>

                        <!-- Content -->
                        <div class="w-5/12 {{ $index % 2 == 0 ? 'pr-8 text-right' : 'pl-8 text-left' }}">
                            <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow">
                                <div class="text-2xl font-bold text-[#4EA757] mb-2">{{ $milestone['year'] }}</div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $milestone['title'] }}</h3>
                                <p class="text-gray-600">{{ $milestone['description'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Tim Profesional Kami
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 mx-auto">
                    Bertemu dengan para ahli yang berdedikasi merawat hewan peliharaan Anda
                </p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($teamMembers as $member)
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="h-64 overflow-hidden">
                        <img src="{{ $member['image'] }}"
                             alt="{{ $member['name'] }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">{{ $member['name'] }}</h3>
                        <p class="text-[#4EA757] font-medium mb-2">{{ $member['position'] }}</p>
                        <p class="text-sm text-gray-600 mb-3">{{ $member['specialization'] }}</p>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $member['experience'] }} pengalaman
                        </div>
                        <p class="text-gray-600 text-sm">{{ $member['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Facilities -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Fasilitas Modern
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 mx-auto">
                    Dilengkapi dengan teknologi terdepan untuk kenyamanan hewan peliharaan
                </p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="relative group overflow-hidden rounded-xl">
                    <img src="https://images.unsplash.com/photo-1628009368231-7bb7cfcb0def?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Medical facility"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-xl font-semibold mb-2">Ruang Medis</h3>
                        <p class="text-sm">Dilengkapi peralatan medis modern</p>
                    </div>
                </div>
                <div class="relative group overflow-hidden rounded-xl">
                    <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Grooming area"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-xl font-semibold mb-2">Area Grooming</h3>
                        <p class="text-sm">Ruang grooming yang nyaman dan higienis</p>
                    </div>
                </div>
                <div class="relative group overflow-hidden rounded-xl">
                    <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Play area"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-xl font-semibold mb-2">Area Bermain</h3>
                        <p class="text-sm">Ruang bermain luas untuk aktivitas hewan</p>
                    </div>
                </div>
                <div class="relative group overflow-hidden rounded-xl">
                    <img src="https://images.unsplash.com/photo-1530281700549-e82e7bf110d6?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Boarding rooms"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-xl font-semibold mb-2">Kamar Boarding</h3>
                        <p class="text-sm">Kamar ber-AC dengan tempat tidur nyaman</p>
                    </div>
                </div>
                <div class="relative group overflow-hidden rounded-xl">
                    <img src="https://images.unsplash.com/photo-1415369629372-26f2fe60c467?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Reception area"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-xl font-semibold mb-2">Area Resepsionis</h3>
                        <p class="text-sm">Ruang tunggu yang nyaman untuk pemilik</p>
                    </div>
                </div>
                <div class="relative group overflow-hidden rounded-xl">
                    <img src="https://images.unsplash.com/photo-1581888227599-779811939961?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                         alt="Garden area"
                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-xl font-semibold mb-2">Taman Outdoor</h3>
                        <p class="text-sm">Area outdoor untuk aktivitas dan olahraga</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative bg-[#4EA757] overflow-hidden">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-10"
                 src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80"
                 alt="Background pattern">
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-6 sm:py-32 sm:px-8 lg:px-10">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">Bergabunglah dengan Keluarga PetCare</span>
                    <span class="block mt-2 text-[#e8f5e9]">Kepercayaan Anda adalah Kehormatan Kami</span>
                </h2>
                <p class="mt-6 max-w-2xl text-xl text-[#e8f5e9] mx-auto">
                    Mari bersama-sama memberikan yang terbaik untuk hewan peliharaan tercinta Anda
                </p>
                <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="/services" class="px-8 py-4 border border-transparent text-base font-medium rounded-xl shadow-sm text-[#4EA757] bg-white hover:bg-[#f1f8f1] md:py-4 md:text-lg md:px-10 transition-all duration-300 transform hover:-translate-y-1">
                        Lihat Layanan Kami
                    </a>
                    <a href="/contact" class="px-8 py-4 border border-white text-base font-medium rounded-xl shadow-sm text-white bg-transparent hover:bg-white hover:bg-opacity-10 md:py-4 md:text-lg md:px-10 transition-all duration-300 transform hover:-translate-y-1">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
