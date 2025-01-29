<x-layout>
    <div class="bg-gray-100 min-h-screen p-6 font-Poppins">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <div x-data="{ showDatePicker: false, monthYear: '{{ now()->format('F Y') }}' }" class="relative">
                <button @click="showDatePicker = !showDatePicker" class="bg-green-200 text-green-700 px-4 py-2 rounded-md">
                    <span x-text="monthYear"></span>
                </button>
                <div x-show="showDatePicker" @click.away="showDatePicker = false" class="absolute bg-white shadow-md p-2 mt-2 rounded-md z-50 right-0">
                    <input type="month" class="border p-2 rounded-md" @change="monthYear = new Date($event.target.value + '-01').toLocaleString('en-US', { month: 'long', year: 'numeric' }); showDatepicker = false">
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-gray-500">Total Uang Bulan Ini</p>
                <p class="text-2xl font-semibold">Rp {{ number_format($total_Money, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-lg shadow">
                <p class="text-gray-500">Pemasukan Bulan Ini</p>
                <p class="text-2xl font-semibold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
            <div class="bg-red-100 p-4 rounded-lg shadow">
                <p class="text-gray-500">Pengeluaran Bulan Ini</p>
                <p class="text-2xl font-semibold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-lg shadow">
                <p class="text-gray-500">Batas Pengeluaran Bulan Ini</p>
                <p class="text-2xl font-semibold">Rp {{ number_format($monthlyLimit, 0, ',', '.') }}</p>
            </div>
        </div>


        <!-- Income vs Expense Chart -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <div class="flex justify-between mb-4">
                <h2 class="text-lg font-semibold">Laporan Masuk Keluar</h2>
                <select id="chartFilter" class="border rounded p-2">
                    <option value="daily">Harian</option>
                    <option value="weekly">Mingguan</option>
                    <option value="monthly">Bulanan</option>
                    <option value="yearly">Tahunan</option>
                </select>
            </div>
            <canvas id="incomeExpenseChart"></canvas>
        </div>

        <!-- Transaction History -->
        <div class="bg-white p-6 rounded-lg shadow overflow-x-auto">
            <h2 class="text-lg font-semibold mb-4">Riwayat Transaksi</h2>
            <table class="min-w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="border-b">
                        <th class="py-2 px-4">Deskripsi</th>
                        <th class="py-2 px-4">Kategori</th>
                        <th class="py-2 px-4">Jumlah</th>
                        <th class="py-2 px-4">Tanggal</th>
                        <th class="py-2 px-4">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $transaction->description }}</td>
                            <td class="py-2 px-4">{{ $transaction->category }}</td>
                            <td class="py-2 px-4 {{ $transaction->type == 'income' ? 'text-green-500' : 'text-red-500' }}">
                                {{ $transaction->type == 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-2 px-4">{{ $transaction->date->format('d F Y') }}</td>
                            <td class="py-2 px-4">{{ $transaction->time }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let ctx = document.getElementById("incomeExpenseChart").getContext("2d");
            let chartFilter = document.getElementById("chartFilter");
            let incomeExpenseChart;
    
            function fetchData(filter) {
                fetch(`/api/chart-data?filter=${filter}`)
                    .then(response => response.json())
                    .then(data => {
                        if (incomeExpenseChart) incomeExpenseChart.destroy();
                        incomeExpenseChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.labels,
                                datasets: [
                                    {
                                        label: 'Income',
                                        data: data.income,
                                        borderColor: 'green',
                                        fill: false
                                    },
                                    {
                                        label: 'Expense',
                                        data: data.expense,
                                        borderColor: 'red',
                                        fill: false
                                    },
                                    {
                                        label: 'Monthly Limit',
                                        data: data.limit,
                                        borderColor: 'yellow',
                                        borderDash: [5, 5],
                                        fill: false
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
            }
    
            chartFilter.addEventListener("change", function() {
                fetchData(this.value);
            });
    
            fetchData("daily");
        });
    </script>
</x-layout>

