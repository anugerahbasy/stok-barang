<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Tampilkan semua produk beserta relasinya
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->latest()->get();
        $categories = Category::all();
        $suppliers = Supplier::all();
        
        return view('products.index', compact('products', 'categories', 'suppliers'));
    }

    // Simpan produk baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'sku' => 'required|unique:products,sku|max:50',
            'name' => 'required|max:255',
            'alert_threshold' => 'required|integer|min:1',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|gt:cost_price', // Validasi: Harga jual harus di atas harga modal
        ]);

        Product::create($request->all());

        return redirect()->back()->with('success', 'Produk baru berhasil didaftarkan!');
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}