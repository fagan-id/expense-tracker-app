<x-layout>
    <div class="max-w-7xl font-Poppins mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">
            {{ request('type') === 'income' ? 'Form Pemasukan' : 'Form Pengeluaran' }}
        </h2>
        <form method="POST" action="{{ route('transactions.store') }}">
            @csrf
            <input type="hidden" name="type" value="{{ request('type') }}">
            
            <div class="mb-4">
                <label class="block text-gray-700">Transaction</label>
                <input type="text" name="description" class="w-full p-2 border rounded" placeholder="Enter transaction name" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700">Category</label>
                <select name="category" class="w-full p-2 border rounded" required>
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
                <input type="number" name="amount" class="w-full p-2 border rounded" placeholder="Enter amount" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700">Date</label>
                <input type="date" name="date" class="w-full p-2 border rounded" required>
            </div>
            
            <button type="submit" class="w-full bg-fourth text-black py-2 px-4 rounded">
                {{ request('type') === 'income' ? 'Submit Pemasukan' : 'Submit Pengeluaran' }}
            </button>
        </form>
    </div>
</x-layout>
