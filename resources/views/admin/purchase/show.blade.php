<x-app-layout>
    @section('page-title', 'Detail Pembelian')

    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('purchases.index') }}" class="text-gray-600 hover:text-gray-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">Detail Pembelian #{{ $purchase->id }}</h1>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('purchases.edit', $purchase) }}" 
                       class="inline-flex items-center space-x-2 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit</span>
                    </a>
                    <button onclick="window.print()" 
                            class="inline-flex items-center space-x-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        <span>Print</span>
                    </button>
                    <button onclick="confirmDelete({{ $purchase->id }}, '{{ $purchase->supplier_name }}')" 
                            class="inline-flex items-center space-x-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span>Hapus</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Purchase Info Card --}}
        <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pembelian</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-[#395e66] to-[#387d7a] rounded-xl p-4 text-white">
                    <p class="text-sm opacity-90 mb-1">Supplier</p>
                    <p class="text-xl font-bold">{{ $purchase->supplier_name }}</p>
                </div>
                <div class="bg-gradient-to-br from-[#387d7a] to-[#32936f] rounded-xl p-4 text-white">
                    <p class="text-sm opacity-90 mb-1">Tanggal Pembelian</p>
                    <p class="text-xl font-bold">{{ $purchase->purchase_date->format('d F Y') }}</p>
                </div>
                <div class="bg-gradient-to-br from-[#32936f] to-[#26a96c] rounded-xl p-4 text-white">
                    <p class="text-sm opacity-90 mb-1">Total Item</p>
                    <p class="text-xl font-bold">{{ $purchase->purchaseItems->sum('quantity') }} pcs</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="border-l-4 border-[#26a96c] bg-green-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Total Nilai Pembelian</p>
                    <p class="text-3xl font-bold text-[#26a96c]">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</p>
                </div>
                <div class="border-l-4 border-gray-400 bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Dibuat Pada</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $purchase->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
            </div>
        </div>

        {{-- Purchase Items Table --}}
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Item Pembelian</h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-[#395e66] to-[#32936f]">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Produk</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider">Quantity</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-white uppercase tracking-wider">Harga Modal</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-white uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($purchase->purchaseItems as $index => $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                    <p class="text-xs text-gray-500">Stok saat ini: {{ $item->product->stock }} pcs</p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1 text-sm font-bold rounded-full bg-blue-100 text-blue-700">
                                        {{ $item->quantity }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-right text-gray-700">
                                    Rp {{ number_format($item->cost_price, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-right font-semibold text-[#387d7a]">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-right text-sm font-semibold text-gray-700">
                                TOTAL:
                            </td>
                            <td class="px-4 py-4 text-right text-lg font-bold text-[#26a96c]">
                                Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
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
    </script>

    {{-- Print Styles --}}
    <style>
        @media print {
            .no-print, button, a {
                display: none !important;
            }
            
            body {
                font-size: 12px;
            }
        }
    </style>
</x-app-layout>
