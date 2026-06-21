<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - STOCKFLOW</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-xl w-full max-w-md">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-indigo-900 tracking-tight">STOCKFLOW</h2>
            <p class="text-sm text-gray-500 mt-2">Masuk untuk mengelola stok barang </p>
        </div>

        @if($errors->any())
            <div class="p-3 mb-4 text-sm text-red-700 bg-red-50 rounded-xl border border-red-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Alamat Email</label>
                <input type="email" name="email" required placeholder="nama@email.com" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Password</label>
                <input type="password" name="password" required placeholder="••••••••" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
            </div>
            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                Masuk Sistem
            </button>
        </form>
        
        <div class="text-center mt-6 text-sm text-gray-500">
            Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Daftar di sini</a>
        </div>
    </div>
</body>
</html>