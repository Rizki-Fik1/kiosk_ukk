<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapak Kelontong - Coming Soon</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-yellow-100 via-orange-100 to-red-100 min-h-screen flex flex-col justify-center items-center text-center px-6">

    {{-- Icon / Logo --}}
    <div class="mb-6">
        <span class="text-7xl">🏪</span>
    </div>

    {{-- Judul --}}
    <h1 class="text-4xl font-bold text-gray-800 mb-2">
        Kios Fitri
    </h1>

    {{-- Subjudul --}}
    <h2 class="text-2xl font-semibold text-red-600 mb-4">
        🚧 Coming Soon 🚧
    </h2>

    {{-- Deskripsi --}}
    <p class="text-gray-600 max-w-md mb-8">
        Website toko kelontong ini sedang dalam pengembangan.  
        Nantikan kemudahan belanja kebutuhan sehari-hari langsung dari web!
    </p>

    {{-- Tombol Placeholder --}}
    <div class="space-y-4">
        <button class="px-6 py-3 bg-red-500 text-white font-medium rounded-full shadow hover:bg-red-600 transition">
            Akan Dibuka Nanti
        </button>
        
        @if(app()->environment('local'))
            {{-- Link ke Admin (hanya untuk development) --}}
            <div class="mt-6">
                <a href="{{ route('products.index') }}" 
                   class="inline-block px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition">
                    Admin Panel (Development)
                </a>
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <footer class="mt-12 text-sm text-gray-500">
        © {{ date('Y') }} Lapak Kelontong. All rights reserved.
    </footer>

</body>
</html>