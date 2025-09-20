<x-app-layout>
    {{-- Judul halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Products
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Alert flash message --}}
        @if(session('success'))
            <div class="mb-4 p-4 text-green-800 bg-green-100 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Card Form Tambah Produk --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Add Product</h3>

            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="flex flex-col gap-3">
                    <input type="text" name="name" placeholder="Name"
                        class="border rounded p-2" required>

                    <textarea name="description" placeholder="Description"
                        class="border rounded p-2"></textarea>

                    <input type="number" name="price" placeholder="Price"
                        class="border rounded p-2" required>

                    <input type="number" name="stock" placeholder="Stock"
                        class="border rounded p-2" required>

                    <input type="file" name="image" class="border rounded p-2">

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                        Add Product
                    </button>
                </div>
            </form>
        </div>

        {{-- Card Tabel Produk --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Product List</h3>
            
            @if($products->count() > 0)
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
                                    <td class="p-3 border text-center">
                                        @if($p->image)
                                            <img src="{{ $p->image }}" alt="Product Image"
                                                class="w-16 h-16 object-cover rounded mx-auto">
                                        @else
                                            <span class="text-gray-400">No image</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">Belum ada produk yang ditambahkan.</p>
            @endif
        </div>
    </div>
</x-app-layout>
