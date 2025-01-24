<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
    <title>Document</title>
</head>
<body>
    <nav class="bg-third fixed left-0 top-0 w-full z-50 drop-shadow-lg" x-data="{ isOpen: false }" >
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
          <div class="relative flex h-16 items-center justify-between ">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
              <!-- Mobile menu button-->
              <button type="button" @click="isOpen = !isOpen" class="relative inline-flex items-center justify-center rounded-md p-2 text-black hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                <span class="absolute -inset-0.5"></span>
                <span class="sr-only">Open main menu</span>
                <svg :class="{'hidden': isOpen, 'block': !isOpen }" class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg :class="{'block': isOpen, 'hidden': !isOpen }" class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
              <div class="flex shrink-0 items-center">
                <h1 class="text-2xl font-semibold font-Rammetto_One">ATURIN</h1>
              </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-2 sm:pr-0">
              <div class="hidden sm:ml-6 sm:block">
                <div class="flex space-x-4">
                  <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                  <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-black hover:bg-fourth">Home</a>
                  <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-black hover:bg-fourth">About</a>
                  <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-black hover:bg-fourth">Contact</a>
                  <a href="login" class="rounded-md bg-primary px-6 py-2 text-sm font-medium text-black hover:bg-gray-200">Login</a>
                  <a href="register" class="rounded-md bg-gray-700 px-6 py-2 text-sm font-medium text-primary hover:bg-gray-500 ">Sign In</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div x-show="isOpen" class="sm:hidden" id="mobile-menu">
          <div class="space-y-1 px-2 pb-3 pt-2 text-center">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-black hover:bg-fourth">Home</a>
            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-black hover:bg-fourth hover:text-gray-900">About</a>
            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-black hover:bg-fourth hover:text-gray-900">Contact</a>
            <a href="#" class="block rounded-md bg-primary px-6 py-2 text-sm font-medium text-black hover:bg-gray-200 ">Login</a>
            <a href="#" class="block rounded-md bg-gray-700 px-6 py-2 text-sm font-medium text-primary hover:bg-gray-500 ">Sign In</a>
          </div>
        </div>
    </nav>

    {{-- hero section --}}
    <div class="w-full h-screen bg-gray-gradient">
      <div class="mt-[4em]">
        <div class="sm:ml-[4rem] sm:mr-[1rem] h-[85vh] flex items-center justify-center sm:flex-row flex-col">
          <div class="flex sm:text-left w-[90%] h-[30%] justify-center items-center " >
            <h1 class="md:text-6xl sm:text-3xl text-3xl font-Poppins font-semibold">
              Halo User ! <br><br><br>
              Mari atur keuanganmu bersama Aturin! ✨
            </h1>
          </div>
          <div class="flex items-center justify-center sm:flex-col w-[50%] h-[30%] sm:h-[100%]">
            <div class=" h-[75%] hidden sm:flex sm:items-center">
              <img src="img/main1.png" alt="Aturin1" width="700">
            </div>
            <div class="flex justify-center text-center">
              <a href="register" class="block rounded-md drop-shadow-lg bg-third px-32 py-4 text-nowrap sm:px-10 sm:py-4 md:text-xl font-medium font-Poppins text-black hover:bg-fourth ">Get Started!</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- about section --}}
    <div class="w-full flex justify-center h-full bg-third">
      <div class="flex flex-col w-[90%] h-[100%] my-16">
        <div class="flex flex-col">
          <h1 class="text-2xl font-semibold font-Poppins">Get to know about Aturin!</h1>
          <div class="bg-primary w-full h-full rounded-lg shadow-md mt-3">
            <p class="text-md font-Poppins text-justify font-normal mx-4 my-3">Aturin adalah platform inovatif yang dirancang untuk membantu Anda mencatat, melacak, dan mengatur pengeluaran dengan detail dan kemudahan. Platform ini dilengkapi dengan fitur pengelompokan pengeluaran berdasarkan rentang waktu tertentu, memungkinkan Anda untuk menganalisis pola pengeluaran secara lebih terstruktur. Dengan tampilan yang intuitif, Aturin memberikan pengalaman yang nyaman dalam memantau aliran dana Anda, menjadikan manajemen keuangan tidak hanya lebih efisien, tetapi juga lebih menyenangkan.
            
              <br><br>

            Selain menawarkan berbagai kemudahan, Aturin tersedia secara gratis, sehingga siapa pun dapat menggunakannya tanpa biaya. Dengan alat ini, Anda bisa mendapatkan wawasan mendalam tentang kebiasaan pengeluaran Anda, yang akan membantu Anda membuat keputusan finansial yang lebih bijak. Apakah tujuan Anda menabung, mengurangi pengeluaran, atau merencanakan anggaran untuk masa depan, Aturin adalah mitra yang sempurna untuk mendukung perjalanan Anda menuju kestabilan keuangan. Cobalah sekarang dan mulailah mengelola keuangan dengan cara yang lebih cerdas dan tanpa biaya!</p>
          </div>
        </div>
        
        {{-- Testimonial Section --}}
        <div class="mt-9 flex flex-col" x-data="commentsSection">
          <h1 class="text-2xl font-semibold font-Poppins">They said about Aturin!</h1>
          <div class="flex sm:flex-row flex-wrap justify-center font-Poppins flex-col gap-4 mt-4 overflow-hidden">
              <template x-for="(comment, index) in comments" :key="index">
                  <div
                      class="flex items-center bg-white rounded-lg shadow-md w-full px-6 sm:px-4 md:px-6 py-5 sm:w-full md:w-[32%]"
                      x-show="expanded || isSmallScreen || index < 2"
                      x-transition:enter="transition ease-out duration-300"
                      x-transition:enter-start="opacity-0 transform scale-95"
                      x-transition:enter-end="opacity-100 transform scale-100"
                      x-transition:leave="transition ease-in duration-300"
                      x-transition:leave-start="opacity-100 transform scale-100"
                      x-transition:leave-end="opacity-0 transform scale-95"
                  >
                      <img src="img/UserIcon.png" alt="User Icon" class="w-12 h-12 mr-3">
                      <div>
                          <h3 class="text-lg text-black font-bold" x-text="comment.name"></h3>
                          <p class="text-sm text-black" x-text="comment.text"></p>
                      </div>
                  </div>
              </template>
          </div>

          <div class="mt-4 flex justify-center" x-show="!isSmallScreen">
              <button
                  class="px-4 py-2 bg-secondary text-white rounded-lg hover:bg-fourth transition"
                  x-text="expanded ? 'Show Less' : 'Show More'"
                  @click="expanded = !expanded"
              ></button>
          </div>
        </div>

      </div>
    </div>

    {{-- Contact Section --}}
    <div class="bg-primary w-full h-full">
      <div class="py-10 font-Poppins pl-[2rem] pr-[2rem]  sm:pl-[4rem] sm:pr-[5rem] rounded-lg w-full">
        <h2 class="sm:text-2xl font-bold mb-4">Contact us if you have any questions! !</h2>
        <form 
            x-data="{ 
                name: '', 
                email: '', 
                subject: '', 
                message: '', 
                validateEmail() {
                    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                    return emailPattern.test(this.email);
                },
                sanitize(input) {
                    const temp = document.createElement('div');
                    temp.textContent = input;
                    return temp.innerHTML;
                },
                handleSubmit(e) {
                    e.preventDefault();
                    if (!this.validateEmail()) {
                        alert('Email tidak valid!');
                        return;
                    }
                    const sanitizedData = {
                        name: this.sanitize(this.name),
                        email: this.sanitize(this.email),
                        subject: this.sanitize(this.subject),
                        message: this.sanitize(this.message),
                    };
                    console.log('Data submitted:', sanitizedData);
                    alert('Formulir berhasil dikirim!');
                },
            }" 
            class="space-y-4" 
            @submit="handleSubmit"
        >
            <div>
                <label for="name" class="block text-sm font-medium">Name *</label>
                <input 
                    type="text" 
                    id="name" 
                    x-model="name" 
                    class="w-full mt-1 p-2 border-2 border-fourth rounded-md bg-gray-100 focus:ring focus:ring-fourth focus:outline-none">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium">Email *</label>
                <input 
                    type="email" 
                    id="email" 
                    x-model="email" 
                    class="w-full mt-1 p-2 border-2 border-fourth rounded-md bg-gray-100 focus:ring focus:ring-fourth focus:outline-none">
            </div>
            <div>
                <label for="subject" class="block text-sm font-medium">Subject *</label>
                <input 
                    type="text" 
                    id="subject" 
                    x-model="subject" 
                    class="w-full mt-1 p-2 border-2 border-fourth rounded-md bg-gray-100 focus:ring focus:ring-fourth focus:outline-none">
            </div>
            <div>
                <label for="message" class="block text-sm font-medium">Question/Feedback *</label>
                <textarea 
                    id="message" 
                    x-model="message" 
                    rows="4" 
                    class="w-full mt-1 p-2 border-2 border-fourth rounded-md bg-gray-100 focus:ring focus:ring-fourth focus:outline-none">
                </textarea>
            </div>
            <button 
                type="submit" 
                class="w-full bg-fourth text-black font-medium py-2 rounded-md hover:bg-third focus:ring focus:ring-fourth focus:outline-none">
                Send
            </button>
        </form>
    </div>

    {{-- footer --}}
    <footer class="bg-secondary">
      <h1 class="font-Poppins text-md text-center font-semibold py-10">Copyright 2025</h1>
    </footer>

    <script>
      document.addEventListener('alpine:init', () => {
          Alpine.data('commentsSection', () => ({
              expanded: false,
              isSmallScreen: false, // Default false
              comments: [
                  { name: 'Fufufafa ganteng', text: 'Aturin sangat membantuku dalam mengelola keuanganku! Sangat recommended' },
                  { name: 'Mahasiswa123', text: 'Keren banget pokoknya!' },
                  { name: 'Agus Saputra', text: 'Sangat membantu saya dalam mencatat pengeluaran harian.' },
                  { name: 'Cristiano', text: 'Platform yang luar biasa dan mudah digunakan!' },
                  { name: 'Leonel', text: 'Aturin membuat keuangan saya lebih terstruktur.' },
                  { name: 'Anthony Salim', text: 'Benar-benar tools yang bermanfaat!' }
              ],
              init() {
                // Update ukuran layar secara dinamis
                const updateScreenSize = () => {
                    this.isSmallScreen = window.innerWidth >= 640;
                };

                // Tambahkan event listener untuk resize
                window.addEventListener('resize', updateScreenSize);

                // Panggil update pertama kali saat init
                updateScreenSize();

                // Cleanup event listener saat elemen dihapus
                this.$watch('$el', () => {
                    window.removeEventListener('resize', updateScreenSize);
                });
            }
          }));
      });
    </script>
</body>
</html>