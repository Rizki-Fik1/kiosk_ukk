<x-app-layout>
    {{-- Judul halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Purchases
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Alert flash message --}}
        @if(session('success'))
            <div class="mb-4 p-4 text-green-800 bg-green-100 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 text-red-800 bg-red-100 border border-red-300 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Button Buat Purchase Baru --}}
        <div class="mb-6">
            <a href="{{ route('purchases.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded inline-block">
                + Buat Pembelian Baru
            </a>
        </div>

        {{-- Card Tabel Purchase --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Purchase List</h3>
            
            @if($purchases->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 dark:border-gray-700 text-sm">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                <th class="p-3 border text-left">ID</th>
                                <th class="p-3 border text-left">Supplier</th>
                                <th class="p-3 border text-left">Date</th>
                                <th class="p-3 border text-center">Total Items</th>
                                <th class="p-3 border text-right">Total Amount</th>
                                <th class="p-3 border text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($purchases as $purchase)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="p-3 border">{{ $purchase->id }}</td>
                                    <td class="p-3 border font-medium">{{ $purchase->supplier_name }}</td>
                                    <td class="p-3 border">{{ $purchase->purchase_date->format('d/m/Y') }}</td>
                                    <td class="p-3 border text-center">{{ $purchase->purchaseItems->sum('quantity') }}</td>
                                    <td class="p-3 border text-right">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                                    <td class="p-3 border text-center">
                                        <div class="flex gap-2 justify-center">
                                            <a href="{{ route('purchases.show', $purchase) }}" 
                                               class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                                View
                                            </a>
                                            <a href="{{ route('purchases.edit', $purchase) }}" 
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('purchases.destroy', $purchase) }}" 
                                                  onsubmit="return confirm('Are you sure you want to delete this purchase?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $purchases->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Belum ada pembelian yang tercatat.</p>
                    <a href="{{ route('purchases.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                        Buat Pembelian Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
