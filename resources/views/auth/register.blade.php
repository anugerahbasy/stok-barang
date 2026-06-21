<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - STOCKFLOW</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-xl w-full max-w-md">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-indigo-900 tracking-tight">Buat Akun</h2>
            <p class="text-sm text-gray-500 mt-2">Daftar user baru untuk sistem STOCKFLOW</p>
        </div>

        @if($errors->any())
            <div class="p-3 mb-4 text-sm text-red-700 bg-red-50 rounded-xl border border-red-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama Lengkap</label>
                <input type="text" name="name" required placeholder="Nama Anda" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Alamat Email</label>
                <input type="email" name="email" required placeholder="nama@email.com" 
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Password (Min. 8 Karakter)</label>
                <div class="relative">
                    <input type="password" name="password" id="passwordInput" required placeholder="••••••••" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition pr-10">
                    
                    <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-indigo-600 transition">
                        <i id="eyeIcon" class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                Mulai Mendaftar
            </button>
        </form>
        
        <div class="text-center mt-6 text-sm text-gray-500">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Login di sini</a>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>