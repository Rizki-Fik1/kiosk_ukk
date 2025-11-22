<x-app-layout>
    @section('page-title', 'Edit Pembelian')

    <div class="max-w-4xl mx-auto">
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
                <a href="{{ route('purchases.show', $purchase) }}" class="text-gray-600 hover:text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Edit Pembelian #{{ $purchase->id }}</h1>
            </div>
            <p class="text-gray-600 text-sm">Update informasi pembelian</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl shadow-md p-6">
            <form method="POST" action="{{ route('purchases.update', $purchase) }}">
                @csrf
                @method('PUT')

                {{-- Supplier Name --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Supplier <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="supplier_name" 
                           value="{{ old('supplier_name', $purchase->supplier_name) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#387d7a] focus:border-transparent">
                </div>

                {{-- Purchase Date --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Pembelian <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           name="purchase_date" 
                           value="{{ old('purchase_date', $purchase->purchase_date->format('Y-m-d')) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#387d7a] focus:border-transparent">
                </div>

                {{-- Info Note --}}
                <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-700">
                            <p class="font-semibold mb-1">Catatan:</p>
                            <p>Untuk mengubah item pembelian, silakan hapus pembelian ini dan buat pembelian baru. Edit hanya untuk informasi supplier dan tanggal.</p>
                        </div>
                    </div>
                </div>

                {{-- Current Items Display --}}
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Item Pembelian Saat Ini:</h4>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        @foreach($purchase->purchaseItems as $item)
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-700">{{ $item->product->name }}</span>
                                <span class="text-gray-600">{{ $item->quantity }} × Rp {{ number_format($item->cost_price, 0, ',', '.') }} = <span class="font-semibold text-[#387d7a]">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span></span>
                            </div>
                        @endforeach
                        <div class="pt-2 border-t border-gray-200 flex justify-between items-center font-semibold">
                            <span class="text-gray-700">Total:</span>
                            <span class="text-[#26a96c]">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center space-x-3 pt-6 border-t">
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-[#387d7a] to-[#32936f] text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition">
                        <span class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Update Pembelian</span>
                        </span>
                    </button>
                    <a href="{{ route('purchases.show', $purchase) }}" 
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
