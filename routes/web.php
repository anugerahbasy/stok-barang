<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMutationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// ==========================================
// 1. AUTHENTICATION SYSTEM (PERBAIKAN TOTAL)
// ==========================================

// Halaman Awal otomatis redirect ke /login
Route::get('/', function () {
    return redirect()->route('login');
});

// Tampilan Halaman Login (GET)
Route::get('/login', function () {
    if (Auth::check()) return redirect('/dashboard');
    return view('auth.login');
})->name('login'); // <--- Sekarang rute GET /login resmi punya nama 'login'

// Proses Validasi Login (POST)
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    return back()->withErrors(['email' => 'Email atau password salah!']);
});

// Halaman Register (GET)
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Proses Register (POST)
Route::post('/register', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    $isFirstUser = User::count() == 0;

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $isFirstUser ? 'admin' : 'user',
    ]);

    Auth::login($user);
    return redirect('/dashboard');
});

// Fungsi Keluar (Logout)
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


// ==========================================
// 2. GRUP RUTE PROTECTED (WAJIB LOGIN)
// ==========================================
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Kategori
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // CRUD Supplier
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    // CRUD Produk
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Logistik Mutasi Stok
    Route::get('/mutations', [StockMutationController::class, 'index'])->name('mutations.index');
    Route::post('/mutations', [StockMutationController::class, 'store'])->name('mutations.store');
});