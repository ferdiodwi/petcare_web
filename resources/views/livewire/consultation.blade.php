<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Konsultasi AI untuk Hewan Peliharaan
            </h1>
            <p class="mt-3 text-xl text-gray-500">
                Dapatkan saran instan dari asisten dokter hewan AI kami
            </p>
        </div>

        {{-- <!-- Form Informasi Hewan -->
        <div class="bg-white shadow rounded-lg p-6 mb-8" x-data="{ showForm: {{ empty($messages) ? 'true' : 'false' }} }">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-medium text-gray-900">Informasi Hewan Peliharaan</h2>
                <button
                    @click="showForm = !showForm"
                    class="text-[#4EA757] hover:text-[#3e8a4a] text-sm font-medium"
                    x-text="showForm ? 'Sembunyikan Form' : 'Edit Informasi'">
                </button>
            </div>

            <div x-show="showForm" x-transition>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="petType" class="block text-sm font-medium text-gray-700">Jenis Hewan</label>
                        <select
                            wire:model="petType"
                            id="petType"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#4EA757] focus:border-[#4EA757] sm:text-sm rounded-md"
                        >
                            <option value="dog">Anjing</option>
                            <option value="cat">Kucing</option>
                            <option value="bird">Burung</option>
                            <option value="rabbit">Kelinci</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label for="petAge" class="block text-sm font-medium text-gray-700">Usia Hewan</label>
                        <input
                            wire:model="petAge"
                            type="text"
                            id="petAge"
                            class="mt-1 focus:ring-[#4EA757] focus:border-[#4EA757] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            placeholder="Contoh: 2 tahun"
                        >
                    </div>
                </div>

                <div class="mt-4">
                    <label for="petSymptoms" class="block text-sm font-medium text-gray-700">Gejala/Kekhawatiran</label>
                    <textarea
                        wire:model="petSymptoms"
                        id="petSymptoms"
                        rows="3"
                        class="mt-1 focus:ring-[#4EA757] focus:border-[#4EA757] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        placeholder="Jelaskan gejala hewan peliharaan Anda atau kekhawatiran Anda"
                    ></textarea>
                </div>

                <div class="mt-6">
                    <button
                        wire:click="startNewConsultation"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#4EA757] hover:bg-[#3e8a4a] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4EA757]"
                    >
                        Mulai Konsultasi Baru
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Kontainer Chat -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Pesan Chat -->
            <div class="h-96 p-4 overflow-y-auto bg-gray-50">
                <div class="space-y-4">
                    @if(empty($messages))
                        <div class="text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pesan</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulailah dengan menjelaskan masalah hewan peliharaan Anda di atas.</p>
                        </div>
                    @else
                        @foreach($messages as $message)
                            <div class="flex {{ $message['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                                <div class="{{ $message['role'] === 'user' ? 'bg-[#4EA757] text-white' : 'bg-gray-200 text-gray-800' }} rounded-lg py-2 px-4 max-w-xs sm:max-w-md md:max-w-lg lg:max-w-xl">
                                    @if($message['role'] === 'assistant')
                                        <div class="prose prose-sm">
                                            {!! Str::of($message['content'])->markdown() !!}
                                        </div>
                                    @else
                                        <p class="text-sm whitespace-pre-wrap">{{ $message['content'] }}</p>
                                    @endif
                                    <p class="text-xs mt-1 {{ $message['role'] === 'user' ? 'text-[#c1e8c6]' : 'text-gray-500' }}">{{ $message['timestamp'] }}</p>
                                </div>
                            </div>
                        @endforeach

                        @if($isTyping)
                            <div class="flex justify-start">
                                <div class="bg-gray-200 text-gray-800 rounded-lg py-2 px-4 max-w-xs">
                                    <div class="flex space-x-1">
                                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                                        <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Input Pesan -->
            <div class="border-t border-gray-200 px-4 py-3 bg-white">
                <div class="flex space-x-2">
                    <input
                        wire:model="newMessage"
                        wire:keydown.enter="sendMessage"
                        type="text"
                        placeholder="Ketik pesan Anda di sini..."
                        class="flex-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4EA757] focus:ring-[#4EA757] sm:text-sm"
                    >
                    <button
                        wire:click="sendMessage"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#4EA757] hover:bg-[#3e8a4a] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4EA757]"
                    >
                        <span wire:loading.remove>Kirim</span>
                        <span wire:loading>
                            <svg class="animate-spin -ml-1 mr-1 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    Catatan: Ini adalah asisten AI dan bukan pengganti saran dokter hewan profesional.
                </p>
            </div>
        </div>

        <!-- Peringatan -->
        <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Peringatan Penting</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>
                            Informasi yang diberikan oleh asisten AI ini hanya untuk tujuan informasi umum dan tidak boleh dianggap sebagai saran dokter hewan profesional. Untuk situasi serius atau darurat, segera hubungi dokter hewan berlisensi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .prose strong {
        font-weight: 600;
        color: inherit;
    }
    .prose em {
        font-style: italic;
    }
    .prose ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .prose ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .prose p {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }
</style>
@endpush
