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

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="mb-4 p-4 text-red-800 bg-red-100 border border-red-300 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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

                    <input type="number" name="price" placeholder="Price" min="0" step="0.01"
                        class="border rounded p-2" required>

                    <input type="number" name="stock" placeholder="Stock" min="0"
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
            
            {{-- Search & Filter Form --}}
            <form method="GET" action="{{ route('products.index') }}" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    {{-- Search --}}
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Search by product name..."
                            class="w-full border rounded p-2 text-sm">
                    </div>

                    {{-- Filter by Status --}}
                    <div>
                        <select name="is_active" class="w-full border rounded p-2 text-sm">
                            <option value="">All Status</option>
                            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    {{-- Filter Low Stock --}}
                    <div>
                        <select name="low_stock" class="w-full border rounded p-2 text-sm">
                            <option value="">All Stock</option>
                            <option value="1" {{ request('low_stock') == '1' ? 'selected' : '' }}>Low Stock (≤10)</option>
                        </select>
                    </div>

                    {{-- Sort By --}}
                    <div>
                        <select name="sort_by" class="w-full border rounded p-2 text-sm">
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Sort by Date</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Sort by Name</option>
                            <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Sort by Price</option>
                            <option value="stock" {{ request('sort_by') == 'stock' ? 'selected' : '' }}>Sort by Stock</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                        Apply Filters
                    </button>
                    <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm inline-block">
                        Reset
                    </a>
                    
                    {{-- Sort Order Toggle --}}
                    <input type="hidden" name="sort_order" id="sortOrderInput" value="{{ request('sort_order', 'desc') }}">
                    <button type="button" onclick="toggleSortOrder(event)" 
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm">
                        @if(request('sort_order') == 'asc')
                            ↑ Ascending (A-Z, 0-9)
                        @else
                            ↓ Descending (Z-A, 9-0)
                        @endif
                    </button>
                </div>
            </form>

            {{-- Results Info --}}
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
            </div>
            
            @if($products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 dark:border-gray-700 text-sm">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-white dark:text-gray-300">
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
                                            <img src="{{ $p->image }}" 
                                                 alt="Product" 
                                                 class="w-16 h-16 object-cover rounded mx-auto border"
                                                 style="display: block;">
                                        @else
                                            <span class="text-gray-500">No image</span>
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

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">No products found.</p>
            @endif
        </div>
    </div>

    {{-- Image Preview Modal --}}
    <div id="imagePreviewModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50" onclick="closeImagePreview()">
        <div class="relative max-w-4xl max-h-screen p-4">
            <button onclick="closeImagePreview()" class="absolute top-2 right-2 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="previewImage" src="" alt="" class="max-w-full max-h-screen object-contain rounded-lg shadow-2xl" onclick="event.stopPropagation()">
            <p id="previewImageName" class="text-white text-center mt-4 font-semibold"></p>
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

                    <input type="number" id="editPrice" name="price" placeholder="Price" min="0" step="0.01"
                        class="border rounded p-2" required>

                    <input type="number" id="editStock" name="stock" placeholder="Stock" min="0"
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
        // Image Preview Functions
        function showImagePreview(imageUrl, productName) {
            document.getElementById('previewImage').src = imageUrl;
            document.getElementById('previewImageName').textContent = productName;
            document.getElementById('imagePreviewModal').classList.remove('hidden');
            document.getElementById('imagePreviewModal').classList.add('flex');
        }

        function closeImagePreview() {
            document.getElementById('imagePreviewModal').classList.add('hidden');
            document.getElementById('imagePreviewModal').classList.remove('flex');
        }

        // Edit Modal Functions
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

        // Toggle sort order
        function toggleSortOrder(event) {
            event.preventDefault(); // Prevent default button behavior
            const input = document.getElementById('sortOrderInput');
            input.value = input.value === 'asc' ? 'desc' : 'asc';
            
            // Submit the filter form (not the add product form)
            const filterForm = document.querySelector('form[method="GET"]');
            if (filterForm) {
                filterForm.submit();
            }
        }
    </script>
</x-app-layout>
