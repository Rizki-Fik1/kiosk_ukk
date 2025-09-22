<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary; // library bawaan cloudinary-laravel

class ProductController extends Controller
{
    protected $cloudinary;

    public function __construct()
    {
        // inisialisasi Cloudinary pakai ENV (CLOUDINARY_URL)
        $this->cloudinary = new Cloudinary(
            config('cloudinary.cloud_url')
        );
    }

    //Read Product
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

  
    //Save Product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload ke Cloudinary jika ada file
        if ($request->hasFile('image')) {
            $uploaded = $this->cloudinary->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'products']
            );

            $validated['image'] = $uploaded['secure_url']; // simpan URL aman
            $validated['image_id'] = $uploaded['public_id']; // simpan public_id untuk hapus/update
        }

        Product::create($validated);

        return redirect()->back()->with('success', 'Product added!');
    }

 
    //Update Product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama di Cloudinary
            if ($product->image_id) {
                $this->cloudinary->uploadApi()->destroy($product->image_id);
            }

            // Upload gambar baru
            $uploaded = $this->cloudinary->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'products']
            );

            $validated['image'] = $uploaded['secure_url'];
            $validated['image_id'] = $uploaded['public_id'];
        }

        $product->update($validated);

        return redirect()->back()->with('success', 'Product updated!');
    }


    //Delete Product
    public function destroy(Product $product)
    {
        // Hapus file di Cloudinary
        if ($product->image_id) {
            $this->cloudinary->uploadApi()->destroy($product->image_id);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted!');
    }
}