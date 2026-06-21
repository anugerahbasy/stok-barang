<x-app-layout>
    <x-slot name="title">Manajemen Produk Barang</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm h-fit">
            <h3 class="text-md font-bold text-gray-800 mb-4">Tambah Produk Baru</h3>
            
            @if(session('success'))
                <div class="p-3 mb-4 text-sm text-green-700 bg-green-50 rounded-xl border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Kode SKU / Barcode</label>
                    <input type="text" name="sku" required placeholder="Contoh: BRG-001" 
                           class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Barang</label>
                    <input type="text" name="name" required placeholder="Contoh: Lampu LED Philips" 
                           class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Kategori</label>
                        <select name="category_id" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                            <option value="">-- Tanpa Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Supplier</label>
                        <select name="supplier_id" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                            <option value="">-- Pilih --</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Harga Modal</label>
                        <input type="number" name="cost_price" required placeholder="Rp" 
                               class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Harga Jual</label>
                        <input type="number" name="selling_price" required placeholder="Rp" 
                               class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Batas Minimal Stok (Alert)</label>
                    <input type="number" name="alert_threshold" value="5" required 
                           class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                    <p class="text-[10px] text-gray-400 mt-1">Jika stok di bawah angka ini, indikator dashboard akan berwarna merah.</p>
                </div>

                <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                    <i class="fa-solid fa-plus mr-1"></i> Simpan Produk
                </button>
            </form>
        </div>

        

        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-md font-bold text-gray-800">Daftar Produk Gudang</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-xs font-semibold text-gray-400 uppercase bg-gray-50/70">
                            <th class="px-6 py-3">SKU & Barang</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Stok</th>
                                            <th class="px-6 py-3">Harga (Modal/Jual)</th>
                                            <th class="px-6 py-3 w-16 text-center">Aksi</th>
                        <tbody>
                    @fosrelse($products as $prod)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-semibold">{{ $prod->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <span class="px-2 py-1 bg-indigo-50 text-indigo-700 text-xs font-medium rounded-md">
                                    {{ $prod->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $prod->supplier->name ?? 'Tanpa Supplier' }}</td>
                            <td class="px-6 py-4 text-sm font-bold {{ $prod->stock < 5 ? 'text-red-600 bg-red-50' : 'text-gray-700' }}">
                                {{ $prod->stock }} Pcs
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('products.destroy', $prod->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-400 font-medium bg-gray-100 px-2 py-1 rounded-md">View Only</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400">Belum ada data produk barang.</td>
                        </tr>
                    @endforelse
                </tbody>
        </div>

    </div>
</x-app-layout>