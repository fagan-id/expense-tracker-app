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
        <div class="bg-primary rounded-lg md:rounded-none flex flex-col justify-center items-center w-[85%] md:w-[55%] h-[80%] md:h-screen px-8">
            <h1 class="text-xl md:text-2xl font-bold text-black mb-6">Hi, Selamat datang kembali!</h1>
            <form action="{{ route('login.submit') }}" method="POST" class="w-full md:w-[80%] space-y-4" x-data="formHandler()">
                @csrf

                {{-- <!-- Flash Error: Internal Modal -->
                <div x-show="internalError" class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded-md">
                    Gagal login, coba lagi!
                </div> --}}

                <!-- Flash Error: Internal Modal -->
                <div x-show="{{ $errors->has('error') ? 'true' : 'false' }}" class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded-md">
                    {{ $errors->first('error') }}
                </div>

                <!-- Username or Email -->
                <div>
                    <label for="identifier" class="block text-black mb-2">Email or Username</label>
                    <input type="text" name="identifier" id="identifier" x-model="identifier"
                        class="w-full px-4 py-2 bg-primary border-2 border-black rounded-md focus:ring-2 focus:ring-fourth"
                        required />
                    <p x-show="identifierError" class="text-red-600 text-sm mt-1" x-text="identifierError"></p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-black mb-2">Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" id="password"
                            x-model="password"
                            class="w-full px-4 py-2 bg-primary border-2 border-black rounded-md focus:ring-2 focus:ring-fourth"
                            required />
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
                    <a href="#" class="text-sm text-fourth font-bold hover:underline mt-1 inline-block">Forgot Password?</a>
                </div>

                <button type="submit" class="w-full py-2 bg-fourth text-white font-bold rounded-md hover:bg-green-700" @click.prevent="submitForm">
                    Sign In
                </button>

                <div class="flex items-center justify-center my-4">
                    <div class="border-t w-[37%] border-gray-500"></div>
                    <span class="text-gray-500 mx-2">Or sign in with</span>
                    <div class="border-t w-[37%] border-gray-500"></div>
                </div>

                <button type="button" class="flex flex-row justify-center gap-3 w-full py-2 border border-black text-black font-bold rounded-md hover:bg-gray-50">
                    <p>Sign In with</p>
                    <img src="img/google.png" alt="Google" width="25">
                </button>

                <p class="text-center text-sm mt-4 text-gray-500">You don’t Have an Account?
                    <a href="{{ route('register') }}" class="text-fourth font-bold hover:underline">Sign Up</a>
                </p>
            </form>
        </div>

        <!-- Right Side -->
        <div class="bg-third w-[45%] hidden md:flex md:items-center md:justify-center">
            <div class="text-black flex flex-col gap-36">
                <div class="px-10">
                    <h1 class="text-3xl font-bold">Permudah mengatur keuangan anda! <span class="text-secondary">dengan Aturin</span></h1>
                    <p class="mt-4">Mari segera bergabung dengan kami!</p>
                </div>
                <div class="mt-8">
                    <img src="/img/peta.png" alt="World Map">
                </div>
            </div>
        </div>
    </div>

    <script>
        function formHandler() {
            return {
                identifier: '',
                password: '',
                identifierError: '',
                passwordError: '',
                internalError: false,
                showPassword: false,

                togglePassword() {
                    this.showPassword = !this.showPassword;
                },

                validateIdentifier(value) {
                    const regex = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$|^[a-zA-Z0-9_-]{3,16}$/;
                    return regex.test(value);
                },

                validatePassword(value) { //tergantung dari BE nanti gimana
                    const regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;
                    return regex.test(value);
                },

                submitForm() {
                    this.identifierError = '';
                    this.passwordError = '';
                    this.internalError = false;

                    if (this.identifier === '') {
                        this.identifierError = 'Email or username tidak boleh kosong.';
                        return;
                    }

                    if (!this.validateIdentifier(this.identifier)) {
                        this.identifierError = 'Email or username tidak valid.';
                        return;
                    }

                    if (this.password === '') {
                        this.passwordError = 'Password tidak boleh kosong.';
                        return;
                    }

                    if (!this.validatePassword(this.password)) {
                        this.passwordError = 'Password harus terdiri dari minimal 8 karakter dengan huruf dan angka.';
                        return;
                    }

                    // Jika validasi lolos, kirimkan form
                    document.querySelector('form').submit();
                }
            };
        }
    </script>
</body>
</html>


