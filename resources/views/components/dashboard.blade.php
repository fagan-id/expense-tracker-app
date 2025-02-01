<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let ctx = document.getElementById("incomeExpenseChart").getContext("2d");
            let chartFilter = document.getElementById("chartFilter");
            let viewReportButton = document.getElementById("viewReportButton");
            let incomeExpenseChart;
    
            function fetchData(filter) {
                fetch(`/api/chart-data?filter=${filter}`)
                    .then(response => response.json())
                    .then(data => {
                        if (incomeExpenseChart) incomeExpenseChart.destroy();
    
                        const maxValue = Math.max(
                            ...data.income,
                            ...data.expense,
                            ...data.limit
                        );
    
                        incomeExpenseChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.labels,
                                datasets: [
                                    { label: 'Income', data: data.income, borderColor: 'green', backgroundColor: 'transparent', fill: false },
                                    { label: 'Expense', data: data.expense, borderColor: 'red', backgroundColor: 'transparent', fill: false },
                                    { label: 'Monthly Limit', data: data.limit, borderColor: 'yellow', borderDash: [5, 5], fill: false }
                                ]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: { beginAtZero: true, max: maxValue + maxValue * 0.1 }
                                }
                            }
                        });
                    });
            }
    
            chartFilter.addEventListener("change", function () {
                fetchData(this.value);
            });
    
            viewReportButton.addEventListener("click", function () {
                const filter = chartFilter.value;
                window.location.href = `/report?filter=${filter}`;
            });
    
            fetchData("daily");
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let ctx = document.getElementById("incomeExpenseChart").getContext("2d");
            let chartFilter = document.getElementById("chartFilter");
            let viewReportButton = document.getElementById("viewReportButton");
            let incomeExpenseChart;
    
            function fetchData(filter) {
                fetch(`/api/chart-data?filter=${filter}`)
                    .then(response => response.json())
                    .then(data => {
                        if (incomeExpenseChart) incomeExpenseChart.destroy();
    
                        const maxValue = Math.max(
                            ...data.income,
                            ...data.expense,
                            ...data.limit
                        );
    
                        incomeExpenseChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.labels,
                                datasets: [
                                    { label: 'Income', data: data.income, borderColor: 'green', backgroundColor: 'transparent', fill: false },
                                    { label: 'Expense', data: data.expense, borderColor: 'red', backgroundColor: 'transparent', fill: false },
                                    { label: 'Monthly Limit', data: data.limit, borderColor: 'yellow', borderDash: [5, 5], fill: false }
                                ]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: { beginAtZero: true, max: maxValue + maxValue * 0.1 }
                                }
                            }
                        });
                    });
            }
    
            chartFilter.addEventListener("change", function () {
                fetchData(this.value);
            });
    
            viewReportButton.addEventListener("click", function () {
                const year = new Date().getFullYear();
                const month = new Date().getMonth() + 1;
                const filter = document.getElementById("chartFilter").value;
                window.open(`/report/pdf?filter=${filter}&y=${year}&m=${month}`, "_blank");
            });

    
            fetchData("daily");
        });
    </script>

