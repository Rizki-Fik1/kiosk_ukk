<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'total_products' => Product::where('is_active', true)->count(),
            'total_purchases' => Purchase::whereMonth('created_at', now()->month)->count(),
            'low_stock' => Product::where('is_active', true)
                ->whereRaw('stock <= COALESCE(min_stock, 10)')
                ->count(),
            'inventory_value' => Product::where('is_active', true)
                ->selectRaw('SUM(stock * price) as total')
                ->value('total') ?? 0,
        ];

        // Transaction Statistics (Sample Data - will be replaced with real data)
        $transaction_stats = [
            'total_today' => 45,
            'pending' => 8,
            'preparing' => 12,
            'ready' => 15,
            'completed' => 7,
            'expired' => 3,
        ];

        // Chart Data - Transaksi 7 Hari Terakhir (Sample Data)
        $chart_data = [
            'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            'data' => [23, 31, 28, 35, 42, 38, 45],
        ];

        // Recent Transactions (Sample Data)
        $recent_transactions = [
            [
                'code' => 'PO00123',
                'customer' => 'Aldian Pratama',
                'total' => 21000,
                'status' => 'Siap Diambil',
                'status_class' => 'bg-green-100 text-green-700',
                'time' => '10:12'
            ],
            [
                'code' => 'PO00122',
                'customer' => 'Siti Nurhaliza',
                'total' => 45500,
                'status' => 'Sedang Disiapkan',
                'status_class' => 'bg-blue-100 text-blue-700',
                'time' => '09:45'
            ],
            [
                'code' => 'PO00121',
                'customer' => 'Budi Santoso',
                'total' => 15000,
                'status' => 'Menunggu Diproses',
                'status_class' => 'bg-yellow-100 text-yellow-700',
                'time' => '09:20'
            ],
            [
                'code' => 'PO00120',
                'customer' => 'Dewi Lestari',
                'total' => 32000,
                'status' => 'Selesai',
                'status_class' => 'bg-emerald-100 text-emerald-700',
                'time' => '08:55'
            ],
            [
                'code' => 'PO00119',
                'customer' => 'Ahmad Fauzi',
                'total' => 18500,
                'status' => 'Expired',
                'status_class' => 'bg-red-100 text-red-700',
                'time' => '08:30'
            ],
        ];

        // Admin Activities (Sample Data)
        $admin_activities = [
            [
                'admin' => Auth::user()->name,
                'action' => 'mengubah status pesanan #PO00123 → Siap Diambil',
                'time' => '5 menit yang lalu',
                'icon' => '<svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                'icon_bg' => 'bg-green-100'
            ],
            [
                'admin' => 'Admin B',
                'action' => 'menambah stok Indomie Goreng +20',
                'time' => '15 menit yang lalu',
                'icon' => '<svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>',
                'icon_bg' => 'bg-blue-100'
            ],
            [
                'admin' => 'Kasir',
                'action' => 'melakukan login ke sistem',
                'time' => '1 jam yang lalu',
                'icon' => '<svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>',
                'icon_bg' => 'bg-gray-100'
            ],
            [
                'admin' => Auth::user()->name,
                'action' => 'menambahkan produk baru "Teh Botol Sosro"',
                'time' => '2 jam yang lalu',
                'icon' => '<svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                'icon_bg' => 'bg-purple-100'
            ],
            [
                'admin' => 'Admin B',
                'action' => 'mengubah harga Aqua 600ml',
                'time' => '3 jam yang lalu',
                'icon' => '<svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>',
                'icon_bg' => 'bg-orange-100'
            ],
        ];

        // Recent purchases (last 5)
        $recent_purchases = Purchase::with('purchaseItems')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Low stock products (stock <= min_stock or stock <= 10)
        $low_stock_products = Product::where('is_active', true)
            ->whereRaw('stock <= COALESCE(min_stock, 10)')
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'stats',
            'transaction_stats',
            'chart_data',
            'recent_transactions',
            'admin_activities',
            'recent_purchases',
            'low_stock_products'
        ));
    }
}
