<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Tampilkan data kategori
    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), 
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Hapus kategori
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}