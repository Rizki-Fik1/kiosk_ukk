<x-app-layout>
    @section('page-title', 'Detail Produk')

    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">Detail Produk</h1>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('products.edit', $product) }}" 
                       class="inline-flex items-center space-x-2 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit Produk</span>
                    </a>
                    <button onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')" 
                            class="inline-flex items-center space-x-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span>Hapus Produk</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Product Card --}}
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                {{-- Image --}}
                <div class="md:col-span-1">
                    @if($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-lg shadow-md">
                    @else
                        <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Details --}}
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h2>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>

                    @if($product->description)
                        <div>
                            <p class="text-gray-600">{{ $product->description }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                        <div>
                            <p class="text-sm text-gray-500">Harga</p>
                            <p class="text-xl font-bold text-[#387d7a]">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Stok</p>
                            <p class="text-xl font-bold {{ $product->stock <= ($product->min_stock ?? 10) ? 'text-red-600' : 'text-gray-800' }}">
                                {{ $product->stock }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Min Stok</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $product->min_stock ?? 10 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nilai Stok</p>
                            <p class="text-lg font-semibold text-gray-800">Rp {{ number_format($product->stock * $product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="pt-4 border-t">
                        <p class="text-xs text-gray-500">Dibuat: {{ $product->created_at->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-gray-500">Diupdate: {{ $product->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal" 
         class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4 animate-fade-in-up">
            <div class="text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Produk?</h3>
                <p class="text-gray-600 mb-1">Anda yakin ingin menghapus produk:</p>
                <p class="text-gray-800 font-semibold mb-4" id="deleteProductName"></p>
                <p class="text-sm text-gray-500 mb-6">Tindakan ini tidak dapat dibatalkan!</p>
                
                <form id="deleteForm" method="POST" class="flex items-center space-x-3">
                    @csrf
                    @method('DELETE')
                    <button type="button" 
                            onclick="closeDeleteModal()" 
                            class="flex-1 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Delete Confirmation
        function confirmDelete(productId, productName) {
            document.getElementById('deleteProductName').textContent = productName;
            document.getElementById('deleteForm').action = `/admin/products/${productId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
</x-app-layout>
