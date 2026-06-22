<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // 1. READ: Hanya menampilkan data milik user yang sedang login
    public function index()
    {
        $products = \App\Models\Product::all();
        $categories = \App\Models\Category::all();
        $suppliers = \App\Models\Supplier::all();

    // Kirim semua variabel ke view index
    return view('products.index', compact('products', 'categories', 'suppliers'));
    }

    // 2. CREATE: Mengaitkan data baru dengan user yang sedang login
    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required',
            'name' => 'required',
            // ... validasi lainnya
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id(); // Authorization: Kunci data ke user

        Product::create($data);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    // 3. DELETE: Memastikan user hanya bisa menghapus data miliknya
    public function destroy($id)
    {
        // Authorization: Query mencari data berdasarkan ID DAN user_id pemilik
        $product = Product::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();
        
        $product->delete();
        
        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}