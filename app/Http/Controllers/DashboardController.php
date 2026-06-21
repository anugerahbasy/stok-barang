<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\StockMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data statistik ringkasan
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        
        // Alert Stok Menipis (Di bawah threshold)
        $lowStockAlert = Product::whereRaw('quantity_in_stock <= alert_threshold')->count();

        // 2. Data Grafik: Jumlah stok per kategori (Anti-AI Pattern: Menggunakan Query Agregasi DB)
        $categoryStockData = Product::join('categories', 'products::category_id', '=', 'categories.id')
            ->select('categories.name as category_name', DB::raw('SUM(products.quantity_in_stock) as total_stock'))
            ->groupBy('categories.name')
            ->get();

        // Pecah data untuk kebutuhan Chart.js
        $chartLabels = $categoryStockData->pluck('category_name');
        $chartValues = $categoryStockData->pluck('total_stock');

        return view('dashboard', compact(
            'totalProducts', 
            'totalCategories', 
            'totalSuppliers', 
            'lowStockAlert',
            'chartLabels',
            'chartValues'
        ));
    }
}