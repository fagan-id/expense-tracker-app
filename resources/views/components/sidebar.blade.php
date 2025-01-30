<nav class="bg-fourth p-4 sm:hidden" x-data="{ isOpen: false }">
    <div class="flex justify-between items-center">
        <button @click="isOpen = !isOpen" class="text-black focus:outline-none px-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <div class="flex flex-row items-center gap-3 justify-center px-2">
            <h1 class="font-Poppins text-base font-semibold text-black"> {{ Auth::check() ? Auth::user()->name : 'Guest' }}</h1>
            <img src="https://i.pravatar.cc/80" alt="Profile" class="w-[2rem] h-[2rem] rounded-full">
        </div>
    </div>
    <div x-show="isOpen" class="mt-2 rounded-lg p-2 font-medium font-Poppins">
        <a href="/dashboard" class="block text-black p-2 w-full text-center {{ request()->is('dashboard*') ? 'border-2 border-primary rounded-lg' : '' }}">Dashboard</a>
        <a href="/transactions" class="block text-black p-2 w-full text-center
        {{ request()->is('transactions*') ? 'border-2 border-primary rounded-lg' : '' }}">Transactions</a>
        <a href="/settings" class="block text-black p-2 w-full text-center
        {{ request()->is('settings*') ? 'border-2 border-primary rounded-lg' : '' }}">Settings</a>
        <form action="{{ route('logout.submit') }}" method="POST">
            @csrf
            <button type="submit" class="w-full text-center px-4 py-2 rounded-lg bg-secondary">Logout</button>
        </form>
    </div>
</nav>

