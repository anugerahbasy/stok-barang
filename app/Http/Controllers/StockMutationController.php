<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class StockMutationController extends Controller
{
    // 1. READ: Hanya menampilkan mutasi milik user yang sedang login
    public function index()
    {
        // Filter mutasi berdasarkan user_id yang login
        $mutations = StockMutation::where('user_id', Auth::id())
                                  ->with('product')
                                  ->latest()
                                  ->get();
        
        // Filter produk juga agar tidak bisa mutasi stok barang milik orang lain
        $products = Product::where('user_id', Auth::id())
                           ->orderBy('name')
                           ->get();
        
        return view('mutations.index', compact('mutations', 'products'));
    }

    // 2. STORE: Transaksi aman dengan user_id yang dinamis
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'activity_type' => 'required|in:addition,reduction,adjustment',
            'amount' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // Pastikan produk yang dipilih memang milik user yang login
            $product = Product::where('id', $request->product_id)
                              ->where('user_id', Auth::id())
                              ->firstOrFail();
            
            if ($request->activity_type === 'addition') {
                $product->increment('quantity_in_stock', $request->amount);
            } else {
                $product->decrement('quantity_in_stock', $request->amount);
            }

            // Simpan log mutasi dengan user_id yang sedang login
            StockMutation::create([
                'product_id' => $request->product_id,
                'user_id' => Auth::id(), // Gunakan Auth::id() bukan 1
                'activity_type' => $request->activity_type,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);
        });

        return redirect()->back()->with('success', 'Stok berhasil diperbarui!');
    }
}