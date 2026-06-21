<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class SupplierController extends Controller
{
    // 1. READ: Hanya tampilkan supplier milik user
    public function index()
    {
        $suppliers = Supplier::where('user_id', Auth::id())->latest()->get();
        return view('suppliers.index', compact('suppliers'));
    }

    // 2. STORE: Tambahkan user_id saat menyimpan
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|max:255',
            'pic_name' => 'required|max:255',
            'phone' => 'required|max:15',
            'address' => 'required',
        ]);

        $supplierCode = 'SPL-' . rand(1000, 9999);

        Supplier::create([
            'supplier_code' => $supplierCode,
            'company_name' => $request->company_name,
            'pic_name' => $request->pic_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'user_id' => Auth::id(), // Kunci data ke user yang login
        ]);

        return redirect()->back()->with('success', 'Supplier baru berhasil ditambahkan!');
    }

    // 3. DELETE: Pastikan hanya pemilik data yang bisa menghapus
    public function destroy($id)
    {
        $supplier = Supplier::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();
        
        $supplier->delete();
        return redirect()->back()->with('success', 'Supplier berhasil dihapus!');
    }
}