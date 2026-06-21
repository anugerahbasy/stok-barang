<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Hitung Statistik Dasar
        $totalProducts = Product::where('user_id', $userId)->count();
        $totalCategories = Category::where('user_id', $userId)->count();
        $totalSuppliers = Supplier::where('user_id', $userId)->count();
        $lowStock = Product::where('user_id', $userId)
                           ->whereColumn('quantity_in_stock', '<=', 'alert_threshold')
                           ->count();

        // 2. Data Grafik: Filter berdasarkan user_id terlebih dahulu
        $categoryStockData = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.user_id', $userId) // <--- PENTING: Filter user_id
            ->select('categories.name as category_name', DB::raw('SUM(products.quantity_in_stock) as total_stock'))
            ->groupBy('categories.name')
            ->get();

        $chartLabels = $categoryStockData->pluck('category_name');
        $chartValues = $categoryStockData->pluck('total_stock');

        // 3. Kirim ke View
        return view('dashboard', compact(
            'totalProducts', 
            'totalCategories', 
            'totalSuppliers', 
            'lowStock',
            'chartLabels',
            'chartValues'
        ));
    }
}