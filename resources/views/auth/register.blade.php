<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
    <title>Register</title>
</head>
<body>
    <div class="flex justify-center items-center h-screen font-Poppins bg-third">
        <!-- Left Section -->
        <div class="bg-primary rounded-lg md:rounded-none flex flex-col justify-center items-center w-[85%] md:w-[55%] h-[94%] md:h-screen px-8">
            <h2 class="text-xl md:text-3xl font-bold text-black mb-6">Get started</h2>
            <form method="POST" action="{{ route('register.submit') }}" class="w-full md:w-[80%] space-y-4" x-data="registerHandler()">
                @csrf

                {{-- <!-- Flash Error -->
                <div x-show="internalError" class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded-md">
                    Gagal mendaftar, periksa input Anda!
                </div> --}}

                <!-- Flash Error: Internal Modal -->
                <div x-show="{{ $errors->has('error') ? 'true' : 'false' }}" class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded-md">
                    {{ $errors->first('error') }}
                </div>

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" x-model="name"
                           class="w-full px-4 py-2 bg-primary border-2 border-black rounded-md focus:ring-2 focus:ring-fourth"
                           placeholder="Full Name" required>
                    <p x-show="nameError" class="text-red-600 text-sm mt-1" x-text="nameError"></p>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" x-model="email"
                           class="w-full px-4 py-2 bg-primary border-2 border-black rounded-md focus:ring-2 focus:ring-fourth"
                           placeholder="Email Address" required>
                    <p x-show="emailError" class="text-red-600 text-sm mt-1" x-text="emailError"></p>
                </div>

                <!-- Birth Date and Phone Number -->
                <div class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-1">
                        <label for="birth_date" class="block text-sm font-medium">Birth Date <span class="text-red-500">*</span></label>
                        <input type="date" id="birth_date" name="birth_date" x-model="birthDate"
                               class="w-full px-4 py-2 bg-primary border-2 border-black rounded-md focus:ring-2 focus:ring-fourth" required>
                        <p x-show="birthDateError" class="text-red-600 text-sm mt-1" x-text="birthDateError"></p>
                    </div>
                    <div class="flex-1">
                        <label for="phone_number" class="block text-sm font-medium">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" x-model="phoneNumber"
                               class="w-full px-4 py-2 bg-primary border-2 border-black rounded-md focus:ring-2 focus:ring-fourth"
                               placeholder="Phone Number">
                        <p x-show="phoneNumberError" class="text-red-600 text-sm mt-1" x-text="phoneNumberError"></p>
                    </div>
                </div>

                <!-- Password and Confirm Password -->
                <div class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-1">
                        <label for="password" class="block text-sm font-medium">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password" x-model="password"
                                   class="w-full px-4 py-2 bg-primary border-2 border-black rounded-md focus:ring-2 focus:ring-fourth"
                                   placeholder="Password" required>
                            <button type="button" class="absolute right-3 top-3" @click="togglePassword">
                                <svg xmlns="http://www.w3.org/2000/svg" :class="{'hidden': !showPassword}" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12m-3 0a3 3 0 110-6 3 3 0 010 6zm-2.75 1.5h4.75m1.92 0a7.003 7.003 0 01-13.92 0 7.003 7.003 0 0113.92 0z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" :class="{'hidden': showPassword}" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 11.25L8.5 9.75M4.75 11.25c-.333.667-.333 1.333 0 2m-.667.917C3.72 14.836 4.6 15 5 15h14c.4 0 1.28-.164 1.917-.833m.667-.917c.333-.667.333-1.333 0-2M14.5 9.75L13.25 11.25" />
                                </svg>
                            </button>
                        </div>
                        <p x-show="passwordError" class="text-red-600 text-sm mt-1" x-text="passwordError"></p>
                    </div>
                    <div class="flex-1">
                        <label for="password_confirmation" class="block text-sm font-medium">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" x-model="passwordConfirmation"
                               class="w-full px-4 py-2 bg-primary border-2 border-black rounded-md focus:ring-2 focus:ring-fourth"
                               placeholder="Confirm Password" required>
                        <p x-show="passwordConfirmationError" class="text-red-600 text-sm mt-1" x-text="passwordConfirmationError"></p>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="button" class="w-full h-[12%] bg-black text-white py-2 rounded-md hover:bg-gray-800" @click="submitForm">
                    Sign Up
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

    <script>
        function registerHandler() {
            return {
                name: '',
                email: '',
                birthDate: '',
                phoneNumber: '',
                password: '',
                passwordConfirmation: '',
                nameError: '',
                emailError: '',
                birthDateError: '',
                phoneNumberError: '',
                passwordError: '',
                passwordConfirmationError: '',
                internalError: false,
                showPassword: false,

                togglePassword() {
                    this.showPassword = !this.showPassword;
                },

                validateEmail(value) {
                    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return regex.test(value);
                },

                validatePassword(value) {
                    return value.length >= 8;
                },

                submitForm() {
                    this.nameError = '';
                    this.emailError = '';
                    this.birthDateError = '';
                    this.phoneNumberError = '';
                    this.passwordError = '';
                    this.passwordConfirmationError = '';
                    this.internalError = false;

                    if (this.name === '') {
                        this.nameError = 'Name tidak boleh kosong.';
                    }
                    if (this.email === '') {
                        this.emailError = 'Email tidak boleh kosong.';
                    } else if (!this.validateEmail(this.email)) {
                        this.emailError = 'Email tidak valid.';
                    } //tinggal nambahin email sudah terdaftar, tapi sesuain sama BE lagi
                    if (this.password !== this.passwordConfirmation) {
                        this.passwordConfirmationError = 'Password tidak cocok.';
                    }
                    if (this.password === '' || !this.validatePassword(this.password)) {
                        this.passwordError = 'Password harus minimal 8 karakter.';
                    }

                    if (!this.nameError && !this.emailError && !this.passwordError && !this.passwordConfirmationError) {
                        document.querySelector('form').submit();
                    }
                }
            };
        }
    </script>
</body>
</html>
