<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\PurchaseService;
use Exception;

class PurchaseController extends Controller
{
    protected $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    /**
     * Display a listing of the resource with Search, Sort, and Filter.
     */
    public function index(Request $request)
    {
        $query = Purchase::with('purchaseItems.product');

        // Search by supplier name
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->whereRaw('LOWER(supplier_name) like ?', ["%{$search}%"]);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('purchase_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('purchase_date', '<=', $request->date_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'purchase_date');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSorts = ['supplier_name', 'total_amount', 'purchase_date', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'supplier_name') {
                $query->orderByRaw("LOWER(supplier_name) {$sortOrder}");
            } else {
                $query->orderBy($sortBy, $sortOrder);
            }
        }

        // Calculate statistics before pagination
        $statsQuery = clone $query;
        $stats = [
            'total_purchases' => $statsQuery->count(),
            'total_amount' => $statsQuery->sum('total_amount'),
            'total_items' => $statsQuery->get()->sum(function ($purchase) {
                return $purchase->purchaseItems->sum('quantity');
            }),
        ];

        // Pagination (fixed at 15 items per page)
        $purchases = $query->paginate(15)->withQueryString();

        return view('admin.purchase.index', compact('purchases', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.purchase.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.cost_price' => 'required|numeric|min:0',
        ]);

        try {
            $purchase = $this->purchaseService->createPurchase($validated);
            
            return redirect()->route('purchases.index')
                ->with('success', 'Purchase berhasil dibuat!');
                
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load('purchaseItems.product');

        return view('admin.purchase.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $purchase->load('purchaseItems.product');
        
        return view('admin.purchase.edit', compact('purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'purchase_date' => 'required|date',
        ]);

        try {
            $purchase->update($validated);
            
            return redirect()->route('purchases.show', $purchase)
                ->with('success', 'Purchase berhasil diupdate!');
                
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        try {
            $this->purchaseService->deletePurchase($purchase);
            
            return redirect()->route('purchases.index')
                ->with('success', 'Purchase berhasil dihapus dan stock telah dikembalikan!');
                
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
