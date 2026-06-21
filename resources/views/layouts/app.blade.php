<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Manajemen Stok' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans text-gray-900" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen overflow-hidden">
        
        <div class="fixed inset-y-0 left-0 z-20 flex flex-col bg-slate-900 text-white transition-all duration-300 ease-in-out"
             :class="sidebarOpen ? 'w-64' : 'w-20'">
            
            <div class="flex items-center h-16 px-4 bg-slate-950 border-b border-slate-800"
                 :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                <div class="flex items-center gap-3" x-show="sidebarOpen" x-transition>
                    <i class="fa-solid fa-boxes-stacked text-indigo-400 text-xl"></i>
                    <span class="font-bold text-lg tracking-wider">STOCKFLOW</span>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white focus:outline-none">
                    <i class="fa-solid" :class="sidebarOpen ? 'fa-angle-left' : 'fa-bars'"></i>
                </button>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <a href="/dashboard" class="flex items-center px-3 py-3 text-gray-300 hover:bg-slate-800 hover:text-white rounded-lg transition group">
                    <i class="fa-solid fa-chart-pie text-lg min-w-[24px] text-indigo-400"></i>
                    <span class="ml-3 font-medium text-sm transition-opacity duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none absolute'">Dashboard</span>
                </a>

                <div class="pt-4 pb-2 border-t border-slate-800" x-show="sidebarOpen">
                    <span class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Master Data</span>
                </div>

                <a href="/categories" class="flex items-center px-3 py-3 text-gray-300 hover:bg-slate-800 hover:text-white rounded-lg transition group">
                    <i class="fa-solid fa-tags text-lg min-w-[24px]"></i>
                    <span class="ml-3 font-medium text-sm" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none absolute'">Kategori</span>
                </a>

                <a href="/suppliers" class="flex items-center px-3 py-3 text-gray-300 hover:bg-slate-800 hover:text-white rounded-lg transition group">
                    <i class="fa-solid fa-truck-field text-lg min-w-[24px]"></i>
                    <span class="ml-3 font-medium text-sm" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none absolute'">Supplier</span>
                </a>

                <a href="/products" class="flex items-center px-3 py-3 text-gray-300 hover:bg-slate-800 hover:text-white rounded-lg transition group">
                    <i class="fa-solid fa-box text-lg min-w-[24px]"></i>
                    <span class="ml-3 font-medium text-sm" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none absolute'">Produk Barang</span>
                </a>

                <div class="pt-4 pb-2 border-t border-slate-800" x-show="sidebarOpen">
                    <span class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Logistik</span>
                </div>

                <a href="/mutations" class="flex items-center px-3 py-3 text-gray-300 hover:bg-slate-800 hover:text-white rounded-lg transition group">
                    <i class="fa-solid fa-right-left text-lg min-w-[24px]"></i>
                    <span class="ml-3 font-medium text-sm" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none absolute'">Mutasi Stok</span>
                </a>
            </nav>
        </div>

        <div class="flex flex-col flex-1 h-screen overflow-hidden transition-all duration-300 ease-in-out"
             :class="sidebarOpen ? 'ml-64' : 'ml-20'">
            
            <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200 shrink-0">
                <div class="text-sm font-medium text-gray-500">
                    Sistem Manajemen Stok &bull; <span class="text-indigo-600 font-semibold">UAS PW 1</span>
                </div>
                
                <div class="relative" x-data="{ userMenuOpen: false }">
                    <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 focus:outline-none py-1">
                        <div class="w-9 h-9 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name ?? 'Ad', 0, 2)) }}
                        </div>
                        <span class="text-sm font-semibold text-gray-700 hidden md:inline">{{ Auth::user()->name ?? 'Administrator' }}</span>
                        <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                    </button>
                    
                    <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
                         class="absolute right-0 mt-2 w-52 bg-white border border-gray-200 rounded-lg shadow-xl py-1 z-30"
                         x-transition style="display: none;">
                         
                        <div class="px-4 py-2.5 border-b border-gray-100 bg-slate-50 rounded-t-lg">
                            <p class="text-xs font-semibold text-gray-700 truncate">{{ Auth::user()->name ?? 'User' }}</p>
                            <span class="inline-block mt-1 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider
                                {{ (Auth::user()->role ?? 'user') === 'admin' ? 'bg-purple-100 text-purple-700 border border-purple-200' : 'bg-blue-100 text-blue-700 border border-blue-200' }}">
                                {{ Auth::user()->role ?? 'user' }} Mode
                            </span>
                        </div>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition flex items-center gap-2 mt-1">
                                <i class="fa-solid fa-right-from-bracket"></i> Keluar Sistem
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

</body>
</html>

