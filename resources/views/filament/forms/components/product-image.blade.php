@php
    $imageUrl = $getState() ? Storage::url($getState()) : null;
@endphp

<div class="flex flex-col items-center justify-center p-4 bg-white rounded-lg shadow">
    @if($imageUrl)
        <div class="mb-4 text-lg font-medium text-gray-900">
            Product Image Preview
        </div>
        <div class="relative w-full max-w-3xl">
            <img
                src="{{ $imageUrl }}"
                alt="Product Image"
                class="object-contain w-full rounded-lg max-h-[70vh] border border-gray-200"
                onerror="this.onerror=null;this.src='{{ asset('images/image-placeholder.png') }}'"
            >
        </div>
    @else
        <div class="p-8 text-center text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="text-lg font-medium">No Image Available</p>
        </div>
    @endif
</div>
