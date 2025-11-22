<x-app-layout>
    @section('page-title', 'Stok & Pembelian')

    <div class="max-w-7xl mx-auto">
        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg flex items-center space-x-3 animate-fade-in-up">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg flex items-center space-x-3 animate-fade-in-up">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Header with Add Button --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Stok & Pembelian</h1>
                <p class="text-gray-600 text-sm mt-1">Kelola pembelian dari supplier dan stok produk</p>
            </div>
            <a href="{{ route('purchases.create') }}" 
               class="px-6 py-3 bg-gradient-to-r from-[#387d7a] to-[#32936f] text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Buat Pembelian</span>
            </a>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            {{-- Total Purchases --}}
            <div class="bg-white rounded-2xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Pembelian</p>
                        <h3 class="text-3xl font-bold text-[#395e66]">{{ number_format($stats['total_purchases']) }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Transaksi pembelian</p>
                    </div>
                    <div class="bg-gradient-to-br from-[#395e66] to-[#387d7a] p-4 rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Total Amount --}}
            <div class="bg-white rounded-2xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Nilai</p>
                        <h3 class="text-2xl font-bold text-[#26a96c]">Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Nilai pembelian</p>
                    </div>
                    <div class="bg-gradient-to-br from-[#26a96c] to-[#2bc016] p-4 rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Total Items --}}
            <div class="bg-white rounded-2xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Item</p>
                        <h3 class="text-3xl font-bold text-[#387d7a]">{{ number_format($stats['total_items']) }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Item dibeli</p>
                    </div>
                    <div class="bg-gradient-to-br from-[#387d7a] to-[#32936f] p-4 rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search & Filter Card --}}
        <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Cari & Filter</h3>
            
            <form method="GET" action="{{ route('purchases.index') }}" class="space-y-4">
                {{-- Search & Filter Row --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    {{-- Search --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Supplier</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Nama supplier..."
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#387d7a] focus:border-transparent">
                    </div>

                    {{-- Sort By --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                        <select name="sort_by" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#387d7a] focus:border-transparent">
                            <option value="purchase_date" {{ request('sort_by') == 'purchase_date' ? 'selected' : '' }}>Tanggal Pembelian</option>
                            <option value="supplier_name" {{ request('sort_by') == 'supplier_name' ? 'selected' : '' }}>Nama Supplier</option>
                            <option value="total_amount" {{ request('sort_by') == 'total_amount' ? 'selected' : '' }}>Total Nilai</option>
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                        </select>
                    </div>

                    {{-- Date From --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                        <input type="date" 
                               name="date_from" 
                               value="{{ request('date_from') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#387d7a] focus:border-transparent">
                    </div>

                    {{-- Date To --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                        <input type="date" 
                               name="date_to" 
                               value="{{ request('date_to') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#387d7a] focus:border-transparent">
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-row sm:flex-row items-stretch sm:items-center gap-3">
                    <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-[#387d7a] to-[#32936f] hover:from-[#395e66] hover:to-[#387d7a] text-white font-semibold rounded-lg transition shadow-md hover:shadow-lg flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        <span>Terapkan Filter</span>
                    </button>
                    
                    <a href="{{ route('purchases.index') }}" 
                       class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Reset Filter</span>
                    </a>
                    
                    {{-- Sort Order Toggle --}}
                    <div class="flex items-center space-x-2 px-4 py-2 bg-gray-50 rounded-lg border border-gray-200">
                        <span class="text-sm font-medium text-gray-700">Urutan:</span>
                        <input type="hidden" name="sort_order" id="sortOrderInput" value="{{ request('sort_order', 'desc') }}">
                        <button type="button" 
                                onclick="toggleSortOrder(event)" 
                                class="px-4 py-1.5 bg-white hover:bg-gray-100 border border-gray-300 text-gray-700 font-medium rounded-lg transition flex items-center space-x-2">
                            @if(request('sort_order') == 'asc')
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                                <span class="text-sm">Terkecil ke Terbesar</span>
                            @else
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                                <span class="text-sm">Terbesar ke Terkecil</span>
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Purchases Table --}}
        <div class="bg-white rounded-2xl shadow-md p-6">
            {{-- Results Info --}}
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">
                    {{ $purchases->total() }} Pembelian Ditemukan
                </h3>
                <p class="text-sm text-gray-600">
                    Menampilkan {{ $purchases->firstItem() ?? 0 }} - {{ $purchases->lastItem() ?? 0 }}
                </p>
            </div>

            @if($purchases->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-[#395e66] to-[#32936f]">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Supplier</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider">Total Item</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-white uppercase tracking-wider">Total Nilai</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($purchases as $purchase)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $purchase->id }}
                                    </td>
                                    <td class="px-4 py-4 text-sm">
                                        <p class="font-semibold text-gray-900">{{ $purchase->supplier_name }}</p>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $purchase->purchase_date->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 text-sm font-bold rounded-full bg-blue-100 text-blue-700">
                                            {{ $purchase->purchaseItems->sum('quantity') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-right font-semibold text-[#26a96c]">
                                        Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('purchases.show', $purchase) }}" 
                                               class="inline-flex items-center space-x-1 px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                <span>Lihat</span>
                                            </a>
                                            <a href="{{ route('purchases.edit', $purchase) }}" 
                                               class="inline-flex items-center space-x-1 px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                <span>Edit</span>
                                            </a>
                                            <button onclick="confirmDelete({{ $purchase->id }}, '{{ $purchase->supplier_name }}')" 
                                                    class="inline-flex items-center space-x-1 px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $purchases->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-12">
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak Ada Pembelian</h3>
                    <p class="text-gray-500 mb-6">Belum ada pembelian yang tercatat atau tidak ada yang sesuai dengan filter Anda</p>
                    <a href="{{ route('purchases.create') }}" 
                       class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-[#387d7a] to-[#32936f] text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Buat Pembelian Pertama</span>
                    </a>
                </div>
            @endif
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
                <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Pembelian?</h3>
                <p class="text-gray-600 mb-1">Anda yakin ingin menghapus pembelian dari:</p>
                <p class="text-gray-800 font-semibold mb-4" id="deleteSupplierName"></p>
                <p class="text-sm text-gray-500 mb-6">Stok produk akan dikembalikan. Tindakan ini tidak dapat dibatalkan!</p>
                
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
        function confirmDelete(purchaseId, supplierName) {
            document.getElementById('deleteSupplierName').textContent = supplierName;
            document.getElementById('deleteForm').action = `/admin/purchases/${purchaseId}`;
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

        // Toggle sort order
        function toggleSortOrder(event) {
            event.preventDefault();
            const input = document.getElementById('sortOrderInput');
            input.value = input.value === 'asc' ? 'desc' : 'asc';
            event.target.closest('form').submit();
        }
    </script>
</x-app-layout>
