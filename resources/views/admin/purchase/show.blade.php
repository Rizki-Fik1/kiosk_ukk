<x-app-layout>
    {{-- Judul halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Purchase #{{ $purchase->id }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('purchases.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded">
                ← Kembali ke Daftar Purchase
            </a>
        </div>

        {{-- Purchase Header Info --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Informasi Purchase</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Purchase ID</label>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">#{{ $purchase->id }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Supplier</label>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $purchase->supplier_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Purchase</label>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $purchase->purchase_date->format('d F Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Total Items</label>
                    <p class="text-lg font-semibold text-blue-600">{{ $purchase->purchaseItems->sum('quantity') }} pcs</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Total Amount</label>
                    <p class="text-lg font-semibold text-green-600">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Created At</label>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $purchase->created_at->format('d F Y H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Purchase Items --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Items Pembelian</h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 dark:border-gray-700 text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <th class="p-3 border text-left">No</th>
                            <th class="p-3 border text-left">Produk</th>
                            <th class="p-3 border text-center">Quantity</th>
                            <th class="p-3 border text-right">Harga Modal</th>
                            <th class="p-3 border text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($purchase->purchaseItems as $index => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="p-3 border">{{ $index + 1 }}</td>
                                <td class="p-3 border">
                                    <div>
                                        <p class="font-medium">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-500">Stock saat ini: {{ $item->product->stock }}</p>
                                    </div>
                                </td>
                                <td class="p-3 border text-center">{{ $item->quantity }}</td>
                                <td class="p-3 border text-right">Rp {{ number_format($item->cost_price, 0, ',', '.') }}</td>
                                <td class="p-3 border text-right font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-100 dark:bg-gray-700 font-semibold">
                            <td colspan="4" class="p-3 border text-right">Total:</td>
                            <td class="p-3 border text-right text-lg">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Actions</h3>
            
            <div class="flex gap-3">
                <a href="{{ route('purchases.edit', $purchase) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded">
                    Edit Purchase
                </a>
                
                <form method="POST" action="{{ route('purchases.destroy', $purchase) }}" 
                      onsubmit="return confirm('Are you sure you want to delete this purchase? This will also rollback the stock changes.')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded">
                        Delete Purchase
                    </button>
                </form>

                <button onclick="window.print()" 
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">
                    Print Purchase
                </button>
            </div>
        </div>
    </div>

    {{-- Print Styles --}}
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                font-size: 12px;
            }
            
            .print-header {
                text-align: center;
                margin-bottom: 20px;
            }
        }
    </style>
</x-app-layout>