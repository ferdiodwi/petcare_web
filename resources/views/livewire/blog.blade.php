<div class="min-h-screen bg-gray-50">
    <!-- Header Blog dengan Pencarian -->
    <div class="relative bg-indigo-600 overflow-hidden">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                    <span class="block">Blog PetCare</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-indigo-100 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Tips, saran, dan cerita untuk pecinta hewan peliharaan
                </p>

                <!-- Kolom Pencarian -->
                <div class="mt-8 max-w-md mx-auto">
                    <form method="GET" action="{{ route('blog') }}" class="flex">
                        <label for="search" class="sr-only">Cari artikel</label>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="Cari artikel..."
                            class="w-full px-4 py-3 rounded-l-md border-0 text-base text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                        >
                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-3 border border-transparent text-base font-medium rounded-r-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-2">Cari</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Artikel Blog -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(request('search'))
                <div class="mb-6">
                    <h2 class="text-lg font-medium text-gray-900">
                        Hasil pencarian untuk "{{ request('search') }}"
                    </h2>
                    @if($posts->isEmpty())
                        <p class="mt-2 text-gray-500">Tidak ditemukan artikel yang sesuai dengan pencarian Anda.</p>
                    @endif
                </div>
            @endif

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($posts as $post)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-indigo-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <span>{{ $post->created_at->translatedFormat('j F Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $post->reading_time }} menit baca</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $post->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($post->excerpt ?? $post->content), 120) }}</p>
                        <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                            Baca selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginasi -->
            <div class="mt-10">
                {{ $posts->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>

    <!-- Langganan Newsletter -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Tetap Update
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Berlangganan newsletter kami untuk tips dan informasi terbaru seputar perawatan hewan.
                </p>
            </div>
            <div class="mt-8 max-w-md mx-auto sm:max-w-lg lg:mt-12">
                <form class="sm:flex">
                    <label for="email" class="sr-only">Alamat email</label>
                    <input id="email" type="email" autocomplete="email" required class="w-full px-5 py-3 border border-gray-300 shadow-sm placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs rounded-md" placeholder="Masukkan email Anda">
                    <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3 sm:flex-shrink-0">
                        <button type="submit" class="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Berlangganan
                        </button>
                    </div>
                </form>
                <p class="mt-3 text-sm text-gray-500">
                    Kami menghargai privasi Anda. Baca
                    <a href="#" class="font-medium text-indigo-600 underline">
                        Kebijakan Privasi
                    </a> kami.
                </p>
            </div>
        </div>
    </div>
</div>
