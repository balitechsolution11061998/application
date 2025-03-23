function initApp() {
  return {
    db: null,
    time: null,
    firstTime: localStorage.getItem("first_time") === null,
    activeMenu: 'pos',
    loadingSampleData: false,
    moneys: [2000, 5000, 10000, 20000, 50000, 100000],
    products: [],
    keyword: "",
    cart: [],
    cash: 0,
    change: 0,
    isShowModalReceipt: false,
    receiptNo: null,
    receiptDate: null,
    isLoading: false,
    isLoggedIn: false,
    showUserModal:false,
    username: "", // Username input
    password: "", // Password input
    user: {      // Tambahkan state user
      name: "",  // Nama pengguna
      role: ""   // Peran pengguna
    },
    logoutTimer: null, // Timer untuk auto logout
    inactivityDuration: 5 * 60 * 1000, // 5 menit dalam milidetik

    // Login function
    login() {
      if (!this.username || !this.password) {
        alert("Username dan password harus diisi!");
        return;
      }

      // Contoh validasi (ganti dengan logika autentikasi yang sebenarnya)
      if (this.username === "admin" && this.password === "password") {
        this.isLoggedIn = true;
        this.user.name = "Admin"; // Set nama pengguna
        this.user.role = "Admin"; // Set peran pengguna
        localStorage.setItem("isLoggedIn", true); // Simpan status login
        this.resetLogoutTimer(); // Reset timer setelah login
      } else {
        alert("Username atau password salah!");
      }
    },

    // Logout function
    logout() {
      this.isLoggedIn = false;
      this.username = "";
      this.password = "";
      this.user.name = ""; // Reset nama pengguna
      this.user.role = ""; // Reset peran pengguna
      localStorage.removeItem("isLoggedIn"); // Hapus status login
      localStorage.removeItem("user"); // Hapus data user
      clearTimeout(this.logoutTimer); // Hentikan timer logout
    },

    resetLogoutTimer() {
      // Hentikan timer yang sedang berjalan
      clearTimeout(this.logoutTimer);
    
      // Mulai timer baru
      this.logoutTimer = setTimeout(() => {
        // Tampilkan SweetAlert spinner dengan hitungan mundur
        let timeLeft = 5; // Waktu hitungan mundur (dalam detik)
        const swalInstance = Swal.fire({
          title: 'Anda akan logout otomatis!',
          html: `Sesi Anda akan berakhir dalam <strong>${timeLeft}</strong> detik.`,
          timer: timeLeft * 1000, // Waktu dalam milidetik
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading(); // Tampilkan spinner
            const timerInterval = setInterval(() => {
              timeLeft -= 1;
              swalInstance.update({
                html: `Sesi Anda akan berakhir dalam <strong>${timeLeft}</strong> detik.`,
              });
              if (timeLeft <= 0) {
                clearInterval(timerInterval);
              }
            }, 1000);
          },
          willClose: () => {
            // Hentikan timer jika pengguna menutup SweetAlert secara manual
            clearTimeout(this.logoutTimer);
          },
        });
    
        // Setelah waktu habis, jalankan fungsi logout
        swalInstance.then(() => {
          this.logout(); // Panggil fungsi logout
          Swal.fire('Anda telah logout!', 'Sesi Anda telah berakhir karena tidak ada aktivitas.', 'info');
        });
      }, this.inactivityDuration); // Waktu inaktivitas sebelum menampilkan SweetAlert
    },

    // Inisialisasi database (ambil data dari API)
    async initDatabase() {
      try {
        this.isLoading = true; // Set global loading state
        const productsFromAPI = await this.fetchProductsFromAPI();

        // Tambahkan state isLoading untuk setiap produk
        this.products = productsFromAPI.map(product => ({
          ...product,
          isLoading: true, // Set loading state untuk setiap produk
        }));

        console.log("Products loaded from API:", this.products);
      } catch (error) {
        console.error("Failed to load products from API:", error);
        this.products = [];
      } finally {
        this.isLoading = false; // Sembunyikan global loading state
      }
    },



    // Fungsi untuk menyembunyikan spinner setelah gambar selesai dimuat
    handleImageLoad(product) {
      product.isLoading = false; // Sembunyikan spinner untuk produk ini
    },


    // Fungsi untuk mengambil data dari API
    async fetchProductsFromAPI() {
      try {
        const response = await fetch('https://publicconcerns.online/api/products'); // Sesuaikan dengan endpoint API Anda
        if (!response.ok) {
          throw new Error('Failed to fetch products from API');
        }
        const data = await response.json(); // Data adalah array langsung
        console.log(data); // Log data untuk memastikan struktur respons
        return data; // Kembalikan data langsung
      } catch (error) {
        console.error('Error fetching products:', error);
        return []; // Kembalikan array kosong jika terjadi error
      }
    },

    // Fungsi untuk memuat data sampel dari file JSON lokal
    async startWithSampleData() {
      const response = await fetch("data/sample.json");
      const data = await response.json();
      this.products = data.products;
      this.setFirstTime(false);
    },

    // Fungsi untuk memulai dengan data kosong
    startBlank() {
      this.setFirstTime(false);
    },

    // Fungsi untuk mengatur firstTime
    setFirstTime(firstTime) {
      this.firstTime = firstTime;
      if (firstTime) {
        localStorage.removeItem("first_time");
      } else {
        localStorage.setItem("first_time", new Date().getTime());
      }
    },

    // Fungsi untuk memfilter produk berdasarkan keyword
    filteredProducts() {
      if (!this.products || this.products.length === 0) {
        return []; // Kembalikan array kosong jika products belum diinisialisasi
      }
      const rg = this.keyword ? new RegExp(this.keyword, "gi") : null;
      return this.products.filter((p) => !rg || p.name.match(rg));
    },

    // Fungsi untuk menambahkan produk ke keranjang
    // addToCart(product) {
    //   const index = this.findCartIndex(product);
    //   if (index === -1) {
    //     this.cart.push({
    //       productId: product.id,
    //       image: product.image,
    //       name: product.name,
    //       price: product.price,
    //       option: product.option,
    //       qty: 1,
    //     });
    //   } else {
    //     this.cart[index].qty += 1;
    //   }
    //   this.beep();
    //   this.updateChange();
    // },
    addToCart(product) {
      const index = this.findCartIndex(product);

      // Tampilkan spinner untuk produk yang sedang diproses
      product.isLoading = true;

      // Simulasikan proses loading (opsional)
      setTimeout(() => {
        if (index === -1) {
          this.cart.push({
            productId: product.id,
            image: product.image,
            name: product.name,
            price: product.price,
            option: product.option,
            qty: 1,
          });
        } else {
          this.cart[index].qty += 1;
        }

        // Sembunyikan spinner setelah selesai
        product.isLoading = false;
        this.beep();
        this.updateChange();
      }, 500); // Simulasi loading selama 500ms
    },

    // Fungsi untuk mencari index produk di keranjang
    findCartIndex(product) {
      return this.cart.findIndex((p) => p.productId === product.id);
    },

    // Fungsi untuk menambah/mengurangi jumlah produk di keranjang
    // addQty(item, qty) {
    //   const index = this.cart.findIndex((i) => i.productId === item.productId);
    //   if (index === -1) return;

    //   const afterAdd = item.qty + qty;
    //   if (afterAdd === 0) {
    //     this.cart.splice(index, 1);
    //     this.clearSound();
    //   } else {
    //     this.cart[index].qty = afterAdd;
    //     this.beep();
    //   }
    //   this.updateChange();
    // },
    addQty(item, qty) {
      const index = this.cart.findIndex((i) => i.productId === item.productId);
      if (index === -1) return;

      // Tampilkan spinner
      item.isLoading = true;

      // Simulasikan proses loading (opsional)
      setTimeout(() => {
        const afterAdd = item.qty + qty;
        if (afterAdd === 0) {
          this.cart.splice(index, 1);
          this.clearSound();
        } else {
          this.cart[index].qty = afterAdd;
          this.beep();
        }

        // Sembunyikan spinner setelah selesai
        item.isLoading = false;
        this.updateChange();
      }, 500); // Simulasi loading selama 500ms
    },

    // Fungsi untuk menambah uang tunai
    addCash(amount) {
      this.cash = (this.cash || 0) + amount;
      this.updateChange();
      this.beep();
    },

    // Fungsi untuk menghitung total item di keranjang
    getItemsCount() {
      return this.cart.reduce((count, item) => count + item.qty, 0);
    },

    // Fungsi untuk memperbarui perubahan uang
    updateChange() {
      this.change = this.cash - this.getTotalPrice();
    },

    // Fungsi untuk memperbarui uang tunai
    updateCash(value) {
      this.cash = parseFloat(value.replace(/[^0-9]+/g, ""));
      this.updateChange();
    },

    // Fungsi untuk menghitung total harga
    getTotalPrice() {
      return this.cart.reduce(
        (total, item) => total + item.qty * item.price,
        0
      );
    },

    // Fungsi untuk mengecek apakah transaksi bisa disubmit
    submitable() {
      return this.change >= 0 && this.cart.length > 0;
    },

    // Fungsi untuk submit transaksi
    submit() {
      const time = new Date();
      this.isShowModalReceipt = true;
      this.receiptNo = `TWPOS-KS-${Math.round(time.getTime() / 1000)}`;
      this.receiptDate = this.dateFormat(time);
      this.resetLogoutTimer(); // Reset timer setelah ada aktivitas
    },

    // Fungsi untuk menutup modal struk
    closeModalReceipt() {
      this.isShowModalReceipt = false;
    },

    // Fungsi untuk memformat tanggal
    dateFormat(date) {
      const formatter = new Intl.DateTimeFormat('id', { dateStyle: 'short', timeStyle: 'short' });
      return formatter.format(date);
    },

    // Fungsi untuk memformat angka
    numberFormat(number) {
      return (number || "")
        .toString()
        .replace(/^0|\./g, "")
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    },

    // Fungsi untuk memformat harga
    priceFormat(number) {
      return number ? `Rp. ${this.numberFormat(number)}` : `Rp. 0`;
    },

    // Fungsi untuk mereset keranjang dan uang tunai
    clear() {
      this.cash = 0;
      this.cart = [];
      this.receiptNo = null;
      this.receiptDate = null;
      this.updateChange();
      this.clearSound();
    },

    // Fungsi untuk memainkan suara beep
    beep() {
      this.playSound("sound/beep-29.mp3");
    },

    // Fungsi untuk memainkan suara clear
    clearSound() {
      this.playSound("sound/button-21.mp3");
    },

    // Fungsi untuk memainkan suara
    playSound(src) {
      const sound = new Audio();
      sound.src = src;
      sound.play();
      sound.onended = () => delete (sound);
    },

    // Fungsi untuk mencetak struk dan melanjutkan
    printAndProceed() {
      const receiptContent = document.getElementById('receipt-content');
      const titleBefore = document.title;
      const printArea = document.getElementById('print-area');

      printArea.innerHTML = receiptContent.innerHTML;
      document.title = this.receiptNo;

      window.print();
      this.isShowModalReceipt = false;

      printArea.innerHTML = '';
      document.title = titleBefore;

      this.clear();
    }
  };
}