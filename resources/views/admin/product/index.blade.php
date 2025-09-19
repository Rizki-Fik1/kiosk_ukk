<x-app-layout>
    {{-- Judul halaman (opsional header) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Products
        </h2>
    </x-slot>

    {{-- Konten utama --}}
    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Card Form Tambah Produk --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Add Product</h3>

        <form method="POST" action="/admin/products" enctype="multipart/form-data" class="mb-6">
            @csrf
            <input type="text" name="name" placeholder="Name" class="border p-2 mr-2" required>
            <input type="text" name="description" placeholder="Description" class="border p-2 mr-2">
            <input type="number" name="price" placeholder="Price" class="border p-2 mr-2" required>
            <input type="number" name="stock" placeholder="Stock" class="border p-2 mr-2" required>
            <input type="file" name="image">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Add</button>
        </form>

        </div>

        {{-- Card Tabel Produk --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Product List</h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 dark:border-gray-700 text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <th class="p-3 border">ID</th>
                            <th class="p-3 border">Name</th>
                            <th class="p-3 border">Description</th>
                            <th class="p-3 border">Price</th>
                            <th class="p-3 border">Stock</th>
                            <th class="p-3 border">Image</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($products as $p)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="p-3 border">{{ $p->id }}</td>
                                <td class="p-3 border font-medium">{{ $p->name }}</td>
                                <td class="p-3 border">{{ $p->description }}</td>
                                <td class="p-3 border">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                                <td class="p-3 border">{{ $p->stock }}</td>
                                <td class="p-3 border">
                                    @if($p->image)
                                        <img src="{{ $p->image }}" alt="Product Image" class="w-16 h-16 object-cover rounded">
                                    @else
                                        <span class="text-gray-400">No image</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
