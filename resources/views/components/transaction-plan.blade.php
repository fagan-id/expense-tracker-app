<script>
    function budgetComponent(budgetId, initialLimit) {
        return {
            isEditing: false,
            newLimit: initialLimit,
            budgetId: budgetId,

            formatRupiah(value) {
                return new Intl.NumberFormat('id-ID').format(value);
            },

            updateLimit() {
                if (this.newLimit < 0 || this.newLimit === '') {
                    alert('Masukkan angka yang valid untuk limit bulanan.');
                    return;
                }

                // Jika Budget Belum Ada, Buat Baru (POST)
                if (!this.budgetId || this.budgetId === 'null') {
                    fetch('/budget/store', {  // Fix URL string
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ monthly_limit: this.newLimit })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Budget berhasil disimpan!');
                            this.budgetId = data.budget.id; // Simpan ID baru
                            this.isEditing = false;
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));

                // Jika Budget Sudah Ada, Update (PATCH)
                } else {
                    fetch(`/budget/update/${this.budgetId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ monthly_limit: this.newLimit })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Budget berhasil diperbarui!');
                            this.isEditing = false;
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            }
        };
    }
</script>

<x-layout>
    <div class="min-h-screen p-1 md:p-6 font-Poppins">
        <!-- Header -->
        <div class="flex flex-row justify-between items-center mb-4 md:mb-6">
            <h1 class="text-xl md:text-2xl font-bold mb-2 md:mb-0">Transaction Plan</h1>
            <div x-data="{ showDatePicker: false, monthYear: '{{ request('month_year') ? date('F Y', strtotime(request('month_year'))) : now()->format('F Y') }}' }" class="relative">
                <button @click="showDatePicker = !showDatePicker" class="bg-third text-black px-3 py-2 rounded-md">
                    <span x-text="monthYear"></span>
                </button>
                <div x-show="showDatePicker" @click.away="showDatePicker = false" class="absolute bg-white shadow-md p-2 mt-2 rounded-md z-50 right-0">
                    <form method="GET" action="{{ route('transactions') }}">
                        <input type="month" name="month_year" class="border p-2 rounded-md" @change="monthYear = new Date($event.target.value + '-01').toLocaleString('en-US', { month: 'long', year: 'numeric' }); $event.target.form.submit(); showDatePicker = false" value="{{ request('month_year', now()->format('Y-m')) }}">
                    </form>
                </div>
            </div>
        </div>
        <hr class="border-gray-300 mb-4 md:mb-6">

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 md:mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-gray-500 text-base md:text-lg">Sisa Uang Bulan ini</p>
                <p class="text-lg md:text-2xl font-semibold text-green-600">
                    Rp {{ number_format($totalBalance, 0, ',', '.') }}
                </p>
            </div>
            <div x-data="budgetComponent({{ $budget ? $budget->id : 'null' }}, {{ $budget ? $budget->monthly_limit : 0 }})"
                class="bg-yellow-100 p-4 rounded-lg shadow flex justify-between items-center {{ $isOverLimit ? 'border-red-500' : '' }}">

                <div>
                    <p class="text-gray-500 text-base md:text-lg">Batas Pengeluaran Bulan ini</p>
                    <div x-show="!isEditing">
                        <p id="limitDisplay" class="text-lg md:text-2xl font-semibold {{ $isOverLimit ? 'text-red-500' : '' }}">
                            Rp <span x-text="formatRupiah(newLimit)"></span>
                        </p>
                    </div>
                    <div x-show="isEditing" @click.away="isEditing = false">
                        <input type="number" x-model="newLimit"
                            @keydown.enter="updateLimit()"
                            class="border rounded-md px-3 py-2 bg-yellow-100 w-24 md:w-32 "
                            placeholder="Masukkan limit baru" />
                    </div>
                </div>

                <button @click="isEditing = !isEditing" class="p-2 rounded-full shadow">
                    <i class="fa fa-edit text-black" style="font-size:1.2rem"></i>
                </button>
            </div>
        </div>

        <!-- Income Transactions -->
        <div class="bg-white p-4 md:p-6 rounded-lg shadow mb-4 md:mb-6 mt-2">
            <div class="flex flex-col md:flex-row justify-between mb-4">
                <h2 class="text-lg md:text-xl font-semibold mb-2 md:mb-0">Riwayat Pemasukan</h2>
                <a href="{{ route('transactions.form', ['type' => 'income']) }}" class="bg-third text-black px-3 py-1 rounded-md flex items-center">
                    <i class="fas fa-plus mr-1"></i> Tambah Pemasukan
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[600px]">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 text-lg md:text-xl">Transaction</th>
                            <th class="py-2 text-lg md:text-xl">Category</th>
                            <th class="py-2 text-lg md:text-xl">Amount</th>
                            <th class="py-2 text-lg md:text-xl">Date</th>
                            <th class="py-2 text-lg md:text-xl">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($incomeTransactions as $transaction)
                            <tr class="border-b mb-6 text-sm md:text-base">
                                <td>{{ $transaction->description }}</td>
                                <td>{{ $transaction->category }}</td>
                                <td class="text-green-500">+Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                <td>{{ $transaction->date->format('d F Y') }}</td>
                                <td>{{ $transaction->created_at->format('H:i:s') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500">Nothing income</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="mt-4">
                {{ $incomeTransactions->links() }}
            </div>
        </div>

        <!-- Expense Transactions -->
        <div class="bg-white p-4 md:p-6 rounded-lg shadow mt-2">
            <div class="flex flex-col md:flex-row justify-between mb-4">
                <h2 class="text-lg md:text-xl font-semibold mb-2 md:mb-0">Riwayat Pengeluaran</h2>
                <a href="{{ route('transactions.form', ['type' => 'expense']) }}" class="bg-third text-black px-3 py-1 rounded-md flex items-center">
                    <i class="fas fa-plus mr-1"></i> Tambah Pengeluaran
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[600px]">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 text-lg md:text-xl">Transaction</th>
                            <th class="py-2 text-lg md:text-xl">Category</th>
                            <th class="py-2 text-lg md:text-xl">Amount</th>
                            <th class="py-2 text-lg md:text-xl">Date</th>
                            <th class="py-2 text-lg md:text-xl">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($expenseTransactions as $transaction)
                            <tr class="border-b mb-6 text-sm md:text-base">
                                <td>{{ $transaction->description }}</td>
                                <td>{{ $transaction->category }}</td>
                                <td class="text-red-500">-Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                <td>{{ $transaction->date->format('d F Y') }}</td>
                                <td>{{ $transaction->created_at->format('H:i:s') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500">Nothing expense</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="mt-4">
                {{ $expenseTransactions->links() }}
            </div>
        </div>
    </div>
</x-layout>