<x-layout>
    <div class="bg-gray-100 min-h-screen p-4 md:p-6 font-Poppins">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 md:mb-6 relative">
            <h1 class="text-xl md:text-2xl font-bold">Dashboard</h1>
            <div x-data="{ showDatePicker: false, monthYear: '{{ request('month_year') ? date('F Y', strtotime(request('month_year'))) : now()->format('F Y') }}' }" 
                class="absolute right-0 md:relative md:right-auto mt-0">
                <button @click="showDatePicker = !showDatePicker" class="bg-third text-black px-3 py-2 md:px-4 md:py-2 rounded-md text-sm md:text-base">
                    <span x-text="monthYear"></span>
                </button>
                <div x-show="showDatePicker" @click.away="showDatePicker = false" class="absolute bg-white shadow-md p-2 mt-2 rounded-md z-50 right-0">
                    <form method="GET" action="{{ route('dashboard') }}">
                        <input type="month" name="month_year" class="border p-2 rounded-md text-sm md:text-base" 
                            @change="monthYear = new Date($event.target.value + '-01').toLocaleString('en-US', { month: 'long', year: 'numeric' }); 
                            $event.target.form.submit(); showDatePicker = false" 
                            value="{{ request('month_year', now()->format('Y-m')) }}">
                    </form>
                </div>
            </div>
        </div>
        <hr class="border-gray-300 mb-4 md:mb-6">

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4 md:mb-6">
            <div class="bg-white p-3 md:p-4 rounded-lg shadow">
                <p class="text-gray-500 text-sm md:text-base">Total Uang Bulan Ini</p>
                <p class="text-lg md:text-2xl font-semibold">Rp {{ number_format($total_Money, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-100 p-3 md:p-4 rounded-lg shadow">
                <p class="text-gray-500 text-sm md:text-base">Pemasukan Bulan Ini</p>
                <p class="text-lg md:text-2xl font-semibold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
            <div class="bg-red-100 p-3 md:p-4 rounded-lg shadow">
                <p class="text-gray-500 text-sm md:text-base">Pengeluaran Bulan Ini</p>
                <p class="text-lg md:text-2xl font-semibold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
            </div>
            <div class="bg-yellow-100 p-3 md:p-4 rounded-lg shadow">
                <p class="text-gray-500 text-sm md:text-base">Batas Pengeluaran Bulan Ini</p>
                <p class="text-lg md:text-2xl font-semibold">Rp {{ number_format($monthlyLimit, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Income vs Expense Chart -->
        <div class="bg-white p-4 md:p-6 rounded-lg shadow mb-4 md:mb-6">
            <div class="flex flex-col md:flex-row justify-between mb-4">
                <h2 class="text-md md:text-lg font-semibold">Laporan Masuk Keluar</h2>
                <div class="flex flex-wrap gap-2 md:gap-4">
                    <select id="chartFilter" class="border rounded p-2 text-sm md:text-base">
                        <option value="daily">Harian</option>
                        <option value="weekly">Mingguan</option>
                        <option value="monthly">Bulanan</option>
                        <option value="yearly">Tahunan</option>
                    </select>
                    <button id="viewReportButton" class="bg-secondary text-white px-3 py-2 md:px-4 md:py-2 rounded-md text-sm md:text-base">
                        View Report
                    </button>
                </div>
            </div>
            <canvas id="incomeExpenseChart" class="w-full h-96 sm:h-[450px] md:h-[500px]"></canvas>
        </div>

        <!-- Transaction History -->
        <div class="bg-white p-4 md:p-6 rounded-lg shadow overflow-x-auto">
            <h2 class="text-md md:text-lg font-semibold mb-3 md:mb-4">Riwayat Transaksi</h2>
            <table class="min-w-full text-left whitespace-nowrap text-sm md:text-base">
                <thead>
                    <tr class="border-b">
                        <th class="py-2 px-3 md:py-2 md:px-4">Deskripsi</th>
                        <th class="py-2 px-3 md:py-2 md:px-4">Kategori</th>
                        <th class="py-2 px-3 md:py-2 md:px-4">Jumlah</th>
                        <th class="py-2 px-3 md:py-2 md:px-4">Tanggal</th>
                        <th class="py-2 px-3 md:py-2 md:px-4">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr class="border-b">
                            <td class="py-2 px-3 md:py-2 md:px-4">{{ $transaction->description }}</td>
                            <td class="py-2 px-3 md:py-2 md:px-4">{{ $transaction->category }}</td>
                            <td class="py-2 px-3 md:py-2 md:px-4 {{ $transaction->type == 'income' ? 'text-green-500' : 'text-red-500' }}">
                                {{ $transaction->type == 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-2 px-3 md:py-2 md:px-4">{{ $transaction->date->format('d F Y') }}</td>
                            <td class="py-2 px-3 md:py-2 md:px-4">{{ $transaction->created_at->format('H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="mt-3 md:mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</x-layout>