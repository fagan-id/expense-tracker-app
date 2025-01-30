<x-layout>
    <div class="min-h-screen p-6 font-Poppins">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Transaction Plan</h1>
            <div x-data="{ showDatepicker: false, monthYear: 'January 2025' }" class="relative">
                <button @click="showDatepicker = !showDatepicker" class="bg-green-200 text-green-700 px-4 py-2 rounded-md">
                    <span x-text="monthYear"></span>
                </button>
                <div x-show="showDatepicker" @click.away="showDatepicker = false" class="absolute bg-white shadow-md p-2 mt-2 rounded-md z-50" style="right: 0;">
                    <input type="month" class="border p-2 rounded-md" @change="monthYear = new Date($event.target.value + '-01').toLocaleString('en-US', { month: 'long', year: 'numeric' }); showDatepicker = false">
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-gray-500">Sisa Uang Bulan ini</p>
                <p class="text-2xl font-semibold text-green-600">
                    Rp {{ number_format($totalBalance, 0, ',', '.') }}
                </p>
            </div>
            <div x-data="budgetComponent({{ $budget->id ?? 'null' }}, {{ $budget->monthly_limit ?? 0 }})"
                class="bg-yellow-100 p-4 rounded-lg shadow flex justify-between items-center {{ $isOverLimit ? 'border-red-500' : '' }}">

                <div>
                    <p class="text-gray-500">Batas Pengeluaran Bulan ini</p>
                    <div x-show="!isEditing">
                        <p id="limitDisplay" class="text-2xl font-semibold {{ $isOverLimit ? 'text-red-500' : '' }}">
                            Rp <span x-text="formatRupiah(newLimit)"></span>
                        </p>
                    </div>
                    <div x-show="isEditing" @click.away="isEditing = false">
                        <input type="number" x-model="newLimit"
                            @keydown.enter="updateLimit()"
                            class="border rounded-md px-3 py-2 bg-yellow-100 w-32"
                            placeholder="Masukkan limit baru" />
                    </div>
                </div>

                <button @click="isEditing = !isEditing" class="p-2 rounded-full shadow">
                    <i class="fa fa-edit text-black" style="font-size:1.2rem"></i>
                </button>
            </div>
        </div>

        <!-- Income Transactions -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <div class="flex justify-between mb-4">
                <h2 class="text-lg font-semibold">Riwayat Pemasukan</h2>
                <div class="flex gap-2">
                    <a href="{{ route('transactions.form', ['type' => 'income']) }}" class="bg-green-200 text-green-700 px-3 py-1 rounded-md flex items-center">
                        <i class="fas fa-plus mr-1"></i> Tambah Pemasukan
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[600px]">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Transaction</th>
                            <th class="py-2">Category</th>
                            <th class="py-2">Amount</th>
                            <th class="py-2">Date</th>
                            <th class="py-2">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($incomeTransactions as $transaction)
                        <tr class="border-b">
                            <td>{{ $transaction->description }}</td>
                            <td>{{ $transaction->category }}</td>
                            <td class="text-green-500">+Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                            <td>{{ $transaction->date->format('d F Y') }}</td>
                            <td>{{ $transaction->created_at->format('H:i:s') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Expense Transactions -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between mb-4">
                <h2 class="text-lg font-semibold">Riwayat Pengeluaran</h2>
                <div class="flex gap-2">
                    <a href="{{ route('transactions.form', ['type' => 'expense']) }}" class="bg-green-200 text-green-700 px-3 py-1 rounded-md flex items-center">
                        <i class="fas fa-plus mr-1"></i> Tambah Pengeluaran
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[600px]">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Transaction</th>
                            <th class="py-2">Category</th>
                            <th class="py-2">Amount</th>
                            <th class="py-2">Date</th>
                            <th class="py-2">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenseTransactions as $transaction)
                        <tr class="border-b">
                            <td>{{ $transaction->description }}</td>
                            <td>{{ $transaction->category }}</td>
                            <td class="text-red-500">-Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                            <td>{{ $transaction->date->format('d F Y') }}</td>
                            <td>{{ $transaction->time }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
                        fetch(`/budget/store`, {
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
</x-layout>
