<x-app-layout>
    {{-- Judul halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Buat Pembelian Baru
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Alert flash message --}}
        @if($errors->any())
            <div class="mb-4 p-4 text-red-800 bg-red-100 border border-red-300 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('purchases.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded">
                ← Kembali ke Daftar Purchase
            </a>
        </div>

        {{-- Form Purchase --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-6 text-gray-700 dark:text-gray-300">Form Pembelian</h3>

            <form method="POST" action="{{ route('purchases.store') }}" id="purchaseForm">
                @csrf

                {{-- Header Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Supplier *
                        </label>
                        <input type="text" name="supplier_name" value="{{ old('supplier_name') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Contoh: Toko Grosir Jaya" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Pembelian *
                        </label>
                        <input type="date" name="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>
                </div>

                {{-- Items Section --}}
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300">Items Pembelian</h4>
                        <button type="button" onclick="addItem()" 
                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                            + Tambah Item
                        </button>
                    </div>

                    <div id="items-container">
                        {{-- Initial item row --}}
                        <div class="item-row border border-gray-200 rounded-lg p-4 mb-3" data-index="0">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
                                    <select name="items[0][product_id]" class="product-select w-full border border-gray-300 rounded px-3 py-2" required>
                                        <option value="">Pilih Produk</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-name="{{ $product->name }}">
                                                {{ $product->name }} (Stock: {{ $product->stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                    <input type="number" name="items[0][quantity]" class="quantity-input w-full border border-gray-300 rounded px-3 py-2" 
                                           placeholder="0" min="1" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Modal</label>
                                    <input type="number" name="items[0][cost_price]" class="cost-price-input w-full border border-gray-300 rounded px-3 py-2" 
                                           placeholder="0" min="0" step="0.01" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Subtotal</label>
                                    <div class="subtotal-display bg-gray-100 border border-gray-300 rounded px-3 py-2 text-right font-medium">
                                        Rp 0
                                    </div>
                                </div>
                                <div>
                                    <button type="button" onclick="removeItem(0)" 
                                            class="remove-btn bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm w-full">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Section --}}
                <div class="border-t pt-4 mb-6">
                    <div class="flex justify-end">
                        <div class="text-right">
                            <div class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                Total Pembelian: <span id="grand-total" class="text-blue-600">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="flex gap-3">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                        Simpan Pembelian
                    </button>
                    <a href="{{ route('purchases.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        let itemIndex = 1;

        function addItem() {
            const container = document.getElementById('items-container');
            const newItem = `
                <div class="item-row border border-gray-200 rounded-lg p-4 mb-3" data-index="${itemIndex}">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
                            <select name="items[${itemIndex}][product_id]" class="product-select w-full border border-gray-300 rounded px-3 py-2" required>
                                <option value="">Pilih Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-name="{{ $product->name }}">
                                        {{ $product->name }} (Stock: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <input type="number" name="items[${itemIndex}][quantity]" class="quantity-input w-full border border-gray-300 rounded px-3 py-2" 
                                   placeholder="0" min="1" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Modal</label>
                            <input type="number" name="items[${itemIndex}][cost_price]" class="cost-price-input w-full border border-gray-300 rounded px-3 py-2" 
                                   placeholder="0" min="0" step="0.01" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subtotal</label>
                            <div class="subtotal-display bg-gray-100 border border-gray-300 rounded px-3 py-2 text-right font-medium">
                                Rp 0
                            </div>
                        </div>
                        <div>
                            <button type="button" onclick="removeItem(${itemIndex})" 
                                    class="remove-btn bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm w-full">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', newItem);
            itemIndex++;
            attachEventListeners();
        }

        function removeItem(index) {
            const itemRow = document.querySelector(`[data-index="${index}"]`);
            if (itemRow) {
                itemRow.remove();
                calculateGrandTotal();
            }
        }

        function calculateSubtotal(row) {
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const costPrice = parseFloat(row.querySelector('.cost-price-input').value) || 0;
            const subtotal = quantity * costPrice;
            
            row.querySelector('.subtotal-display').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const costPrice = parseFloat(row.querySelector('.cost-price-input').value) || 0;
                grandTotal += quantity * costPrice;
            });
            
            document.getElementById('grand-total').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
        }

        function attachEventListeners() {
            document.querySelectorAll('.quantity-input, .cost-price-input').forEach(input => {
                input.removeEventListener('input', handleInputChange);
                input.addEventListener('input', handleInputChange);
            });
        }

        function handleInputChange(e) {
            const row = e.target.closest('.item-row');
            calculateSubtotal(row);
        }

        // Initialize event listeners
        document.addEventListener('DOMContentLoaded', function() {
            attachEventListeners();
        });

        // Form validation
        document.getElementById('purchaseForm').addEventListener('submit', function(e) {
            const items = document.querySelectorAll('.item-row');
            if (items.length === 0) {
                e.preventDefault();
                alert('Minimal harus ada 1 item pembelian!');
                return false;
            }

            let hasValidItem = false;
            items.forEach(row => {
                const productId = row.querySelector('.product-select').value;
                const quantity = row.querySelector('.quantity-input').value;
                const costPrice = row.querySelector('.cost-price-input').value;
                
                if (productId && quantity && costPrice) {
                    hasValidItem = true;
                }
            });

            if (!hasValidItem) {
                e.preventDefault();
                alert('Minimal harus ada 1 item yang lengkap (produk, quantity, dan harga modal)!');
                return false;
            }
        });
    </script>
</x-app-layout>