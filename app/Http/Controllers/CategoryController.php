<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; // Jangan lupa tambahkan ini

class CategoryController extends Controller
{
    // 1. Tampilkan hanya kategori milik user yang sedang login
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())->latest()->get();
        return view('categories.index', compact('categories'));
    }

    // 2. Simpan kategori baru dengan mengaitkannya ke user
    public function store(Request $request)
    {
        $request->validate([
            // Tambahkan user_id ke validasi unique agar user lain bisa buat nama kategori yang sama
            'name' => 'required|unique:categories,name,NULL,id,user_id,' . Auth::id() . '|max:255',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'user_id' => Auth::id(), // Kunci ke user yang login
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    // 3. Hapus kategori (pastikan user hanya menghapus miliknya sendiri)
    public function destroy($id)
    {
        $category = Category::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail(); // Akan error 404 jika user mencoba hapus data orang lain
        
        $category->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}