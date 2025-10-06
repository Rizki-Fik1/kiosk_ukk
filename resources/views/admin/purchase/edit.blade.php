<x-app-layout>
    {{-- Judul halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Purchase #{{ $purchase->id }}
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
            <a href="{{ route('purchases.show', $purchase) }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded">
                ← Kembali ke Detail Purchase
            </a>
        </div>

        {{-- Form Edit Purchase --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-6 text-gray-700 dark:text-gray-300">Edit Purchase Information</h3>

            <form method="POST" action="{{ route('purchases.update', $purchase) }}">
                @csrf
                @method('PUT')

                {{-- Header Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Supplier *
                        </label>
                        <input type="text" name="supplier_name" value="{{ old('supplier_name', $purchase->supplier_name) }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Contoh: Toko Grosir Jaya" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Pembelian *
                        </label>
                        <input type="date" name="purchase_date" value="{{ old('purchase_date', $purchase->purchase_date->format('Y-m-d')) }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>
                </div>

                {{-- Current Items Info (Read Only) --}}
                <div class="mb-6">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-4">Current Items (Read Only)</h4>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left py-2">Produk</th>
                                        <th class="text-center py-2">Quantity</th>
                                        <th class="text-right py-2">Harga Modal</th>
                                        <th class="text-right py-2">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase->purchaseItems as $item)
                                        <tr class="border-b">
                                            <td class="py-2">{{ $item->product->name }}</td>
                                            <td class="text-center py-2">{{ $item->quantity }}</td>
                                            <td class="text-right py-2">Rp {{ number_format($item->cost_price, 0, ',', '.') }}</td>
                                            <td class="text-right py-2">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="font-semibold">
                                        <td colspan="3" class="text-right py-2">Total:</td>
                                        <td class="text-right py-2">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            <strong>Note:</strong> Untuk mengubah items, silakan hapus purchase ini dan buat yang baru.
                        </p>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="flex gap-3">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                        Update Purchase
                    </button>
                    <a href="{{ route('purchases.show', $purchase) }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>