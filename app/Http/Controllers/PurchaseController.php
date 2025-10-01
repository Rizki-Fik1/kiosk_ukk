<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;


class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with('purchaseItems.product')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('admin.purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('is_active', true)
        ->orderBy('name')
        ->get();

        return view('admin.purchase.create', compact('prodcuts'));
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

        DB::transaction(function () use ($validated) {
            $purchase = Purchase::create([
                'supplier_name' => $validated['supplier_name'],
                'purchase_date' => $validated['purchase_date'],
                'total_amount' => 0
            ]);

            $totalAmount =0;

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);

                $subtotal = $item['quantity'] * $item['cost_price'];

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'cost_price' => $item['cost_price'],
                    'subtotal' => $subtotal
                ]);

                $product->updateStock($item['quantity'], 'increase');

                $totalAmount += $subtotal;
            }

            $purchase->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('purchases.index')->with('success', 'Purchase added!');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        // 1. Validation (sama pattern)
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'purchase_date' => 'required|date',
        ]);

        // 2. Update (sama pattern)
        $purchase->update($validated);

        // 3. Redirect (sama pattern)
        return redirect()->route('purchases.index')->with('success', 'Purchase updated!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        // Soft delete atau hard delete
        $purchase->delete();  // Akan cascade delete purchase_items juga

        return redirect()->route('purchases.index')->with('success', 'Purchase deleted!');
    }
}
