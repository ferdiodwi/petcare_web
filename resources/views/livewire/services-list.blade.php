<div class="min-h-screen bg-gray-50">
    <!-- Header dengan Pencarian -->
    <div class="relative bg-[#4EA757] overflow-hidden">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                    <span class="block">Layanan Kami</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-[#e8f5e9] sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Temukan layanan terbaik untuk kebutuhan Anda
                </p>
            </div>
        </div>
        <!-- Filter -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10">
            <div class="bg-white rounded-lg shadow-md border p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Layanan</label>
                        <div class="relative">
                            <input type="text"
                                   wire:model.live.debounce.500ms="search"
                                   placeholder="Masukkan nama layanan..."
                                   class="w-full px-4 py-3 rounded-md border-0 text-base text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#4EA757]">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select wire:model.live="category"
                                class="w-full px-4 py-3 rounded-md border-0 text-base text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#4EA757]">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                        <select wire:model.live="sortBy"
                                class="w-full px-4 py-3 rounded-md border-0 text-base text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#4EA757]">
                            <option value="name">Nama (A-Z)</option>
                            <option value="name_desc">Nama (Z-A)</option>
                            <option value="price">Harga (Murah-Mahal)</option>
                            <option value="price_desc">Harga (Mahal-Murah)</option>
                            <option value="duration">Durasi (Pendek-Panjang)</option>
                            <option value="duration_desc">Durasi (Panjang-Pendek)</option>
                            <option value="created_at">Terbaru</option>
                            <option value="created_at_desc">Terlama</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!-- Loading -->
        <div wire:loading.flex class="justify-center items-center py-12">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-[#4EA757]"></div>
            <span class="ml-3 text-gray-600 text-lg">Memuat layanan...</span>
        </div>
    </div><br><br>

    <!-- Daftar Layanan -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        @if($search || $category)
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Hasil pencarian
                    @if($search) untuk "<span class="font-semibold">{{ $search }}</span>"@endif
                    @if($category) dalam kategori "<span class="font-semibold">{{ $category }}</span>"@endif
                </h2>
                @if($services->isEmpty())
                    <p class="mt-2 text-gray-500">Tidak ditemukan layanan yang sesuai dengan kriteria Anda.</p>
                @endif
            </div>
        @endif

        <div wire:loading.remove class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse($services as $service)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="h-48 bg-gray-100 overflow-hidden">
                        @if($service->image)
                            <img src="{{ Storage::url($service->image) }}"
                                 alt="{{ $service->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-[#e8f5e9]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-[#4EA757]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        @if($service->category)
                            <span class="inline-block px-3 py-1 text-xs font-semibold text-[#4EA757] bg-[#e8f5e9] rounded-full mb-3">
                                {{ $service->category }}
                            </span>
                        @endif

                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $service->name }}</h3>

                        <p class="text-gray-600 mb-4 line-clamp-2">
                            {{ $service->description }}
                        </p>

                        <div class="text-gray-600 space-y-2 mb-6">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4EA757] mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium text-gray-900">{{ $service->formatted_price }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4EA757] mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $service->formatted_duration }}</span>
                            </div>
                        </div>

                        {{-- <button class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#4EA757] hover:bg-[#3d8a47] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4EA757]">
                            Hubungi Kami
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button> --}}
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada layanan ditemukan</h3>
                    <p class="mt-1 text-gray-500">Coba gunakan kata kunci atau kategori yang berbeda.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($services->hasPages())
            <div class="mt-10">
                {{ $services->links() }}
            </div>
        @endif
    </div>

    <!-- CTA Section -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Tertarik dengan layanan kami?
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Unduh aplikasi di bawah ini
                </p>
            </div>
            <div>
                <center>
                <a href="" target="" rel="noopener noreferrer">
                    <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png"
                    alt="Get it on Google Play"
                    width="200"
                    height="auto"
                    style="image-rendering: auto;">
                </a>
                </center>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
