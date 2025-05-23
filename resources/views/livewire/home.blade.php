<div class="min-h-screen bg-gray-50">
    <!-- Bagian Hero -->
    <div class="relative bg-indigo-600 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-indigo-600 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <div class="pt-10 sm:pt-16 lg:pt-8 lg:pb-14 lg:overflow-hidden">
                    <div class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                                <span class="block">Perawatan Profesional</span>
                                <span class="block text-indigo-200">Untuk Hewan Peliharaan Tercinta</span>
                            </h1>
                            <p class="mt-3 text-base text-indigo-100 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Kami menyediakan layanan terbaik untuk hewan peliharaan Anda dengan penuh kasih sayang dan profesionalisme.
                            </p>
                            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-md shadow">
                                    <a href="{{ url('/blog') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 md:py-4 md:text-lg md:px-10">
                                        Baca Blog Kami
                                    </a>
                                </div>
                                <div class="mt-3 sm:mt-0 sm:ml-3">
                                    <a href="{{ url('/services') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
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
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1583511655826-05700d52f4d9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Hewan peliharaan yang bahagia">
        </div>
    </div>

    <!-- Layanan Unggulan -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Layanan Kami
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Perawatan komprehensif untuk semua kebutuhan hewan peliharaan Anda
                </p>
            </div>

            <div class="mt-10">
                <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Layanan 1 -->
                    <div class="bg-gray-50 rounded-lg p-6 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Perawatan Veteriner</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Layanan medis profesional untuk perawatan preventif dan pengobatan penyakit.
                        </p>
                    </div>

                    <!-- Layanan 2 -->
                    <div class="bg-gray-50 rounded-lg p-6 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Grooming</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Layanan grooming lengkap untuk menjaga hewan peliharaan Anda bersih, sehat, dan tampil terbaik.
                        </p>
                    </div>

                    <!-- Layanan 3 -->
                    <div class="bg-gray-50 rounded-lg p-6 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Penitipan</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Fasilitas penitipan yang aman dan nyaman ketika Anda harus pergi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Artikel Blog Terbaru -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Artikel Terbaru dari Blog Kami
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Tips dan saran untuk pemilik hewan peliharaan
                </p>
            </div>

            <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($posts->take(3) as $post)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 cursor-pointer">
                <a href="{{ url('/blog/' . $post->slug) }}" class="block">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <div class="text-sm text-gray-500 mb-2">{{ $post->created_at->format('j F Y') }}</div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $post->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                        <div class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                            Baca selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <a href="{{ url('/blog') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                    Lihat Semua Artikel
                </a>
            </div>
        </div>
    </div>

    <!-- Ajakan Bertindak -->
    <div class="bg-indigo-700">
        <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Siap merawat hewan peliharaan Anda?</span>
                <span class="block">Hubungi kami hari ini.</span>
            </h2>
            <p class="mt-4 text-lg leading-6 text-indigo-200">
                Tim profesional kami siap membantu Anda dalam semua kebutuhan perawatan hewan peliharaan.
            </p>
            <a href="#" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 sm:w-auto">
                Hubungi Kami
            </a>
        </div>
    </div>
</div>