{{-- ukuran layar lebih besar dari sm (tab -> desktop) --}}
<nav class="hidden sm:flex bg-fourth h-[5%] sm:h-screen w-screen sm:w-[20%] shadow-lg  justify-center items-center font-Poppins">
    <div class="flex flex-row items-center sm:items-stretch sm:flex-col sm:w-[90%] sm:h-[95%] mt-6">
        <!-- User Info -->
        <div class="relative flex flex-col h-auto transition-all duration-300" id="userInfo">
            <div class="flex flex-row items-center gap-2 px-1 h-[90%]">
                <img src="https://i.pravatar.cc/80" alt="Profile" class="w-[3rem] h-[3rem] rounded-full">
                <p class="text-wrap w-[60%] sm:hidden md:flex"> {{ Auth::check() ? Auth::user()->name : 'Guest' }}</p>
                <!-- Tombol Toggle Menu -->
                <button id="toggleMenu" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 hidden sm:flex">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>
            <div class="mt-2 mb-3">
                <svg width="275" height="3" viewBox="0 0 275 3" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 2L275 1" stroke="#FEFDED"/>
                </svg>
            </div>
            <!-- Dropdown Menu Logout -->
            <div id="dropdownMenu" class="absolute left-0 top-[50%] mt-1 h-10 w-full bg-third shadow-md rounded-md overflow-hidden transition-all duration-300 opacity-0 scale-y-0 origin-top">
                <form action="{{ route('logout.submit') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                </form>
            </div>
        </div>
        <!-- Navigation Links -->
        <div class="flex flex-col h-[70%] gap-3">
            <!-- Dashboard -->
            <a  href="/dashboard" 
                class="flex flex-row gap-3 h-[13%] md:px-5 justify-center lg:justify-start items-center 
                {{ request()->is('dashboard*') ? 'border-2 border-primary rounded-lg' : '' }}">
                <svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="hidden sm:flex md:hidden lg:flex ">
                    <path d="M6.66667 21.6667H16.6667C17.1087 21.6667 17.5326 21.4911 17.8452 21.1785C18.1577 20.866 18.3333 20.442 18.3333 20V6.66667C18.3333 6.22464 18.1577 5.80072 17.8452 5.48816C17.5326 5.17559 17.1087 5 16.6667 5H6.66667C6.22464 5 5.80072 5.17559 5.48816 5.48816C5.17559 5.80072 5 6.22464 5 6.66667V20C5 20.442 5.17559 20.866 5.48816 21.1785C5.80072 21.4911 6.22464 21.6667 6.66667 21.6667ZM5 33.3333C5 33.7754 5.17559 34.1993 5.48816 34.5118C5.80072 34.8244 6.22464 35 6.66667 35H16.6667C17.1087 35 17.5326 34.8244 17.8452 34.5118C18.1577 34.1993 18.3333 33.7754 18.3333 33.3333V26.6667C18.3333 26.2246 18.1577 25.8007 17.8452 25.4882C17.5326 25.1756 17.1087 25 16.6667 25H6.66667C6.22464 25 5.80072 25.1756 5.48816 25.4882C5.17559 25.8007 5 26.2246 5 26.6667V33.3333ZM21.6667 33.3333C21.6667 33.7754 21.8423 34.1993 22.1548 34.5118C22.4674 34.8244 22.8913 35 23.3333 35H33.3333C33.7754 35 34.1993 34.8244 34.5118 34.5118C34.8244 34.1993 35 33.7754 35 33.3333V21.6667C35 21.2246 34.8244 20.8007 34.5118 20.4882C34.1993 20.1756 33.7754 20 33.3333 20H23.3333C22.8913 20 22.4674 20.1756 22.1548 20.4882C21.8423 20.8007 21.6667 21.2246 21.6667 21.6667V33.3333ZM23.3333 16.6667H33.3333C33.7754 16.6667 34.1993 16.4911 34.5118 16.1785C34.8244 15.866 35 15.442 35 15V6.66667C35 6.22464 34.8244 5.80072 34.5118 5.48816C34.1993 5.17559 33.7754 5 33.3333 5H23.3333C22.8913 5 22.4674 5.17559 22.1548 5.48816C21.8423 5.80072 21.6667 6.22464 21.6667 6.66667V15C21.6667 15.442 21.8423 15.866 22.1548 16.1785C22.4674 16.4911 22.8913 16.6667 23.3333 16.6667Z" fill="black"/>
                </svg>
                <p class="text-black font-medium flex sm:hidden md:flex">Dashboard</p>
            </a>
            <!-- Add similar divs for Transactions & Settings -->
            <!-- Transactions -->
            <a href="/transactions" 
                class="flex flex-row gap-3 h-[13%] md:px-5 justify-center lg:justify-start items-center 
                {{ request()->is('transactions*') ? 'border-2 border-primary rounded-lg' : '' }}">
                <svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"
                class="hidden sm:flex md:hidden lg:flex ">
                    <path d="M2.5 8.75H25M20 2.5L26.25 8.75L20 15M27.5 21.25H5M10 15L3.75 21.25L10 27.5" stroke="black" stroke-width="3"/>
                </svg>
                <p class="text-black font-medium mt-[-0.5rem] flex sm:hidden md:flex">Transactions</p>
            </a>

            <!-- Settings -->
            <a href="/settings"
                class="flex flex-row gap-3 h-[13%] md:px-5 justify-center lg:justify-start items-center
                {{ request()->is('settings*') ? 'border-2 border-primary rounded-lg' : '' }}">
                <svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"
                class="hidden sm:flex md:hidden lg:flex ">
                    <path d="M24.8751 15.825C24.6747 15.5969 24.5642 15.3036 24.5642 15C24.5642 14.6964 24.6747 14.4031 24.8751 14.175L26.4751 12.375C26.6514 12.1783 26.7609 11.9309 26.7879 11.6681C26.8148 11.4054 26.7578 11.1408 26.6251 10.9125L24.1251 6.58749C23.9937 6.35939 23.7937 6.17859 23.5536 6.07085C23.3134 5.96311 23.0453 5.93394 22.7876 5.98749L20.4376 6.46249C20.1386 6.52428 19.8273 6.47448 19.5625 6.32249C19.2976 6.17051 19.0976 5.92684 19.0001 5.63749L18.2376 3.34999C18.1538 3.10171 17.994 2.88607 17.7809 2.73354C17.5678 2.58101 17.3122 2.49931 17.0501 2.49999H12.0501C11.7775 2.48576 11.5078 2.56115 11.2821 2.71463C11.0564 2.86812 10.8871 3.09126 10.8001 3.34999L10.1001 5.63749C10.0026 5.92684 9.80258 6.17051 9.53776 6.32249C9.27293 6.47448 8.96164 6.52428 8.66261 6.46249L6.25011 5.98749C6.0058 5.95297 5.75674 5.99152 5.5343 6.09829C5.31186 6.20506 5.12599 6.37528 5.00011 6.58749L2.50011 10.9125C2.36406 11.1383 2.30289 11.4013 2.32534 11.664C2.34779 11.9267 2.45272 12.1755 2.62511 12.375L4.21261 14.175C4.41301 14.4031 4.52353 14.6964 4.52353 15C4.52353 15.3036 4.41301 15.5969 4.21261 15.825L2.62511 17.625C2.45272 17.8244 2.34779 18.0733 2.32534 18.336C2.30289 18.5986 2.36406 18.8617 2.50011 19.0875L5.00011 23.4125C5.13149 23.6406 5.33151 23.8214 5.57168 23.9291C5.81185 24.0369 6.07989 24.066 6.33761 24.0125L8.68761 23.5375C8.98664 23.4757 9.29793 23.5255 9.56276 23.6775C9.82758 23.8295 10.0276 24.0731 10.1251 24.3625L10.8876 26.65C10.9746 26.9087 11.1439 27.1319 11.3696 27.2853C11.5953 27.4388 11.865 27.5142 12.1376 27.5H17.1376C17.3997 27.5007 17.6553 27.419 17.8684 27.2664C18.0815 27.1139 18.2413 26.8983 18.3251 26.65L19.0876 24.3625C19.1851 24.0731 19.3851 23.8295 19.65 23.6775C19.9148 23.5255 20.2261 23.4757 20.5251 23.5375L22.8751 24.0125C23.1328 24.066 23.4009 24.0369 23.6411 23.9291C23.8812 23.8214 24.0812 23.6406 24.2126 23.4125L26.7126 19.0875C26.8453 18.8591 26.9023 18.5946 26.8754 18.3319C26.8484 18.0691 26.7389 17.8217 26.5626 17.625L24.8751 15.825ZM23.0126 17.5L24.0126 18.625L22.4126 21.4L20.9376 21.1C20.0373 20.916 19.1008 21.0689 18.3059 21.5297C17.5109 21.9906 16.9128 22.7273 16.6251 23.6L16.1501 25H12.9501L12.5001 23.575C12.2124 22.7023 11.6143 21.9656 10.8194 21.5047C10.0244 21.0439 9.08789 20.891 8.18761 21.075L6.71261 21.375L5.08761 18.6125L6.08761 17.4875C6.70256 16.8 7.04253 15.9099 7.04253 14.9875C7.04253 14.0651 6.70256 13.175 6.08761 12.4875L5.08761 11.3625L6.68761 8.61249L8.16261 8.91249C9.06289 9.09652 9.9994 8.94359 10.7944 8.48274C11.5893 8.02189 12.1874 7.28519 12.4751 6.41249L12.9501 4.99999H16.1501L16.6251 6.42499C16.9128 7.29769 17.5109 8.03439 18.3059 8.49524C19.1008 8.95609 20.0373 9.10902 20.9376 8.92499L22.4126 8.62499L24.0126 11.4L23.0126 12.525C22.4046 13.2109 22.0688 14.0958 22.0688 15.0125C22.0688 15.9291 22.4046 16.814 23.0126 17.5ZM14.5501 9.99999C13.5612 9.99999 12.5945 10.2932 11.7723 10.8426C10.95 11.3921 10.3092 12.1729 9.93072 13.0866C9.55228 14.0002 9.45326 15.0055 9.64619 15.9754C9.83911 16.9453 10.3153 17.8363 11.0146 18.5355C11.7138 19.2348 12.6048 19.711 13.5747 19.9039C14.5446 20.0968 15.5499 19.9978 16.4635 19.6194C17.3772 19.241 18.1581 18.6001 18.7075 17.7778C19.2569 16.9556 19.5501 15.9889 19.5501 15C19.5501 13.6739 19.0233 12.4021 18.0856 11.4645C17.148 10.5268 15.8762 9.99999 14.5501 9.99999ZM14.5501 17.5C14.0557 17.5 13.5723 17.3534 13.1612 17.0787C12.7501 16.804 12.4296 16.4135 12.2404 15.9567C12.0512 15.4999 12.0017 14.9972 12.0982 14.5123C12.1946 14.0273 12.4327 13.5819 12.7823 13.2322C13.132 12.8826 13.5774 12.6445 14.0624 12.548C14.5473 12.4516 15.05 12.5011 15.5068 12.6903C15.9636 12.8795 16.3541 13.1999 16.6288 13.6111C16.9035 14.0222 17.0501 14.5055 17.0501 15C17.0501 15.663 16.7867 16.2989 16.3179 16.7678C15.849 17.2366 15.2132 17.5 14.5501 17.5Z" fill="black"/>
                </svg>
                <p class="text-black font-medium mt-[-0.5rem] flex sm:hidden md:flex">Settings</p>
            </a>
        </div>
        <div class="flex items-end justify-center h-[20%] py-5">
            <h1 class="font-Rammetto_One text-2xl text-black">Aturin</h1>
        </div>
    </div>
</nav>

<!-- JavaScript untuk Toggle Menu -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleButton = document.getElementById("toggleMenu");
        const dropdownMenu = document.getElementById("dropdownMenu");
        const userInfo = document.getElementById("userInfo");

        toggleButton.addEventListener("click", function () {
            dropdownMenu.classList.toggle("opacity-0");
            dropdownMenu.classList.toggle("scale-y-0");
             // Tambahkan padding ekstra ke userInfo saat dropdown muncul
            if (!dropdownMenu.classList.contains("opacity-0")) {
                userInfo.classList.add("pb-10"); // Tambah padding bawah
            } else {
                userInfo.classList.remove("pb-10"); // Hilangkan padding saat ditutup
            }
        });

        // Menutup dropdown jika klik di luar
        document.addEventListener("click", function (event) {
            if (!toggleButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add("opacity-0", "scale-y-0");
                dropdownMenu.classList.remove("opacity-100", "scale-y-100");
            }
        });
    });
</script>