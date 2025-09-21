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
                                <th class="p-3 border">Actions</th>
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
                                    <td class="p-3 border text-center">
                                        <div class="flex gap-2 justify-center">
                                            <button onclick="openEditModal({{ $p->id }}, '{{ $p->name }}', '{{ $p->description }}', {{ $p->price }}, {{ $p->stock }})"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                Edit
                                            </button>
                                            <form method="POST" action="{{ route('products.destroy', $p->id) }}" 
                                                onsubmit="return confirm('Are you sure you want to delete this product?')" class="inline">
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
            @else
                <p class="text-gray-500 dark:text-gray-400">Belum ada produk yang ditambahkan.</p>
            @endif
        </div>
    </div>

    {{-- Edit Product Modal --}}
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Edit Product</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                @method('PUT')
                <div class="flex flex-col gap-3">
                    <input type="text" id="editName" name="name" placeholder="Name"
                        class="border rounded p-2" required>

                    <textarea id="editDescription" name="description" placeholder="Description"
                        class="border rounded p-2"></textarea>

                    <input type="number" id="editPrice" name="price" placeholder="Price"
                        class="border rounded p-2" required>

                    <input type="number" id="editStock" name="stock" placeholder="Stock"
                        class="border rounded p-2" required>

                    <input type="file" name="image" class="border rounded p-2">
                    <small class="text-gray-500">Leave empty to keep current image</small>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded flex-1">
                            Update Product
                        </button>
                        <button type="button" onclick="closeEditModal()"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, description, price, stock) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
            
            document.getElementById('editName').value = name;
            document.getElementById('editDescription').value = description;
            document.getElementById('editPrice').value = price;
            document.getElementById('editStock').value = stock;
            
            document.getElementById('editForm').action = `/admin/products/${id}`;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>
</x-app-layout>
