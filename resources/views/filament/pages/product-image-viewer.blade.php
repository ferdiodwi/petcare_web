{{-- resources/views/filament/pages/product-image-viewer.blade.php --}}
<div class="w-full">
    @if($imagePath && file_exists(storage_path('app/public/' . $imagePath)))
        <div class="flex justify-center items-center bg-gray-50 dark:bg-gray-900 rounded-lg overflow-hidden">
            <img
                src="{{ $imageUrl }}"
                alt="{{ $productName }}"
                class="max-w-full max-h-96 object-contain rounded-lg shadow-lg"
                style="max-height: 400px;"
                onerror="this.onerror=null; this.src='{{ asset('images/placeholder.png') }}'; this.alt='Image not found';"
            >
        </div>

        {{-- Debug info - remove in production --}}
        <div class="mt-4 text-xs text-gray-500 dark:text-gray-400">
            <p><strong>Image Path:</strong> {{ $imagePath }}</p>
            <p><strong>Full URL:</strong> {{ $imageUrl }}</p>
            <p><strong>File exists:</strong> {{ file_exists(storage_path('app/public/' . $imagePath)) ? 'Yes' : 'No' }}</p>
            <p><strong>Storage Path:</strong> {{ storage_path('app/public/' . $imagePath) }}</p>
        </div>
    @else
        <div class="flex flex-col justify-center items-center bg-gray-100 dark:bg-gray-800 rounded-lg py-16">
            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-gray-500 dark:text-gray-400 text-center">
                No image available for this product
            </p>

            {{-- Debug info for missing image --}}
            <div class="mt-4 text-xs text-gray-400">
                <p><strong>Expected Path:</strong> {{ $imagePath ?? 'None' }}</p>
                <p><strong>Storage Path:</strong> {{ $imagePath ? storage_path('app/public/' . $imagePath) : 'N/A' }}</p>
                <p><strong>File exists:</strong> {{ $imagePath && file_exists(storage_path('app/public/' . $imagePath)) ? 'Yes' : 'No' }}</p>
            </div>
        </div>
    @endif
</div>
