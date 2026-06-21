<x-app-layout>
    <x-slot name="title">Dashboard Sistem Stok</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Ringkasan Sistem</h1>
            <p class="text-sm text-gray-500">Pantau kondisi stok barang masuk dan keluar hari ini.</p>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Produk</span>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalProducts ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-box"></i>
                </div>
            </div>
            
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kategori</span>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalCategories ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-tags"></i>
                </div>
            </div>
            
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Supplier</span>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalSuppliers ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-truck"></i>
                </div>
            </div>
            
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Stok Menipis</span>
                    <h3 class="text-2xl font-bold text-red-600 mt-1">{{ $lowStockAlert ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
        </div>

        <!-- Grafik Utama & Aktivitas Sistem -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="text-md font-bold text-gray-800 mb-4">Sebaran Stok Per Kategori Barang</h3>
                <div class="h-64 relative">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>

            <div class="bg-gradient-to-br from-indigo-900 to-indigo-800 text-white p-6 rounded-2xl shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-bold opacity-90">Aktivitas Sistem</h3>
                    <p class="text-xs text-indigo-200 mt-1">Sistem ini membatasi mutasi hanya untuk user resmi.</p>
                </div>
                
                <div class="space-y-3 my-4">
                    <div class="flex items-center gap-3 text-sm bg-indigo-800/50 p-3 rounded-xl border border-indigo-700/50">
                        <i class="fa-solid fa-shield-halved text-teal-400"></i>
                        <span>Authorization Active</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm bg-indigo-800/50 p-3 rounded-xl border border-indigo-700/50">
                        <i class="fa-solid fa-clock text-teal-400"></i>
                        <span>Real-time Monitoring</span>
                    </div>
                </div>
                
                <div class="text-xs text-indigo-300 border-t border-indigo-700/50 pt-3 mt-2">
                    Sistem Manajemen Stok &bull; Modern UI
                </div>
            </div>
        </div>

        <!-- Grafik Batang & Donat -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="text-md font-bold text-gray-800 mb-4">Sebaran Stok Per Kategori</h3>
                <div class="h-64 relative">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="text-md font-bold text-gray-800 mb-4">Persentase Stok</h3>
                <div class="h-64 relative">
                    <canvas id="doughnutChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Tunggu hingga DOM dan semua resource siap
        document.addEventListener('DOMContentLoaded', function() {
            // Data contoh untuk testing (ganti dengan data dari backend)
            const labelsData = ['Elektronik', 'Furniture', 'Pakaian', 'Makanan', 'Otomotif'];
            const valuesData = [120, 85, 95, 60, 45];
            
            // Warna untuk grafik
            const colors = [
                'rgba(79, 70, 229, 0.8)',
                'rgba(16, 185, 129, 0.8)', 
                'rgba(245, 158, 11, 0.8)',
                'rgba(239, 68, 68, 0.8)',
                'rgba(139, 92, 246, 0.8)'
            ];

            const borderColors = colors.map(c => c.replace('0.8', '1'));

            try {
                // 1. Grafik Line (Stock Chart)
                const stockCtx = document.getElementById('stockChart');
                if (stockCtx) {
                    new Chart(stockCtx.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: labelsData,
                            datasets: [{
                                label: 'Jumlah Stok',
                                data: valuesData,
                                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                borderColor: 'rgba(79, 70, 229, 1)',
                                borderWidth: 3,
                                tension: 0.3,
                                fill: true,
                                pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 5
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,0.05)'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }

                // 2. Grafik Bar
                const barCtx = document.getElementById('barChart');
                if (barCtx) {
                    new Chart(barCtx.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: labelsData,
                            datasets: [{
                                label: 'Stok',
                                data: valuesData,
                                backgroundColor: colors,
                                borderColor: borderColors,
                                borderWidth: 1,
                                borderRadius: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,0.05)'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }

                // 3. Grafik Donut
                const doughnutCtx = document.getElementById('doughnutChart');
                if (doughnutCtx) {
                    new Chart(doughnutCtx.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: labelsData,
                            datasets: [{
                                data: valuesData,
                                backgroundColor: colors,
                                borderColor: '#ffffff',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 10,
                                        usePointStyle: true,
                                        pointStyle: 'circle'
                                    }
                                }
                            },
                            cutout: '65%'
                        }
                    });
                }

            } catch (error) {
                console.error('Error creating charts:', error);
            }
        });

        // Fallback jika DOMContentLoaded sudah terlewat
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            // Trigger event jika sudah siap
            document.dispatchEvent(new Event('DOMContentLoaded'));
        }
    </script>
</x-app-layout>