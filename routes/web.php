<?php

use App\Http\Controllers\{DashboardController, CategoryController, SupplierController, ProductController, StockMutationController};
use Illuminate\Support\Facades\{Route, Auth, Hash};
use Illuminate\Http\Request;
use App\Models\User;

// Rute Publik
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', fn() => Auth::check() ? redirect('/dashboard') : view('auth.login'))->name('login');
Route::post('/login', function (Request $request) {
    $credentials = $request->validate(['email' => 'required|email', 'password' => 'required']);
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }
    return back()->withErrors(['email' => 'Email atau password salah!']);
});

Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', function (Request $request) {
    $request->validate(['name' => 'required|string|max:255', 'email' => 'required|email|unique:users', 'password' => 'required|min:8']);
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => User::count() == 0 ? 'admin' : 'user',
    ]);
    Auth::login($user);
    return redirect('/dashboard');
});

// Rute Protected (Wajib Login)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gunakan Resource untuk CRUD agar lebih efisien
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products', ProductController::class);

    Route::get('/mutations', [StockMutationController::class, 'index'])->name('mutations.index');
    Route::post('/mutations', [StockMutationController::class, 'store'])->name('mutations.store');
});