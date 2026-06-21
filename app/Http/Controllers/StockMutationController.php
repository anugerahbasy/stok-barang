<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMutationController extends Controller
{
    // Tampilkan riwayat mutasi stok
    public function index()
    {
        $mutations = StockMutation::with('product')->latest()->get();
        $products = Product::orderBy('name')->get();
        
        return view('mutations.index', compact('mutations', 'products'));
    }

    // Simpan transaksi mutasi sekaligus update stok barang di database
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'activity_type' => 'required|in:addition,reduction,adjustment',
            'amount' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        // Menggunakan DB Transaction agar aman jika salah satu proses gagal
        DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);
            
            // Hitung efek ke stok real-time
            if ($request->activity_type === 'addition') {
                $product->increment('quantity_in_stock', $request->amount);
            } elseif ($request->activity_type === 'reduction' || $request->activity_type === 'adjustment') {
                // Opsional: beri validasi jika pengurangan melebihi stok yang ada
                $product->decrement('quantity_in_stock', $request->amount);
            }

            // Simpan log mutasi (user_id di-hardcode ke 1 karena auth dinonaktifkan sementara)
            StockMutation::create([
                'product_id' => $request->product_id,
                'user_id' => 1, 
                'activity_type' => $request->activity_type,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);
        });

        return redirect()->back()->with('success', 'Stok barang berhasil diperbarui secara aman!');
    }
}