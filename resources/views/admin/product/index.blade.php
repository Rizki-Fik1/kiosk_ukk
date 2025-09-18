<x-app-layout>
    {{-- Judul halaman (opsional header) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Products
        </h2>
    </x-slot>

    {{-- Konten utama --}}
    <div class="py-6 max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Products</h1>

        {{-- Form Tambah Produk --}}
        <form method="POST" action="/admin/products" class="mb-6">
            @csrf
            <input type="text" name="name" placeholder="Name" class="border p-2 mr-2" required>
            <input type="number" name="price" placeholder="Price" class="border p-2 mr-2" required>
            <input type="number" name="stock" placeholder="Stock" class="border p-2 mr-2" required>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Add</button>
        </form>

        {{-- List Produk --}}
        <table class="w-full bg-white border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Name</th>
                    <th class="p-2 border">Price</th>
                    <th class="p-2 border">Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                    <tr>
                        <td class="p-2 border">{{ $p->id }}</td>
                        <td class="p-2 border">{{ $p->name }}</td>
                        <td class="p-2 border">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                        <td class="p-2 border">{{ $p->stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
    