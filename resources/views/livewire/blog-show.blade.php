<div class="min-h-screen bg-gray-50">
    <!-- Header Artikel -->
    <div class="relative bg-indigo-600 overflow-hidden">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl tracking-tight font-extrabold text-white sm:text-4xl md:text-5xl">
                    {{ $post->title }}
                </h1>
                <div class="mt-4 flex items-center justify-center space-x-4 text-indigo-100">
                    <span>{{ $post->created_at->translatedFormat('j F Y') }}</span>
                    <span>•</span>
                    <span>{{ $post->reading_time }} menit baca</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Isi Artikel -->
    <div class="py-12 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($post->image)
            <div class="mb-8 rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover">
            </div>
            @endif

            <article class="prose prose-indigo max-w-none">
                <!-- Konten dari Rich Text Editor -->
                <div class="content">
                    {!! $post->content !!}
                </div>
            </article>

            <div class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($post->author->name ?? 'Admin') }}&background=indigo&color=white" alt="">
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">
                            {{ $post->author->name ?? 'Admin' }}
                        </p>
                        <div class="flex space-x-1 text-sm text-gray-500">
                            <span>Penulis</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Style untuk menyesuaikan output Rich Text Editor */
        .content h1 {
            font-size: 2rem;
            font-weight: 800;
            margin: 1.5rem 0;
        }

        .content h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 1.25rem 0;
        }

        .content h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 1rem 0;
        }

        .content p {
            margin: 1rem 0;
            line-height: 1.6;
        }

        .content strong {
            font-weight: 600;
        }

        .content ul, .content ol {
            margin: 1rem 0;
            padding-left: 1.5rem;
        }

        .content ul {
            list-style-type: disc;
        }

        .content ol {
            list-style-type: decimal;
        }

        .content a {
            color: #4f46e5;
            text-decoration: underline;
        }

        .content blockquote {
            border-left: 4px solid #e5e7eb;
            padding-left: 1rem;
            margin: 1rem 0;
            color: #6b7280;
        }
    </style>

    <!-- Artikel Terkait -->
    @if($relatedPosts && $relatedPosts->count() > 0)
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">
                Artikel Lain yang Mungkin Anda Suka
            </h2>
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($relatedPosts as $related)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    @if($related->image)
                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <div class="text-sm text-gray-500 mb-2">{{ $related->created_at->translatedFormat('j F Y') }}</div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $related->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($related->excerpt ?? $related->content), 100) }}</p>
                        <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                            Baca selengkapnya
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Langganan Newsletter -->
    <div class="bg-white py-12 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Menyukai artikel ini?
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Berlangganan newsletter kami untuk konten menarik lainnya.
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
            </div>
        </div>
    </div>
</div>
