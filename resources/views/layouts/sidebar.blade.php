{{-- Sidebar Component --}}
<aside 
    x-show="sidebarOpen || window.innerWidth >= 1024"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true"
    class="fixed left-0 top-0 h-screen w-64 bg-gradient-to-b from-[#395e66] to-[#32936f] shadow-2xl z-50 flex flex-col lg:translate-x-0">
    {{-- Logo & Brand --}}
    <div class="p-6 border-b border-white/10">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
            <div class="bg-white p-2.5 rounded-xl shadow-lg">
                <svg class="w-7 h-7 text-[#387d7a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-white font-bold text-lg">Toko Klontong</h1>
                <p class="text-white/70 text-xs">Admin Panel</p>
            </div>
        </a>
    </div>

    {{-- Navigation Menu --}}
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all {{ request()->routeIs('dashboard') ? 'bg-white/20 shadow-lg font-semibold' : 'hover:bg-white/10' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span>Dashboard</span>
        </a>

        {{-- Produk --}}
        <a href="{{ route('products.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all {{ request()->routeIs('products.*') ? 'bg-white/20 shadow-lg font-semibold' : 'hover:bg-white/10' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <span>Produk</span>
        </a>

        {{-- Stok (Purchases + Adjustment) --}}
        <a href="{{ route('purchases.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all {{ request()->routeIs('purchases.*') || request()->routeIs('adjustments.*') ? 'bg-white/20 shadow-lg font-semibold' : 'hover:bg-white/10' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <span>Stok</span>
        </a>

        {{-- Transaksi (Coming Soon) --}}
        <a href="{{ route('transactions.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all {{ request()->routeIs('transactions.*') ? 'bg-white/20 shadow-lg font-semibold' : 'hover:bg-white/10' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <span>Transaksi</span>
            <span class="ml-auto text-xs bg-yellow-500 text-white px-2 py-0.5 rounded-full">Soon</span>
        </a>

        {{-- Customer (Coming Soon) --}}
        <a href="{{ route('customers.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all {{ request()->routeIs('customers.*') ? 'bg-white/20 shadow-lg font-semibold' : 'hover:bg-white/10' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span>Customer</span>
            <span class="ml-auto text-xs bg-yellow-500 text-white px-2 py-0.5 rounded-full">Soon</span>
        </a>

        {{-- Admin (Coming Soon) --}}
        <a href="{{ route('admins.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all {{ request()->routeIs('admins.*') ? 'bg-white/20 shadow-lg font-semibold' : 'hover:bg-white/10' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <span>Admin</span>
            <span class="ml-auto text-xs bg-yellow-500 text-white px-2 py-0.5 rounded-full">Soon</span>
        </a>

        {{-- Pengaturan (Coming Soon) --}}
        <a href="{{ route('settings.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white transition-all {{ request()->routeIs('settings.*') ? 'bg-white/20 shadow-lg font-semibold' : 'hover:bg-white/10' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span>Pengaturan</span>
            <span class="ml-auto text-xs bg-yellow-500 text-white px-2 py-0.5 rounded-full">Soon</span>
        </a>
    </nav>

    {{-- User Profile & Logout --}}
    <div class="p-4 border-t border-white/10">
        <div class="flex items-center space-x-3 mb-3">
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                <span class="text-[#387d7a] font-bold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <div class="flex-1">
                <p class="text-white font-semibold text-sm">{{ Auth::user()->name }}</p>
                <p class="text-white/70 text-xs">{{ Auth::user()->email }}</p>
            </div>
        </div>
        
        <div class="space-y-1">
            <a href="{{ route('profile.edit') }}" 
               class="flex items-center space-x-2 px-3 py-2 rounded-lg text-white hover:bg-white/10 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Profile</span>
            </a>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center space-x-2 px-3 py-2 rounded-lg text-white hover:bg-red-500/20 transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- Mobile Sidebar Overlay --}}
<div x-show="sidebarOpen" 
     x-cloak
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-black/50 z-40 lg:hidden"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
</div>
