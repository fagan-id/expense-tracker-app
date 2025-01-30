<x-layout>
    
    <header class="font-Poppins mt-6 mb-2 mx-2">
         <!-- Tombol kembali ke halaman components.transactions-plan -->
         <div class="mb-4">
            <a href="{{ route('transactions') }}" class="text-blue-600 hover:underline">Kembali ke Rencana Transaksi</a>
        </div>
        <h2 class="text-2xl font-semibold mb-4">
            {{ request('type') === 'income' ? 'Form Pemasukan' : 'Form Pengeluaran' }}
        </h2>
        <img src="/img/LineHeader.png" alt="" width="30" height="20">
    </header>
    <hr class="border-gray-300 mb-4 md:mb-6">
    
    <div x-data="transactionForm()" class="max-w-7xl font-Poppins mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-normal mb-6">Isi Form Berikut ini!</h2>

        <!-- Form -->
        <form @submit.prevent="submitForm" class="px-4">
            @csrf
            <input type="hidden" name="type" x-model="form.type">

            <div class="mb-4">
                <label class="block text-gray-700">Transaction</label>
                <input type="text" x-model="form.description" class="w-full p-2 border rounded" placeholder="Enter transaction name" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Category</label>
                <select x-model="form.category" class="w-full p-2 border rounded" required>
                    <option value="Transportation">Transportation</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Utilities">Utilities</option>
                    <option value="Food & Beverages">Food & Beverages</option>
                    <option value="Health Care">Health Care</option>
                    <option value="Education">Education</option>
                    <option value="Investment">Investment</option>
                    <option value="Others">Others</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Amount</label>
                <input type="number" x-model="form.amount" class="w-full p-2 border rounded" placeholder="Enter amount" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Date</label>
                <input type="date" x-model="form.date" class="w-full p-2 border rounded" required>
            </div>

            <button type="submit" class="w-full bg-fourth text-black py-2 px-4 rounded">
                {{ request('type') === 'income' ? 'Submit Pemasukan' : 'Submit Pengeluaran' }}
            </button>
        </form>

        <!-- Pop-up Notification -->
        <div x-show="message" class="fixed bottom-4 right-4 p-4 rounded-lg shadow-lg"
            :class="success ? 'bg-third text-black' : 'bg-red-500 text-white'" x-transition>
            <p x-text="message" class="text-lg"></p>
            <button @click="message = ''" class="mt-2 bg-gray-300 text-black py-1 px-3 rounded">Close</button>
        </div>
    </div>

    <script>
        function transactionForm() {
            return {
                form: {
                    type: '{{ request("type") }}',
                    description: '',
                    category: '',
                    amount: '',
                    date: ''
                },
                message: '',
                success: false,
                
                async submitForm() {
                    try {
                        let response = await fetch("{{ route('transactions.store') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                            },
                            body: JSON.stringify(this.form)
                        });

                        let result = await response.json();

                        if (result.success) {
                            this.message = result.message;
                            this.success = true;
                            this.resetForm();
                        } else {
                            throw new Error(result.message);
                        }
                    } catch (error) {
                        this.message = error.message || "Something went wrong!";
                        this.success = false;
                    }
                },

                resetForm() {
                    this.form.description = '';
                    this.form.category = '';
                    this.form.amount = '';
                    this.form.date = '';
                }
            };
        }
    </script>
</x-layout>
