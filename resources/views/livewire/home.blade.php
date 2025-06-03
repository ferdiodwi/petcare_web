<div class="min-h-screen bg-gray-50 font-sans">
    <!-- Bagian Hero - Diperbaiki dengan padding lebih seimbang dan animasi halus -->
    <div class="relative bg-[#4EA757] overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-[#4EA757] sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <div class="pt-16 sm:pt-24 lg:pt-20 lg:pb-14 lg:overflow-hidden">
                    <div class="mt-10 mx-auto max-w-7xl px-6 sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl animate-fade-in-down">
                                <span class="block">Perawatan Profesional</span>
                                <span class="block text-[#e8f5e9] mt-2">Untuk Hewan Peliharaan Tercinta</span>
                            </h1>
                            <p class="mt-5 text-lg text-[#e8f5e9] sm:text-xl md:mt-6 lg:mx-0 max-w-xl">
                                Kami menyediakan layanan terbaik untuk hewan peliharaan Anda dengan penuh kasih sayang dan profesionalisme.
                            </p>
                            <div class="mt-8 sm:flex sm:justify-center lg:justify-start space-x-4">
                                <div class="rounded-md shadow hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                                    <a href="{{ url('/blog') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-[#4EA757] bg-white hover:bg-[#f1f8f1] md:py-4 md:text-lg md:px-10">
                                        Baca Blog Kami
                                    </a>
                                </div>
                                <div class="mt-3 sm:mt-0 rounded-md shadow hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                                    <a href="{{ url('/services') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#3e8a4a] hover:bg-[#357a3e] md:py-4 md:text-lg md:px-10">
                                        Layanan Kami
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full transition-opacity duration-500 hover:opacity-90" src="images/anjing.jpeg" alt="Hewan peliharaan yang bahagia" loading="lazy">
        </div>
    </div>

    <!-- Layanan Unggulan - Diperbaiki dengan card yang lebih menarik -->
    <div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Layanan Kami
            </h2>
            <p class="mt-4 max-w-2xl text-xl text-gray-600 mx-auto">
                Perawatan komprehensif untuk semua kebutuhan hewan peliharaan Anda
            </p>
        </div>

        <div class="mt-16">
            <div class="grid gap-8 grid-cols-1 md:grid-cols-2 justify-center place-items-center">
                <!-- Layanan 1 -->
                <div class="bg-white rounded-xl p-8 hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-[#4EA757] w-full max-w-md">
                    <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-[#4EA757] text-white shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">Grooming</h3>
                    <p class="mt-4 text-base text-gray-600">
                        Layanan grooming lengkap dengan produk alami untuk menjaga hewan peliharaan Anda bersih dan sehat.
                    </p>
                    <a href="/services" class="mt-6 inline-flex items-center text-[#4EA757] font-medium group">
                        Pelajari lebih lanjut
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Layanan 2 -->
                <div class="bg-white rounded-xl p-8 hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-[#4EA757] w-full max-w-md">
                    <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-[#4EA757] text-white shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">Penitipan</h3>
                    <p class="mt-4 text-base text-gray-600">
                        Fasilitas penitipan premium dengan pengawasan 24 jam dan area bermain yang luas.
                    </p>
                    <a href="/services" class="mt-6 inline-flex items-center text-[#4EA757] font-medium group">
                        Pelajari lebih lanjut
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Artikel Blog Terbaru - Diperbaiki dengan card yang lebih konsisten -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Artikel Terbaru
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 mx-auto">
                    Tips dan saran untuk merawat hewan peliharaan Anda
                </p>
            </div>

            <div class="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($posts->take(3) as $post)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
                    <a href="{{ url('/blog/' . $post->slug) }}" class="block">
                        @if($post->image)
                            <div class="h-56 overflow-hidden">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                     loading="lazy">
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $post->created_at->format('j F Y') }}
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-3 group-hover:text-[#4EA757] transition-colors">{{ $post->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($post->content), 120) }}</p>
                            <div class="inline-flex items-center text-[#4EA757] font-medium group-hover:text-[#3e8a4a] transition-colors">
                                Baca selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="{{ url('/blog') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-[#4EA757] hover:bg-[#3e8a4a] transition-colors duration-300 transform hover:-translate-y-1">
                    Lihat Semua Artikel
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-1.293-1.293A1 1 0 0113 8.586V15a1 1 0 11-2 0V8.586a1 1 0 01.293-.707L12.293 5.293z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>


    <!-- CTA Section - Diperbaiki dengan desain yang lebih menarik -->
    <div class="bg-gradient-to-r from-[#4EA757] to-[#3e8a4a] py-16">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="lg:text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    Unduh Aplikasi Kami
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-[#e8f5e9] lg:mx-auto">
                    Dapatkan akses mudah ke semua layanan dan informasi perawatan hewan
                </p>
            </div>
            <div class="mt-10 flex flex-col sm:flex-row justify-center items-center gap-6">
                <a href="#" class="transition-transform hover:scale-105">
                    <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png"
                    alt="Get it on Google Play"
                    width="180"
                    height="auto"
                    class="rounded-lg shadow-lg">
                </a>
                <a href="#" class="transition-transform hover:scale-105">
                    <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                    alt="Download on the App Store"
                    width="160"
                    height="auto"
                    class="rounded-lg shadow-lg">
                </a>
            </div>
        </div>
    </div>


    <!-- Testimoni - Bagian baru untuk meningkatkan kepercayaan -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Apa Kata Klien Kami
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 mx-auto">
                    Mereka telah mempercayakan perawatan hewan peliharaan kepada kami
                </p>
            </div>

            <div class="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Testimoni 1 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Testimoni 1" loading="lazy">
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Sarah Wijaya</h4>
                            <p class="text-[#4EA757]">Pemilik Kucing Persia</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600">
                        "Layanan groomingnya sangat profesional. Kucing saya selalu pulang dalam keadaan bersih dan bahagia. Stafnya sangat ramah dan memahami kebutuhan hewan."
                    </p>
                </div>

                <!-- Testimoni 2 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Testimoni 2" loading="lazy">
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Budi Santoso</h4>
                            <p class="text-[#4EA757]">Pemilik Anjing Golden Retriever</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600">
                        "Dokter hewannya sangat kompeten dan sabar. Penjelasannya detail tentang kondisi anjing saya. Sekarang saya selalu membawa anjing saya untuk checkup rutin di sini."
                    </p>
                </div>

                <!-- Testimoni 3 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Testimoni 3" loading="lazy">
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Dewi Lestari</h4>
                            <p class="text-[#4EA757]">Pemilik Kelinci</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600">
                        "Fasilitas penitipannya sangat nyaman dan bersih. Saya bisa pergi liburan dengan tenang karena tahu kelinci saya dirawat dengan baik. Harganya juga sangat reasonable."
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Ajakan Bertindak - Diperbaiki dengan desain yang lebih modern -->
    {{-- <div class="relative bg-[#4EA757] overflow-hidden">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-10" src="images/paw-pattern.png" alt="Pattern" loading="lazy">
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-6 sm:py-32 sm:px-8 lg:px-10">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">Siap merawat hewan peliharaan Anda?</span>
                    <span class="block mt-2 text-[#e8f5e9]">Kami siap membantu!</span>
                </h2>
                <p class="mt-6 max-w-2xl text-xl text-[#e8f5e9] mx-auto">
                    Tim profesional kami siap memberikan perawatan terbaik untuk anggota keluarga berbulu Anda.
                </p>
                <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#" class="px-8 py-4 border border-transparent text-base font-medium rounded-xl shadow-sm text-[#4EA757] bg-white hover:bg-[#f1f8f1] md:py-4 md:text-lg md:px-10 transition-all duration-300 transform hover:-translate-y-1">
                        Hubungi Kami
                    </a>
                    <a href="#" class="px-8 py-4 border border-white text-base font-medium rounded-xl shadow-sm text-white bg-transparent hover:bg-white hover:bg-opacity-10 md:py-4 md:text-lg md:px-10 transition-all duration-300 transform hover:-translate-y-1">
                        Lihat Jadwal
                    </a>
                </div>
            </div>
        </div> --}}
    </div>
</div>
