<x-layout>
    <header class="font-Poppins my-10">
        <h2 class="text-2xl font-semibold mb-4">
            {{ request('type') === 'income' ? 'Form Pemasukan' : 'Form Pengeluaran' }}
        </h2>
        <img src="/img/LineHeader.png" alt="" width="30" height="20">
    </header>
    
    <div class="max-w-7xl font-Poppins mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-normal mb-6">
            Isi Form Berikut ini!
        </h2>
        <form method="POST" action="{{ route('transactions.store') }}" class="px-4">
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

    <!-- Modal -->
    <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="flex flex-col justify-center bg-white p-8 rounded-lg shadow-lg w-1/3">
            <h2 class="text-3xl font-semibold mb-4">Success</h2>
            <p id="modalMessage" class="text-lg"></p>
            <button onclick="closeModal()" class="mt-4 bg-blue-500 text-white py-2 px-6 rounded">Close</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('message'))
                document.getElementById('modalMessage').innerText = "{{ session('message') }}";
                document.getElementById('successModal').classList.remove('hidden');
            @endif
        });

        function closeModal() {
            document.getElementById('successModal').classList.add('hidden');
        }
    </script>
</x-layout>
