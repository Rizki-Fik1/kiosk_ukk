<x-app-layout>
    @section('page-title', 'Dashboard')
    
    <div class="min-h-screen">
        {{-- Welcome Section --}}
        <div class="bg-gradient-to-r from-[#395e66] to-[#32936f] text-white py-6 px-6 rounded-2xl shadow-lg mb-6">
            <h1 class="text-2xl font-bold mb-1">Selamat datang kembali! 👋</h1>
            <p class="text-gray-100 text-sm">{{ Auth::user()->name }} - {{ now()->format('l, d F Y') }}</p>
        </div>

        <div class="max-w-7xl mx-auto">
            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {{-- Total Products --}}
                <div class="bg-white rounded-2xl shadow-md p-6 card-hover animate-fade-in-up" style="animation-delay: 0.1s">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Total Produk</p>
                            <h3 class="text-3xl font-bold text-[#395e66]">{{ $stats['total_products'] }}</h3>
                            <p class="text-xs text-gray-400 mt-1">Item aktif</p>
                        </div>
                        <div class="bg-gradient-to-br from-[#395e66] to-[#387d7a] p-4 rounded-xl icon-pulse">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total Purchases --}}
                <div class="bg-white rounded-2xl shadow-md p-6 card-hover animate-fade-in-up" style="animation-delay: 0.2s">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Total Pembelian</p>
                            <h3 class="text-3xl font-bold text-[#387d7a]">{{ $stats['total_purchases'] }}</h3>
                            <p class="text-xs text-gray-400 mt-1">Bulan ini</p>
                        </div>
                        <div class="bg-gradient-to-br from-[#387d7a] to-[#32936f] p-4 rounded-xl icon-pulse">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Low Stock Alert --}}
                <div class="bg-white rounded-2xl shadow-md p-6 card-hover animate-fade-in-up" style="animation-delay: 0.3s">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Stok Rendah</p>
                            <h3 class="text-3xl font-bold text-[#26a96c]">{{ $stats['low_stock'] }}</h3>
                            <p class="text-xs text-gray-400 mt-1">Perlu restock</p>
                        </div>
                        <div class="bg-gradient-to-br from-[#32936f] to-[#26a96c] p-4 rounded-xl icon-pulse">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total Value --}}
                <div class="bg-white rounded-2xl shadow-md p-6 card-hover animate-fade-in-up" style="animation-delay: 0.4s">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Nilai Inventori</p>
                            <h3 class="text-2xl font-bold text-[#2bc016]">Rp {{ number_format($stats['inventory_value'], 0, ',', '.') }}</h3>
                            <p class="text-xs text-gray-400 mt-1">Total nilai stok</p>
                        </div>
                        <div class="bg-gradient-to-br from-[#26a96c] to-[#2bc016] p-4 rounded-xl icon-pulse">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistik Transaksi Hari Ini --}}
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Statistik Transaksi Hari Ini</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    {{-- Total Transaksi --}}
                    <div class="bg-white rounded-xl shadow-md p-4 card-hover">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-blue-100 p-3 rounded-full mb-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $transaction_stats['total_today'] }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Total Transaksi</p>
                        </div>
                    </div>

                    {{-- Menunggu Diproses --}}
                    <div class="bg-white rounded-xl shadow-md p-4 card-hover">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-yellow-100 p-3 rounded-full mb-2">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-yellow-600">{{ $transaction_stats['pending'] }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Menunggu Diproses</p>
                        </div>
                    </div>

                    {{-- Sedang Disiapkan --}}
                    <div class="bg-white rounded-xl shadow-md p-4 card-hover">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-blue-100 p-3 rounded-full mb-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-blue-600">{{ $transaction_stats['preparing'] }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Sedang Disiapkan</p>
                        </div>
                    </div>

                    {{-- Siap Diambil --}}
                    <div class="bg-white rounded-xl shadow-md p-4 card-hover">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-green-100 p-3 rounded-full mb-2">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-green-600">{{ $transaction_stats['ready'] }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Siap Diambil</p>
                        </div>
                    </div>

                    {{-- Selesai --}}
                    <div class="bg-white rounded-xl shadow-md p-4 card-hover">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-emerald-100 p-3 rounded-full mb-2">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-emerald-600">{{ $transaction_stats['completed'] }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Selesai</p>
                        </div>
                    </div>

                    {{-- Dibatalkan --}}
                    <div class="bg-white rounded-xl shadow-md p-4 card-hover">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-red-100 p-3 rounded-full mb-2">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-red-600">{{ $transaction_stats['expired'] }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Dibatalkan</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grafik Transaksi 7 Hari --}}
            <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Grafik Transaksi 7 Hari Terakhir</h2>
                <canvas id="transactionChart" height="80"></canvas>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Aksi Cepat</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('products.create') }}" class="flex flex-col items-center p-4 bg-gradient-to-br from-[#395e66] to-[#387d7a] rounded-xl text-white hover:shadow-lg transform hover:-translate-y-1">
                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="text-sm font-semibold">Tambah Produk</span>
                    </a>

                    <a href="{{ route('purchases.create') }}" class="flex flex-col items-center p-4 bg-gradient-to-br from-[#387d7a] to-[#32936f] rounded-xl text-white hover:shadow-lg transform hover:-translate-y-1">
                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="text-sm font-semibold">Buat Pembelian</span>
                    </a>

                    <a href="{{ route('products.index') }}" class="flex flex-col items-center p-4 bg-gradient-to-br from-[#32936f] to-[#26a96c] rounded-xl text-white hover:shadow-lg transform hover:-translate-y-1">
                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span class="text-sm font-semibold">Lihat Produk</span>
                    </a>

                    <a href="{{ route('purchases.index') }}" class="flex flex-col items-center p-4 bg-gradient-to-br from-[#26a96c] to-[#2bc016] rounded-xl text-white hover:shadow-lg transform hover:-translate-y-1">
                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-sm font-semibold">Lihat Pembelian</span>
                    </a>
                </div>
            </div>

            {{-- Transaksi Terbaru & Aktivitas Admin --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                {{-- Transaksi Terbaru --}}
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Transaksi Terbaru</h2>
                        <a href="{{ route('transactions.index') }}" class="text-[#387d7a] text-sm font-semibold hover:text-[#395e66]">Lihat Semua →</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">ID</th>
                                    <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Customer</th>
                                    <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600">Total</th>
                                    <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($recent_transactions as $transaction)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-3 font-mono text-xs">#{{ $transaction['code'] }}</td>
                                        <td class="px-3 py-3">
                                            <p class="font-medium text-gray-800">{{ $transaction['customer'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $transaction['time'] }}</p>
                                        </td>
                                        <td class="px-3 py-3 text-right font-semibold">Rp {{ number_format($transaction['total'], 0, ',', '.') }}</td>
                                        <td class="px-3 py-3 text-center">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $transaction['status_class'] }}">
                                                {{ $transaction['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-3 py-8 text-center text-gray-400">Belum ada transaksi hari ini</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Aktivitas Admin --}}
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Admin Terakhir</h2>
                    <div class="space-y-4">
                        @forelse($admin_activities as $activity)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full {{ $activity['icon_bg'] }} flex items-center justify-center">
                                        {!! $activity['icon'] !!}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-800">
                                        <span class="font-semibold">{{ $activity['admin'] }}</span>
                                        {{ $activity['action'] }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $activity['time'] }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400 text-center py-4">Belum ada aktivitas</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Recent Activities & Low Stock --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                {{-- Recent Purchases --}}
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Pembelian Terbaru</h2>
                        <a href="{{ route('purchases.index') }}" class="text-[#387d7a] text-sm font-semibold hover:text-[#395e66]">Lihat Semua →</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recent_purchases as $purchase)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $purchase->supplier_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $purchase->purchase_date->format('d M Y') }}</p>
                                </div>
                                <span class="text-[#32936f] font-bold">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</span>
                            </div>
                        @empty
                            <p class="text-gray-400 text-center py-4">Belum ada pembelian terbaru</p>
                        @endforelse
                    </div>
                </div>

                {{-- Low Stock Products --}}
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Peringatan Stok Rendah</h2>
                        <a href="{{ route('products.index') }}" class="text-[#387d7a] text-sm font-semibold hover:text-[#395e66]">Lihat Semua →</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($low_stock_products as $product)
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg hover:bg-red-100">
                                <div class="flex items-center space-x-3">
                                    @if($product->image)
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-500">Min: {{ $product->min_stock ?? 10 }}</p>
                                    </div>
                                </div>
                                <span class="text-red-600 font-bold">{{ $product->stock }}</span>
                            </div>
                        @empty
                            <p class="text-gray-400 text-center py-4">Semua produk stoknya cukup! 🎉</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Grafik Transaksi 7 Hari
        const ctx = document.getElementById('transactionChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chart_data['labels']) !!},
                    datasets: [{
                        label: 'Transaksi',
                        data: {!! json_encode($chart_data['data']) !!},
                        borderColor: '#387d7a',
                        backgroundColor: 'rgba(56, 125, 122, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#387d7a',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#395e66',
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    return 'Transaksi: ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 5,
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>
