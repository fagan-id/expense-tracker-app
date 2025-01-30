<x-layout>
    <div class="min-h-screen p-1 md:p-6 font-Poppins">
        {{-- header --}}
        <div class="flex flex-row justify-between items-center mb-4 md:mb-6">
            <h1 class="text-xl md:text-2xl font-bold mb-2 md:mb-0">Settings</h1>
        </div>
        <hr class="border-gray-300 mb-4 md:mb-6">
        {{-- main info --}}
        <div class="mx-auto my-10 rounded-xl">
            <!-- User Profile -->
            <div class="bg-white rounded-lg shadow-lg">
                <div class="bg-primary w-full p-6 flex items-center rounded-t-lg justify-between">
                    <div class="flex items-center space-x-4">
                        <img src="https://i.pravatar.cc/80" alt="Profile" class="w-16 h-16 rounded-full">
                        <div>
                            <h2 class="text-lg font-semibold">{{ $user->name }}</h2>
                            <p class="text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="py-6 px-8 space-y-4">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Birth Date</h3>
                        <p class="text-gray-800">{{ $user->birth_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Phone Number</h3>
                        <p class="text-gray-800">{{ $user->phone_number }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Total Income</h3>
                        <p class="text-green-600 font-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Total Expense</h3>
                        <p class="text-red-600 font-bold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mt-10 p-6 bg-white shadow-lg rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Help ?</h2>
                <div class="space-y-4">
                    @foreach ($faqs as $question => $answer)
                        <div class="faq-item rounded-lg ">
                            <button class="flex justify-between items-center w-full text-left font-medium text-gray-800 p-4 rounded-lg bg-gray-100 transition-all duration-300 faq-toggle">
                                <span>{{ $question }}</span>
                                <span class="faq-arrow ">&rsaquo;</span>
                            </button>
                            @if ($answer)
                                <p class="mt-2 text-gray-600 hidden p-4  bg-gray-100 rounded-b-lg answer-content">{{ $answer }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.faq-toggle').forEach(button => {
            button.addEventListener('click', () => {
                let answer = button.nextElementSibling;
                let container = button.parentElement;

                document.querySelectorAll('.faq-item').forEach(item => {
                    if (item !== container) {
                        item.classList.remove('border-secondary', 'border-2', 'bg-gray-200');
                        item.querySelector('.answer-content')?.classList.add('hidden');
                        item.querySelector('.faq-arrow')?.classList.remove('rotate-90');
                    }
                });

                // Toggle FAQ saat ini
                let isOpen = answer.classList.contains('hidden');

                if (isOpen) {
                    answer.classList.remove('hidden');
                    container.classList.add('border-secondary', 'border-2', 'bg-gray-200');
                } else {
                    answer.classList.add('hidden');
                    container.classList.remove('border-secondary', 'border-2', 'bg-gray-200');
                }

                let arrow = button.querySelector('.faq-arrow');
                arrow.classList.toggle('rotate-90');
            });
        });
    </script>
</x-layout>
