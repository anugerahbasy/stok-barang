<x-app-layout>
    <x-slot name="title">Dashboard Sistem Stok</x-slot>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Ringkasan Sistem</h1>
            <p class="text-sm text-gray-500">Pantau kondisi stok barang masuk dan keluar hari ini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase">Total Produk</span>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalProducts ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-box"></i>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase">Kategori</span>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalCategories ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-tags"></i>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase">Supplier</span>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalSuppliers ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-truck-field"></i>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase">Stok Menipis</span>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $lowStockAlert ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="text-md font-bold text-gray-800 mb-4">Sebaran Stok Per Kategori Barang</h3>
                <div class="h-64">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>

            <div class="bg-indigo-900 text-white p-6 rounded-2xl shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-bold opacity-90">Aktivitas Sistem</h3>
                    <p class="text-xs text-indigo-200 mt-1">Sistem ini membatasi mutasi hanya untuk user resmi.</p>
                </div>
                <div class="space-y-3 my-4">
                    <div class="flex items-center gap-3 text-sm bg-indigo-800/50 p-3 rounded-xl border border-indigo-700/50">
                        <i class="fa-solid fa-shield-halved text-teal-400"></i>
                        <span>Authorization Active</span>
                    </div>
                </div>
                <div class="text-xs text-indigo-300">Sistem Manajemen Stok &bull; Modern UI</div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Trik amankan variabel dengan string kosong agar VS Code HTML Linter tidak rewel merah-merah
        const rawLabels = '{{ json_encode($chartLabels ?? []) }}';
        const rawValues = '{{ json_encode($chartValues ?? []) }}';
        
        const labelsData = JSON.parse(rawLabels.replace(/&quot;/g, '"'));
        const valuesData = JSON.parse(rawValues);

        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('stockChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labelsData,
                    datasets: [{
                        label: 'Jumlah Unit Barang',
                        data: valuesData,
                        backgroundColor: 'rgba(79, 70, 229, 0.8)',
                        borderColor: 'rgb(79, 70, 229)',
                        borderWidth: 1,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
</x-app-layout>