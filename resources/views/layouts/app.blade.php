{{-- resources/views/components/app-layout.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="font-family: 'Plus Jakarta Sans', sans-serif;" 
          x-data="{ 
              sidebarOpen: window.innerWidth >= 1024,
              init() {
                  this.$watch('sidebarOpen', value => {
                      if (window.innerWidth >= 1024) {
                          this.sidebarOpen = true;
                      }
                  });
              }
          }">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
            
            {{-- Sidebar --}}
            @include('layouts.sidebar')

            {{-- Topbar --}}
            @include('layouts.topbar')

            {{-- Main Content --}}
            <main class="mt-16 p-6 min-h-screen transition-all duration-300"
                  :class="{ 'lg:ml-64': sidebarOpen || window.innerWidth >= 1024, 'lg:ml-0': !sidebarOpen && window.innerWidth < 1024 }">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
