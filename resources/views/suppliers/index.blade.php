<x-app-layout>
    <x-slot name="title">Manajemen Supplier</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm h-fit">
            <h3 class="text-md font-bold text-gray-800 mb-4">Tambah Supplier Baru</h3>
            
            @if(session('success'))
                <div class="p-3 mb-4 text-sm text-green-700 bg-green-50 rounded-xl border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama Perusahaan / Toko</label>
                    <input type="text" name="company_name" required placeholder="PT. Sinar Jaya" 
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama PIC</label>
                    <input type="text" name="pic_name" required placeholder="Budi Santoso" 
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">No. Telepon</label>
                    <input type="text" name="phone" required placeholder="08123456789" 
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Alamat Lengkap</label>
                    <textarea name="address" required rows="3" placeholder="Jl. Jend. Sudirman No. 12" 
                              class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition"></textarea>
                </div>
                <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                    <i class="fa-solid fa-plus mr-1"></i> Simpan Supplier
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-md font-bold text-gray-800">Daftar Supplier Mitra</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-xs font-semibold text-gray-400 uppercase bg-gray-50/70">
                            <th class="px-6 py-3">Kode</th>
                            <th class="px-6 py-3">Perusahaan</th>
                            <th class="px-6 py-3">PIC / Kontak</th>
                            <th class="px-6 py-3">Alamat</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                            @forelse($suppliers as $supplier)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-500 font-mono">{{ $supplier->supplier_code }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $supplier->company_name }}</td> <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $supplier->pic_name }} <br> <span class="text-xs text-gray-400">{{ $supplier->phone }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $supplier->address }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if(auth()->user()->role === 'admin')
                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Hapus supplier ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 p-2">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada data supplier.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>