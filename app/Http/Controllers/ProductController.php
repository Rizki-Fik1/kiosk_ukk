<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    public function store(Request $request)
    {
        Product::create($request->only('name', 'price', 'stock'));
        return redirect()->back()->with('success', 'Product added!');
    }
}
