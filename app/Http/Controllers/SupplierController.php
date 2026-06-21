<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|max:255',
            'pic_name' => 'required|max:255',
            'phone' => 'required|max:15',
            'address' => 'required',
        ]);

        // Pola Unik: Membuat kode supplier otomatis (Contoh: SPL-2311)
        $supplierCode = 'SPL-' . rand(1000, 9999);

        Supplier::create([
            'supplier_code' => $supplierCode,
            'company_name' => $request->company_name,
            'pic_name' => $request->pic_name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', 'Supplier baru berhasil ditambahkan!');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->back()->with('success', 'Supplier berhasil dihapus dari sistem!');
    }
}