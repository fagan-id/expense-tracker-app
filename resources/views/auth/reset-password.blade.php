<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Reset Password</title>
</head>

<body>
    <div class="flex justify-center items-center h-screen font-Poppins bg-third">
        <!-- Left Section -->
        <div class="bg-primary rounded-lg md:rounded-none flex flex-col justify-center items-center w-[85%] md:w-[55%] h-[94%] md:h-screen px-8">
            <h2 class="text-xl md:text-3xl font-bold text-black mb-6">Reset Your Password</h2>
            <form method="POST" action="{{ route('password.update') }}" class="w-full md:w-[80%] space-y-4">
                @csrf

                {{-- Session Messages --}}
                @if (session('status'))
                    <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded-md">
                        {{ session('status') }}
                    </div>
                @endif

                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 bg-primary border-2 border-black rounded-md focus:ring-2 focus:ring-fourth"
                        placeholder="Email Address" required>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password and Confirm Password -->
                <div class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-1">
                        <label for="password" class="block text-sm font-medium">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" id="password" name="password" value="{{ old('password') }}"
                                class="w-full px-4 py-2 bg-primary border-2 border-black rounded-md focus:ring-2 focus:ring-fourth"
                                placeholder="Password" required>
                        </div>
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex-1">
                        <label for="password_confirmation" class="block text-sm font-medium">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-2 bg-primary border-2 border-black rounded-md focus:ring-2 focus:ring-fourth"
                            placeholder="Confirm Password" required>
                        @error('password_confirmation')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full h-[12%] bg-black text-white py-2 rounded-md hover:bg-gray-800">
                    Submit
                </button>
            </form>
        </div>

        <!-- Right Section -->
        <div class="lbg-third w-[45%] hidden md:flex md:items-center md:justify-center">
            <div class="text-black flex flex-col gap-36">
                <div class="px-10">
                    <h3 class="text-3xl font-semibold text-[#FF6464]">Our Members are</h3>
                    <h3 class="text-3xl font-semibold">Around the World</h3>
                    <p class="text-sm mt-2 text-gray-700">Over 10,000 investors join us monthly</p>
                    <div class="flex items-center mt-4">
                        <img src="img/userGroup.png" alt="User Group" class="h-8">
                        <span class="ml-2 text-sm text-gray-700">dan lainnya</span>
                    </div>
                </div>
                <img src="img/peta.png" alt="World Map">
            </div>
        </div>
    </div>
</body>

</html>
