<x-app-layout>
    @section('page-title', 'Buat Pembelian')

    <div class="max-w-7xl mx-auto">
        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg animate-fade-in-up">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-red-800 font-semibold mb-2">Oops! Ada beberapa kesalahan:</p>
                        <ul class="list-disc list-inside text-red-700 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center space-x-3 mb-2">
                <a href="{{ route('purchases.index') }}" class="text-gray-600 hover:text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Buat Pembelian Baru</h1>
            </div>
            <p class="text-gray-600 text-sm">Isi form di bawah untuk mencatat pembelian dari supplier</p>
        </div>

        <form method="POST" action="{{ route('purchases.store') }}" id="purchaseForm">
            @csrf

            {{-- Purchase Info Card --}}
            <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pembelian</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Supplier <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="supplier_name" 
                               value="{{ old('supplier_name') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#387d7a] focus:border-transparent"
                               placeholder="Contoh: PT Sumber Makmur">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Pembelian <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="purchase_date" 
                               value="{{ old('purchase_date', date('Y-m-d')) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#387d7a] focus:border-transparent">
                    </div>
                </div>
            </div>

            {{-- Items Card --}}
            <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Item Pembelian</h3>
                    <button type="button" 
                            onclick="addItem()" 
                            class="px-4 py-2 bg-gradient-to-r from-[#387d7a] to-[#32936f] text-white font-semibold rounded-lg hover:shadow-lg transition">
                        + Tambah Item
                    </button>
                </div>

                <div id="itemsContainer" class="space-y-4">
                    {{-- Items will be added here dynamically --}}
                </div>

                {{-- Total Display --}}
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-700">Total Pembelian:</span>
                        <span id="totalAmount" class="text-2xl font-bold text-[#26a96c]">Rp 0</span>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center space-x-3">
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-[#387d7a] to-[#32936f] text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition">
                    <span class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Simpan Pembelian</span>
                    </span>
                </button>
                <a href="{{ route('purchases.index') }}" 
                   class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        let itemIndex = 0;
        const products = @json($products);

        // Add first item on page load
        document.addEventListener('DOMContentLoaded', function() {
            addItem();
        });

        function addItem() {
            const container = document.getElementById('itemsContainer');
            const itemDiv = document.createElement('div');
            itemDiv.className = 'bg-gray-50 rounded-lg p-4 border border-gray-200';
            itemDiv.id = `item-${itemIndex}`;
            
            itemDiv.innerHTML = `
                <div class="flex items-start space-x-4">
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Produk</label>
                            <select name="items[${itemIndex}][product_id]" 
                                    onchange="updateSubtotal(${itemIndex})"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#387d7a] focus:border-transparent">
                                <option value="">Pilih Produk</option>
                                ${products.map(p => `<option value="${p.id}">${p.name}</option>`).join('')}
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                            <input type="number" 
                                   name="items[${itemIndex}][quantity]" 
                                   min="1" 
                                   value="1"
                                   onchange="updateSubtotal(${itemIndex})"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#387d7a] focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga Modal (Rp)</label>
                            <input type="number" 
                                   name="items[${itemIndex}][cost_price]" 
                                   min="0" 
                                   step="100"
                                   onchange="updateSubtotal(${itemIndex})"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#387d7a] focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subtotal</label>
                            <input type="text" 
                                   id="subtotal-${itemIndex}"
                                   readonly
                                   value="Rp 0"
                                   class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-100 text-gray-700 font-semibold">
                        </div>
                    </div>
                    <button type="button" 
                            onclick="removeItem(${itemIndex})" 
                            class="mt-7 p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            container.appendChild(itemDiv);
            itemIndex++;
        }

        function removeItem(index) {
            const itemDiv = document.getElementById(`item-${index}`);
            if (itemDiv) {
                itemDiv.remove();
                calculateTotal();
            }
        }

        function updateSubtotal(index) {
            const itemDiv = document.getElementById(`item-${index}`);
            if (!itemDiv) return;

            const quantity = itemDiv.querySelector(`input[name="items[${index}][quantity]"]`).value || 0;
            const costPrice = itemDiv.querySelector(`input[name="items[${index}][cost_price]"]`).value || 0;
            const subtotal = quantity * costPrice;

            itemDiv.querySelector(`#subtotal-${index}`).value = `Rp ${subtotal.toLocaleString('id-ID')}`;
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            const container = document.getElementById('itemsContainer');
            const items = container.querySelectorAll('[id^="item-"]');

            items.forEach(item => {
                const index = item.id.split('-')[1];
                const quantity = item.querySelector(`input[name="items[${index}][quantity]"]`)?.value || 0;
                const costPrice = item.querySelector(`input[name="items[${index}][cost_price]"]`)?.value || 0;
                total += quantity * costPrice;
            });

            document.getElementById('totalAmount').textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }
    </script>
</x-app-layout>
