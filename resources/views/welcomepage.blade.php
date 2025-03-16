<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Portfolio Bayu Sulaksana</title>

  <!-- AOS -->
  <link rel="stylesheet" href="/assets/css/aon/aos.css" />

  <!-- CSS Style -->
  <link href="dist/css/final.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
  <style>
    .progress-bar {
      width: 0%;
      animation-fill-mode: forwards;
    }

    @keyframes progressBarAnimation {
      from {
        width: 0%;
      }

      to {
        width: var(--progress-width);
      }
    }
  </style>

  <!-- Script Darkmode -->
  <script>
    if (
      localStorage.theme === 'dark' ||
      (!('theme' in localStorage) &&
        window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  </script>
</head>

<body>
  <!-- Header Start -->
  <header
    class="absolute left-0 top-0 z-10 flex w-full items-center bg-transparent">
    <div class="container">
      <div class="relative flex items-center justify-between">
        <div class="px-4">
          <a href="#home" class="block py-6 text-lg font-bold text-primary">Bayu Sulaksana
          </a>
        </div>
        <div class="flex items-center px-4">
          <button
            id="hamburger"
            name="hamburger"
            type="button"
            class="absolute right-4 block lg:hidden">
            <span
              class="hamburger-line origin-top-left transition duration-300 ease-in-out"></span>
            <span
              class="hamburger-line transition duration-300 ease-in-out"></span>
            <span
              class="hamburger-line origin-bottom-left transition duration-300 ease-in-out"></span>
          </button>

          <nav
            id="nav-menu"
            class="absolute right-4 top-full hidden w-full max-w-[250px] rounded-lg bg-white py-5 shadow-lg dark:bg-dark dark:shadow-slate-500 lg:static lg:block lg:max-w-full lg:rounded-none lg:bg-transparent lg:shadow-none lg:dark:bg-transparent">
            <ul class="block lg:flex">
              <li class="group">
                <a
                  href="#home"
                  class="mx-8 flex py-2 text-base font-semibold text-dark group-hover:text-primary dark:text-white">Home</a>
              </li>
              <li class="group">
                <a
                  href="#about"
                  class="mx-8 flex py-2 text-base font-semibold text-dark group-hover:text-primary dark:text-white">About Me</a>
              </li>
              <li class="group">
                <a
                  href="#portfolio"
                  class="mx-8 flex py-2 text-base font-semibold text-dark group-hover:text-primary dark:text-white">Portfolio</a>
              </li>
              <li class="group">
                <a
                  href="#clients"
                  class="mx-8 flex py-2 text-base font-semibold text-dark group-hover:text-primary dark:text-white">Clients</a>
              </li>
              <li class="group">
                <a
                  href="#blog"
                  class="mx-8 flex py-2 text-base font-semibold text-dark group-hover:text-primary dark:text-white">Blog</a>
              </li>
              <li class="group">
                <a
                  href="#contact"
                  class="mx-8 flex py-2 text-base font-semibold text-dark group-hover:text-primary dark:text-white">Contact</a>
              </li>
              <li class="mt-3 flex items-center pl-8 lg:mt-0">
                <div class="flex">
                  <span class="mr-2 text-sm text-slate-500 dark:text-white">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      height="20"
                      viewBox="0 96 960 960"
                      width="20"
                      class="fill-current">
                      <path
                        d="M480 696q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm-.226 72Q400 768 344 711.774t-56-136Q288 496 344.226 440t136-56Q560 384 616 440.226t56 136Q672 656 615.774 712t-136 56ZM84 612q-15.3 0-25.65-10.289Q48 591.421 48 576.211 48 561 58.35 550.5 68.7 540 84 540h96q15.3 0 25.65 10.289 10.35 10.29 10.35 25.5Q216 591 205.65 601.5 195.3 612 180 612H84Zm696 0q-15.3 0-25.65-10.289-10.35-10.29-10.35-25.5Q744 561 754.35 550.5 764.7 540 780 540h96q15.3 0 25.65 10.289 10.35 10.29 10.35 25.5Q912 591 901.65 601.5 891.3 612 876 612h-96ZM480.211 312Q465 312 454.5 301.65 444 291.3 444 276v-96q0-15.3 10.289-25.65 10.29-10.35 25.5-10.35Q495 144 505.5 154.35 516 164.7 516 180v96q0 15.3-10.289 25.65-10.29 10.35-25.5 10.35Zm0 696Q465 1008 454.5 997.65 444 987.3 444 972v-96q0-15.3 10.289-25.65 10.29-10.35 25.5-10.35Q495 840 505.5 850.35 516 860.7 516 876v96q0 15.3-10.289 25.65-10.29 10.35-25.5 10.35ZM242 389l-50-51q-11-10-11-24.5t11-25.5q10.435-11 25.217-11Q232 277 242 288l51 50q11 10.941 11 25.529 0 14.589-11 25.53Q283 400 268 400t-26-11Zm476 475-51-50q-11-10.667-11-25.333Q656 774 667 763q10-11 25-11t26 11l50 51q11 10 11 24.5T768.478 864Q757 875 743 875q-14 0-25-11Zm-51.059-475Q656 379 656 364t11-26l51-50q11-11 25-10.5t25 10.543Q779 299 779 313t-11 25l-50 51q-10.941 11-25.529 11-14.589 0-25.53-11ZM192 864q-11-10.435-11-25.217Q181 824 192 814l50-51q10.667-10 25.333-10Q282 753 293 763q11 11 10.542 25.667Q303.083 803.333 293 814l-51 50q-10 11-24.5 11T192 864Zm288-288Z" />
                    </svg>
                  </span>
                  <input type="checkbox" class="hidden" id="dark-toggle" />
                  <label for="dark-toggle">
                    <div
                      class="flex h-5 w-9 cursor-pointer items-center rounded-full bg-slate-500 p-1">
                      <div
                        class="toggle-circle h-4 w-4 rounded-full bg-white transition duration-300 ease-in-out"></div>
                    </div>
                  </label>
                  <span class="ml-2 text-sm text-slate-500 dark:text-white">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      height="20"
                      viewBox="0 96 960 960"
                      width="20"
                      class="fill-current">
                      <path
                        d="M479.961 912Q340 912 242 814t-98-238q0-140 97.93-238t237.831-98q13.057 0 25.648 1T531 244q-39 29-62 72t-23 92q0 85 58.5 143.5T648 610q49 0 92-23t72-62q2 13 3 25.591 1 12.591 1 25.648 0 139.901-98.039 237.831-98.04 97.93-238 97.93Zm.039-72q82 0 148.776-47.074Q695.553 745.853 727 670q-20 5-39.667 8.5Q667.667 682 648 682q-113.858 0-193.929-80.071T374 408q0-19.667 3.5-39.333Q381 349 386 329q-75.853 31.447-122.926 98.224Q216 494 216 576q0 110 77 187t187 77Zm-14-250Z" />
                    </svg>
                  </span>
                </div>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- Header End -->

  <!-- Hero Section Start -->
  <section id="home" class="pt-36 dark:bg-dark">
    <div class="container">
      <div class="flex flex-wrap">
        <div class="w-full self-center px-4 lg:w-1/2">
          <h1
            class="text-base font-semibold text-primary md:text-xl"
            data-aos="fade-right"
            data-aos-duration="1500">
            Hello Everyone 👋, I'm
            <span
              class="mt-1 block text-4xl font-bold text-dark dark:text-white lg:text-5xl">Bayu Sulaksana</span>
          </h1>
          <h2
            class="mb-5 mt-3 text-lg font-medium text-dark dark:text-white lg:text-2xl"
            data-aos="fade-right"
            data-aos-duration="1500"
            data-aos-delay="300">
            Full stack Web Developer
          </h2>
          <p
            class="my-quotes md:text-md mb-10 font-medium italic leading-relaxed text-secondary">
            "The best way to predict the future is to create it." – Peter Drucker
          </p>
          <a
            href="#"
            class="rounded-full bg-primary px-8 py-3 text-base font-semibold text-white transition duration-300 ease-in-out hover:opacity-80 hover:shadow-lg">Contact Me</a>
        </div>
        <div class="w-full self-end px-4 lg:w-1/2">
          <div
            class="relative mt-10 lg:right-0 lg:mt-9"
            data-aos="zoom-in"
            data-aos-duration="1500">
            <img
              src="/img/background/background.png"
              alt="Bayu Sulaksana"
              class="relative z-10 mx-auto max-w-full" />
            <span
              class="absolute -bottom-20 left-1/2 -translate-x-1/2 md:-bottom-6 md:scale-125">
              <svg
                width="400"
                height="400"
                viewBox="0 0 200 200"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  fill="#14b8a6"
                  d="M52.2,-62.6C66.5,-50.3,76,-32.7,73.6,-17.2C71.3,-1.8,57.1,11.5,46.3,23.7C35.6,35.9,28.4,47,18.8,49.5C9.3,52,-2.6,45.8,-15.9,41.8C-29.2,37.8,-44,35.9,-52.5,27.3C-61,18.8,-63.3,3.6,-63.7,-14.2C-64.2,-32.1,-62.8,-52.6,-51.9,-65.6C-40.9,-78.5,-20.5,-83.8,-0.7,-82.9C19,-82,38,-74.9,52.2,-62.6Z"
                  transform="translate(100 100) scale(1.1)" />
              </svg>
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Hero Section End -->

  <!-- About Section Start -->
  <section id="about" class="pb-32 pt-36 dark:bg-dark">
    <div class="container">
      <div class="flex flex-wrap items-center">
        <!-- Left Column: About Me Content -->
        <div
          class="mb-10 w-full px-4 lg:w-1/2"
          data-aos="fade-right"
          data-aos-duration="800">
          <h4 class="mb-3 text-lg font-bold uppercase text-primary animate-fade-in">
            Tentang Saya
          </h4>
          <h2
            class="mb-5 text-3xl font-bold text-dark dark:text-white lg:text-4xl animate-fade-in">
            I Wayan Bayu Sulaksana
          </h2>
          <h3 class="mb-6 text-xl font-semibold text-primary animate-fade-in delay-100">
            Full Stack Programmer | Tech Enthusiast
          </h3>
          <p
            class="mb-6 text-base font-medium text-secondary lg:text-lg animate-fade-in delay-200">
            Halo! Saya **I Wayan Bayu Sulaksana**, seorang Full Stack Programmer dengan passion yang besar dalam menciptakan solusi teknologi yang inovatif dan efisien. Saya memiliki pengalaman dalam mengembangkan aplikasi web yang responsif, skalabel, dan ramah pengguna, mulai dari front-end hingga back-end.
          </p>
          <p
            class="mb-6 text-base font-medium text-secondary lg:text-lg animate-fade-in delay-300">
            Saya menguasai teknologi seperti **HTML5**, **CSS3**, **JavaScript**, **React.js**, **Node.js**, dan **MongoDB**. Saya senang menggabungkan kreativitas dengan keterampilan teknis untuk menghidupkan ide-ide menjadi kenyataan. Baik itu membangun antarmuka pengguna yang menarik atau mengoptimalkan kinerja server, saya selalu bersemangat untuk menyelesaikan tantangan teknis yang kompleks.
          </p>
          <p
            class="mb-6 text-base font-medium text-secondary lg:text-lg animate-fade-in delay-400">
            Saya percaya bahwa kolaborasi adalah kunci kesuksesan. Mari bekerja sama untuk mewujudkan visi Anda dan menciptakan sesuatu yang luar biasa!
          </p>
          <a
            href="#contact"
            class="inline-block rounded-lg bg-primary px-8 py-3 text-white transition duration-300 hover:bg-primary-dark animate-fade-in delay-500">
            Hubungi Saya
          </a>
        </div>

        <!-- Right Column: Skills Section -->
        <div class="w-full px-4 lg:w-1/2">
          <h3 class="mb-4 text-2xl font-semibold text-dark dark:text-white lg:pt-10 lg:text-3xl animate-fade-in delay-100">
            Keahlian Saya
          </h3>
          <div class="mb-12">
            <!-- HTML5 Progress Bar -->
            <div class="mb-4 animate-fade-in delay-200">
              <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-primary">HTML5</span>
                <span class="text-sm font-medium text-primary">100%</span>
              </div>
              <div class="w-full bg-primary/10 rounded-full h-2.5">
                <div
                  class="bg-primary h-2.5 rounded-full progress-bar"
                  style="--progress-width: 100%; animation: progressBarAnimation 1.5s ease-in-out forwards;"></div>
              </div>
            </div>

            <!-- CSS3 Progress Bar -->
            <div class="mb-4 animate-fade-in delay-300">
              <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-primary">CSS3</span>
                <span class="text-sm font-medium text-primary">100%</span>
              </div>
              <div class="w-full bg-primary/10 rounded-full h-2.5">
                <div
                  class="bg-primary h-2.5 rounded-full progress-bar"
                  style="--progress-width: 100%; animation: progressBarAnimation 1.5s ease-in-out forwards;"></div>
              </div>
            </div>

            <!-- JavaScript Progress Bar -->
            <div class="mb-4 animate-fade-in delay-400">
              <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-primary">JavaScript</span>
                <span class="text-sm font-medium text-primary">100%</span>
              </div>
              <div class="w-full bg-primary/10 rounded-full h-2.5">
                <div
                  class="bg-primary h-2.5 rounded-full progress-bar"
                  style="--progress-width: 100%; animation: progressBarAnimation 1.5s ease-in-out forwards;"></div>
              </div>
            </div>

            <!-- React.js Progress Bar -->
            <div class="mb-4 animate-fade-in delay-500">
              <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-primary">React.js</span>
                <span class="text-sm font-medium text-primary">100%</span>
              </div>
              <div class="w-full bg-primary/10 rounded-full h-2.5">
                <div class="bg-primary h-2.5 rounded-full" style="width: 100%"></div>
              </div>
            </div>

            <!-- Node.js Progress Bar -->
            <div class="mb-4 animate-fade-in delay-600">
              <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-primary">Node.js</span>
                <span class="text-sm font-medium text-primary">100%</span>
              </div>
              <div class="w-full bg-primary/10 rounded-full h-2.5">
                <div class="bg-primary h-2.5 rounded-full" style="width: 100%"></div>
              </div>
            </div>

            <!-- MongoDB Progress Bar -->
            <div class="mb-4 animate-fade-in delay-700">
              <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-primary">MongoDB</span>
                <span class="text-sm font-medium text-primary">100%</span>
              </div>
              <div class="w-full bg-primary/10 rounded-full h-2.5">
                <div class="bg-primary h-2.5 rounded-full" style="width: 100%"></div>
              </div>
            </div>

            <!-- Express.js Progress Bar -->
            <div class="mb-4 animate-fade-in delay-800">
              <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-primary">Express.js</span>
                <span class="text-sm font-medium text-primary">100%</span>
              </div>
              <div class="w-full bg-primary/10 rounded-full h-2.5">
                <div class="bg-primary h-2.5 rounded-full" style="width: 100%"></div>
              </div>
            </div>

            <!-- Git & GitHub Progress Bar -->
            <div class="mb-4 animate-fade-in delay-900">
              <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-primary">Git & GitHub</span>
                <span class="text-sm font-medium text-primary">100%</span>
              </div>
              <div class="w-full bg-primary/10 rounded-full h-2.5">
                <div class="bg-primary h-2.5 rounded-full" style="width: 100%"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- About Section End -->


  <!-- Footer Start -->
  <footer class="bg-dark pb-12 pt-24">
    <div class="container">
      <div class="flex flex-wrap">
        <div class="mb-12 w-full px-4 font-medium text-slate-300 md:w-1/3">
          <h2 class="mb-5 text-4xl font-bold text-white">Mysterio</h2>
          <h3 class="mb-2 text-2xl font-bold">Contact Us</h3>
          <div class="flex items-center">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              height="20"
              viewBox="0 96 960 960"
              width="20"
              class="mr-2 fill-current py-0">
              <path
                d="M168 864q-29 0-50.5-21.5T96 792V360q0-29 21.5-50.5T168 288h624q30 0 51 21.5t21 50.5v432q0 29-21 50.5T792 864H168Zm312-240 312-179v-85L480 539 168 360v85l312 179Z" />
            </svg>
            <p class="py-0">mysterio6567@gmail.com</p>
          </div>
          <div class="flex items-start">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              height="20"
              viewBox="0 96 960 960"
              width="20"
              class="mr-2 fill-current py-0">
              <path
                d="M480.124 578Q514 578 538 553.876t24-58Q562 462 537.876 438t-58-24Q446 414 422 438.124t-24 58Q398 530 422.124 554t58 24ZM480 976Q319 837 239.5 721T160 504.2q0-151.2 96-239.7T480 176q128 0 224 88.5t96 239.7Q800 605 720.5 721 641 837 480 976Z" />
            </svg>
            <p class="py-0">Jl. Imam Bonjol No. 9999, Denpasar, Bali</p>
          </div>
        </div>
        <div class="mb-12 w-full px-4 md:w-1/3">
          <h3 class="mb-5 text-xl font-semibold text-white">Categori</h3>
          <ul class="text-slate-300">
            <li>
              <a
                href="#"
                class="mb-3 inline-block text-base hover:text-primary">Programming
              </a>
            </li>
            <li>
              <a
                href="#"
                class="mb-3 inline-block text-base hover:text-primary">Technology
              </a>
            </li>
            <li>
              <a
                href="#"
                class="mb-3 inline-block text-base hover:text-primary">Lifestyle
              </a>
            </li>
          </ul>
        </div>
        <div class="mb-12 w-full px-4 md:w-1/3">
          <h3 class="mb-5 text-xl font-semibold text-white">Link</h3>
          <ul class="text-slate-300">
            <li>
              <a
                href="#home"
                class="mb-3 inline-block text-base hover:text-primary">Home
              </a>
            </li>
            <li>
              <a
                href="#about"
                class="mb-3 inline-block text-base hover:text-primary">About Me
              </a>
            </li>
            <li>
              <a
                href="#portfolio"
                class="mb-3 inline-block text-base hover:text-primary">Portfolio
              </a>
            </li>
            <li>
              <a
                href="#clients"
                class="mb-3 inline-block text-base hover:text-primary">Clients
              </a>
            </li>
            <li>
              <a
                href="#blog"
                class="mb-3 inline-block text-base hover:text-primary">Blog
              </a>
            </li>
            <li>
              <a
                href="#contact"
                class="mb-3 inline-block text-base hover:text-primary">Contact
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="w-full border-t border-slate-700 pt-10">
        <div class="mb-5 flex items-center justify-center">
          <!-- Youtube -->
          <a
            href="#"
            target="_blank"
            class="mr-3 flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 text-slate-300 hover:border-primary hover:bg-primary hover:text-white">
            <svg
              role="img"
              width="20"
              class="fill-current"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <title>YouTube</title>
              <path
                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
            </svg>
          </a>

          <!-- Instagram -->
          <a
            href="#"
            target="_blank"
            class="mr-3 flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 text-slate-300 hover:border-primary hover:bg-primary hover:text-white">
            <svg
              role="img"
              width="20"
              class="fill-current"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <title>Instagram</title>
              <path
                d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
            </svg>
          </a>

          <!-- Twitter -->
          <a
            href="#"
            target="_blank"
            class="mr-3 flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 text-slate-300 hover:border-primary hover:bg-primary hover:text-white">
            <svg
              role="img"
              width="20"
              class="fill-current"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <title>Twitter</title>
              <path
                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
            </svg>
          </a>

          <!-- Tiktok -->
          <a
            href="#"
            target="_blank"
            class="mr-3 flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 text-slate-300 hover:border-primary hover:bg-primary hover:text-white">
            <svg
              role="img"
              width="20"
              class="fill-current"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <title>TikTok</title>
              <path
                d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
            </svg>
          </a>

          <!-- LinkedIn -->
          <a
            href="#"
            target="_blank"
            class="mr-3 flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 text-slate-300 hover:border-primary hover:bg-primary hover:text-white">
            <svg
              role="img"
              width="20"
              class="fill-current"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <title>LinkedIn</title>
              <path
                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
            </svg>
          </a>

          <!-- Github -->
          <a
            href="#"
            target="_blank"
            class="mr-3 flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 text-slate-300 hover:border-primary hover:bg-primary hover:text-white">
            <svg
              role="img"
              width="20"
              class="fill-current"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <title>GitHub</title>
              <path
                d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12" />
            </svg>
          </a>
        </div>
        <p class="text-center text-xs font-medium text-slate-500">
          Created with
          <span class="text-pink-500">❤</span> by
          <a
            href="https://github.com/rioarya01"
            target="_blank"
            class="font-bold text-primary">Rio Arya Bawesi </a>, using
          <a
            href="https://tailwindcss.com/"
            target="_blank"
            class="font-bold text-sky-500">
            Tailwind CSS </a>.
        </p>
      </div>
    </div>
  </footer>
  <!-- Footer End -->

  <!-- Back to top Start -->
  <a
    href="#home"
    class="fixed bottom-4 right-4 z-[9999] hidden h-14 w-14 items-center justify-center rounded-full bg-primary p-4 hover:animate-pulse"
    id="to-top">
    <span class="mt-2 block h-5 w-5 rotate-45 border-l-2 border-t-2"></span>
  </a>
  <!-- Back to top End -->

  <script src="dist/js/script.js"></script>
  <script src="/assets/js/custom/aon/aos.js"></script>
  <script>
    AOS.init();
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/TextPlugin.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

  <script>
    gsap.registerPlugin(ScrollTrigger);

    // Animate the "About Me" heading
    gsap.from('.animate-fade-in', {
      opacity: 0,
      y: 20,
      duration: 1,
      scrollTrigger: {
        trigger: '#about',
        start: 'top 80%',
      },
    });
  </script>
  <script>
    const progressBars = document.querySelectorAll('.progress-bar');

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.style.animation = `progressBarAnimation 1.5s ease-in-out forwards`;
          }
        });
      }, {
        threshold: 0.5
      }
    );

    progressBars.forEach((bar) => observer.observe(bar));
  </script>
</body>

</html>