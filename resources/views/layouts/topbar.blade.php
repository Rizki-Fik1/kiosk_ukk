{{-- Topbar for Mobile & Desktop --}}
<header class="fixed top-0 right-0 h-16 bg-white shadow-md z-30 flex items-center justify-between px-6 transition-all duration-300" 
        :class="{ 'lg:left-64': sidebarOpen || window.innerWidth >= 1024, 'left-0': !sidebarOpen || window.innerWidth < 1024 }"
        x-data="{ notificationOpen: false }">
    {{-- Menu Toggle Button --}}
    <div class="flex items-center space-x-4">
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-100 transition">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        {{-- Page Title (Desktop) --}}
        <div class="hidden md:block">
            <h2 class="text-xl font-bold text-gray-800">
                @yield('page-title', 'Dashboard')
            </h2>
        </div>
    </div>

    {{-- Right Side Actions --}}
    <div class="flex items-center space-x-4">
        {{-- Notification Bell --}}
        <div class="relative">
            <button @click="notificationOpen = !notificationOpen" 
                    class="relative p-2 rounded-lg hover:bg-gray-100 transition">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            {{-- Notification Dropdown --}}
            <div x-show="notificationOpen" 
                 @click.away="notificationOpen = false"
                 x-cloak
                 class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                <div class="p-4 border-b bg-gradient-to-r from-[#395e66] to-[#32936f]">
                    <h3 class="font-semibold text-white">Notifications</h3>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    <div class="p-4 text-center text-gray-500 text-sm">
                        No new notifications
                    </div>
                </div>
            </div>
        </div>

        {{-- Current Time --}}
        <div class="hidden md:flex items-center space-x-2 text-sm text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span id="current-time"></span>
        </div>
    </div>
</header>

{{-- Script for Clock --}}
<script>
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit'
        });
        const dateString = now.toLocaleDateString('id-ID', { 
            day: 'numeric', 
            month: 'short', 
            year: 'numeric' 
        });
        document.getElementById('current-time').textContent = `${timeString} - ${dateString}`;
    }
    
    if (document.getElementById('current-time')) {
        updateTime();
        setInterval(updateTime, 1000);
    }
</script>
