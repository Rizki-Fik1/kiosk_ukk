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

    //Read Product with Search, Sort, and Filter
    public function index(Request $request)
    {
        $query = Product::query();

        // Search by name only (case insensitive)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->whereRaw('LOWER(name) like ?', ["%{$search}%"]);
        }

        // Filter by active status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Filter by low stock
        if ($request->filled('low_stock') && $request->low_stock == '1') {
            $query->where('stock', '<=', 10);
        }

        // Sort (default: descending - terbesar/terbaru di atas)
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSorts = ['name', 'price', 'stock', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            // For name, use case-insensitive sort
            if ($sortBy === 'name') {
                $query->orderByRaw("LOWER(name) {$sortOrder}");
            } else {
                $query->orderBy($sortBy, $sortOrder);
            }
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage)->withQueryString();

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit', compact('product'));
    }

  
    //Save Product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'nullable|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'name.max' => 'Nama produk maksimal 100 karakter',
            'price.required' => 'Harga wajib diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga tidak boleh negatif',
            'stock.required' => 'Stok wajib diisi',
            'stock.integer' => 'Stok harus berupa angka bulat (tanpa koma atau desimal)',
            'stock.min' => 'Stok tidak boleh negatif',
            'min_stock.integer' => 'Minimum stok harus berupa angka bulat',
            'min_stock.min' => 'Minimum stok tidak boleh negatif',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Handle is_active checkbox
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

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

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

 
    //Update Product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'nullable|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'name.max' => 'Nama produk maksimal 100 karakter',
            'price.required' => 'Harga wajib diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga tidak boleh negatif',
            'stock.required' => 'Stok wajib diisi',
            'stock.integer' => 'Stok harus berupa angka bulat (tanpa koma atau desimal)',
            'stock.min' => 'Stok tidak boleh negatif',
            'min_stock.integer' => 'Minimum stok harus berupa angka bulat',
            'min_stock.min' => 'Minimum stok tidak boleh negatif',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Handle is_active checkbox (checkbox tidak terkirim jika tidak dicentang)
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

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

        return redirect()->route('products.show', $product)->with('success', 'Produk berhasil diperbarui!');
    }


    //Delete Product
    public function destroy(Product $product)
    {
        // Hapus file di Cloudinary
        if ($product->image_id) {
            $this->cloudinary->uploadApi()->destroy($product->image_id);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}