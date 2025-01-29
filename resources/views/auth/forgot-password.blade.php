<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body>
    <div class="flex justify-center items-center h-screen font-Poppins bg-third">
        <!-- Left Side -->
        <div
            class="bg-primary rounded-lg md:rounded-none flex flex-col justify-center items-center w-[85%] md:w-[55%] h-[80%] md:h-screen px-8">
            <h1 class="text-xl md:text-2xl font-bold text-black mb-6">Reset Your Password !</h1>
            <form action={{ route('password.request') }} method="POST" class="w-full md:w-[80%] space-y-4">
                @csrf

                {{-- Session Messages --}}
                @if (session('status'))
                    <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded-md">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Email -->
                <div>
                    <label for="email" class="block text-black mb-2">Email</label>
                    <input type="email" name="email" id="email" x-model="email"
                        class="w-full px-4 py-2 bg-primary border-2 border-black rounded-md focus:ring-2 focus:ring-fourth"
                        required />
                    @error('email')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <button type="submit" class="w-full py-2 bg-fourth text-white font-bold rounded-md hover:bg-green-700"
                    @click.prevent="submitForm">
                    Submit
                </button>

                <p class="text-center text-sm mt-4 text-gray-500">
                    <a href="{{ route('login') }}" class="text-fourth font-bold hover:underline">Back?</a>
                </p>
            </form>
        </div>

        <!-- Right Side -->
        <div class="bg-third w-[45%] hidden md:flex md:items-center md:justify-center">
            <div class="text-black flex flex-col gap-36">
                <div class="px-10">
                    <h1 class="text-3xl font-bold">Permudah mengatur keuangan anda! <span class="text-secondary">dengan
                            Aturin</span></h1>
                    <p class="mt-4">Mari segera bergabung dengan kami!</p>
                </div>
                <div class="mt-8">
                    <img src="/img/peta.png" alt="World Map">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
