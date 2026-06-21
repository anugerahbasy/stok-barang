<x-app-layout>
    <x-slot name="title">Logistik Mutasi Stok</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm h-fit">
            <h3 class="text-md font-bold text-gray-800 mb-4">Input Aktivitas Stok</h3>
            
            @if(session('success'))
                <div class="p-3 mb-4 text-sm text-green-700 bg-green-50 rounded-xl border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('mutations.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Pilih Produk Barang</label>
                    <select name="product_id" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($products as $prod)
                            <option value="{{ $prod->id }}">{{ $prod->name }} (Sisa: {{ $prod->quantity_in_stock }} Pcs)</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Jenis Aktivitas</label>
                    <select name="activity_type" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                        <option value="addition">Stok Masuk (+) </option>
                        <option value="reduction">Stok Keluar (-)</option>
                        <option value="adjustment">Penyesuaian / Rusak (-)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Jumlah (Qty)</label>
                    <input type="number" name="amount" min="1" required placeholder="0" 
                           class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Keterangan / Alasan</label>
                    <textarea name="description" placeholder="Contoh: Restock bulanan / Barang cacat pabrik" rows="2"
                              class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition"></textarea>
                </div>

                <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                    <i class="fa-solid fa-right-left mr-1"></i> Proses Transaksi
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-md font-bold text-gray-800">Log Riwayat Aliran Barang</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-xs font-semibold text-gray-400 uppercase bg-gray-50/70">
                            <th class="px-6 py-3">Waktu</th>
                            <th class="px-6 py-3">Nama Barang</th>
                            <th class="px-6 py-3 text-center">Tipe</th>
                            <th class="px-6 py-3 text-right">Jumlah</th>
                            <th class="px-6 py-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($mutations as $mut)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 text-xs text-gray-400 font-medium">{{ $mut->created_at->format('d/m H:i') }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $mut->product->name }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($mut->activity_type === 'addition')
                                        <span class="px-2 py-0.5 text-[11px] font-bold rounded bg-green-50 text-green-700 uppercase">Masuk</span>
                                    @elseif($mut->activity_type === 'reduction')
                                        <span class="px-2 py-0.5 text-[11px] font-bold rounded bg-red-50 text-red-700 uppercase">Keluar</span>
                                    @else
                                        <span class="px-2 py-0.5 text-[11px] font-bold rounded bg-amber-50 text-amber-700 uppercase">Adjust</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right font-bold {{ $mut->activity_type === 'addition' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $mut->activity_type === 'addition' ? '+' : '-' }}{{ $mut->amount }} Pcs
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500 max-w-[150px] truncate">{{ $mut->description ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada aktivitas aliran barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>