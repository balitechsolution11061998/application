function initApp() {
  // Initialize toastr with safe fallback
  window.safeToastr = {
    success: (msg) => {
      try {
        if (typeof toastr !== 'undefined') toastr.success(msg);
        else console.log('SUCCESS:', msg);
      } catch (e) {
        console.log('SUCCESS (fallback):', msg);
      }
    },
    error: (msg) => {
      try {
        if (typeof toastr !== 'undefined') toastr.error(msg);
        else console.error('ERROR:', msg);
      } catch (e) {
        console.error('ERROR (fallback):', msg);
      }
    },
    warning: (msg) => {
      try {
        if (typeof toastr !== 'undefined') toastr.warning(msg);
        else console.warn('WARNING:', msg);
      } catch (e) {
        console.warn('WARNING (fallback):', msg);
      }
    }
  };

  // Initialize toastr options if available
  if (typeof toastr !== 'undefined') {
    toastr.options = {
      closeButton: true,
      progressBar: true,
      positionClass: 'toast-top-right',
      preventDuplicates: true,
      timeOut: 3000
    };
  }
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
    showUserModal: false,
    showLogoutModal: false,
    username: "", // Username input
    password: "", // Password input
    user: {      // Tambahkan state user
      name: "",  // Nama pengguna
      role: ""   // Peran pengguna
    },
    logoutTimer: null, // Timer untuk auto logout
    inactivityDuration: 5 * 60 * 1000, // 5 menit dalam milidetik
    isLoggingIn: false,
    persistSession: true, // New config option
    sessionTimeout: 30 * 60 * 1000, // 30 minutes in milliseconds
    lastActivity: null,
    // ... existing properties ...
    showDateModal: false,
    transactionDate: null,
    useCustomDate: false,
    // ... rest of your code ...
    hasActiveSession() {
      const authToken = localStorage.getItem('authToken');
      const userData = localStorage.getItem('user');
      return authToken && userData;
    },
    showDateSetting() {
      // Set default to current date/time
      const now = new Date();
      // Format for datetime-local input (YYYY-MM-DDTHH:MM)
      this.transactionDate = now.toISOString().slice(0, 16);
      this.showDateModal = true;
    },
    
    confirmDate() {
      if (!this.transactionDate) {
        safeToastr.error('Please select a valid date and time');
        return;
      }
      
      const selectedDate = new Date(this.transactionDate);
      const now = new Date();
      
      // Validate date is not in the future
      if (selectedDate > now) {
        safeToastr.error('Transaction date cannot be in the future');
        return;
      }
      
      this.useCustomDate = true;
      safeToastr.success('Transaction date set successfully');
      this.showDateModal = false;
    },
    
    useCurrentDate() {
      this.useCustomDate = false;
      safeToastr.info('Using current date/time');
      this.showDateModal = false;
    },
    
    getTransactionDate() {
      return this.useCustomDate ? new Date(this.transactionDate) : new Date();
    },
    // Fungsi logout
    requestLogout() {
      this.showLogoutModal = true;
    },

    confirmLogout() {
      // Hapus data session
      localStorage.removeItem('authToken');
      localStorage.removeItem('user');
    
      // Reset state properly - maintain object structure
      this.isLoggedIn = false;
      this.user = { name: '', role: '' }; // Don't set to null
      this.cart = [];
      this.cash = 0;
      this.change = 0;
    
      this.showLogoutModal = false;
    
      // Use safeToastr instead of direct toastr
      safeToastr.success('Anda telah logout dari sistem');
    },

    // Add to your methods
    checkSessionTimeout() {
      if (!this.persistSession) return;

      const now = new Date().getTime();
      const timeLeft = this.lastActivity + this.sessionTimeout - now;

      if (timeLeft <= 0) {
        this.logout();
        safeToastr.warning('Your session has expired due to inactivity');
      } else if (timeLeft < 5 * 60 * 1000) { // Warn when 5 minutes left
        const minutesLeft = Math.ceil(timeLeft / (60 * 1000));
        safeToastr.info(`Session will expire in ${minutesLeft} minute(s)`);
      }
    },

    updateActivity() {
      this.lastActivity = new Date().getTime();
      localStorage.setItem('lastActivity', this.lastActivity);
    },

    startActivityMonitor() {
      // Check every minute
      this.activityInterval = setInterval(() => this.checkSessionTimeout(), 60000);

      // Track user activity
      ['click', 'mousemove', 'keypress'].forEach(event => {
        document.addEventListener(event, () => this.updateActivity());
      });
    },

    // Login function
    async login() {
      try {
        this.isLoggingIn = true;

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        // Show loading state
        this.isLoading = true;

        const response = await fetch('/login/pos', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            login: this.username,
            password: this.password,
            _token: csrfToken
          })
        });

        const data = await response.json();

        if (response.ok && data.success) {
          // Login successful
          this.isLoggedIn = true;
          this.user.name = data.user.name;
          this.user.role = data.user.role;

          // Store session data
          localStorage.setItem('authToken', data.access_token || 'dummy-token');
          localStorage.setItem('user', JSON.stringify(data.user));

          // Show success message
          safeToastr.success('Login successful! Welcome back!');

          // Reset login form
          this.username = '';
          this.password = '';

          // Start inactivity timer
          this.resetLogoutTimer();

          // Redirect if needed
          if (data.redirect) {
            window.location.href = data.redirect;
          }
        } else {
          // Login failed
          safeToastr.error(data.error || "Login failed. Please check your credentials.");
        }
      } catch (error) {
        console.error("Login error:", error);
        safeToastr.error('An error occurred during login. Please try again.');
      } finally {
        this.isLoading = false;
        this.isLoggingIn = false;
      }
    },


    // Logout function
    logout() {
      console.log('logout');
      this.isLoggedIn = false;
      this.username = "";
      this.password = "";
      this.user.name = ""; // Reset nama pengguna
      this.user.role = ""; // Reset peran pengguna
      localStorage.removeItem("isLoggedIn"); // Hapus status login
      localStorage.removeItem("access_token"); // Hapus access token
      clearTimeout(this.logoutTimer); // Hentikan timer logout

      // Tampilkan halaman login
      this.isLoading = false;
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
          this.confirmLogout();
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

    // Add this to your methods
    checkSession() {
      const authToken = localStorage.getItem('authToken');
      const userData = localStorage.getItem('user');

      if (authToken && userData) {
        try {
          this.isLoggedIn = true;
          this.user = JSON.parse(userData);
          this.resetLogoutTimer(); // Start inactivity timer
        } catch (e) {
          console.error("Error parsing user data:", e);
          this.clearSession();
        }
      }
    },

    clearSession() {
      localStorage.removeItem('authToken');
      localStorage.removeItem('user');
      this.isLoggedIn = false;
      this.user = { name: '', role: '' };
    },


    // Fungsi untuk menyembunyikan spinner setelah gambar selesai dimuat
    handleImageLoad(product) {
      product.isLoading = false; // Sembunyikan spinner untuk produk ini
    },


    // Fungsi untuk mengambil data dari API
    async fetchProductsFromAPI() {
      try {
        // CORS Solution: Using proxy in development
        const apiUrl = 'https://www.publicconcerns.online/api/products';

        const response = await fetch(apiUrl, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        if (!response.ok) {
          throw new Error('Failed to fetch products from API');
        }

        const data = await response.json();
        console.log("Products loaded:", data);

        // Add loading state for each product
        return data.map(product => ({
          ...product,
          isLoading: true
        }));
      } catch (error) {
        console.error('Error fetching products:', error);
        this.showAnimatedToast('error', 'Gagal memuat produk', 'fas fa-exclamation-circle');
        return [];
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
  
        // Check if date is not set
      if (!this.useCustomDate && !this.transactionDate) {
        safeToastr.error('Please select a transaction date first');
        this.showDateSetting(); // Open date modal
        return; // Exit the function
      }

      const time = this.getTransactionDate();
      this.isShowModalReceipt = true;
      this.receiptNo = `TWPOS-KS-${Math.round(time.getTime() / 1000)}`;
      this.receiptDate = this.dateFormat(time);
      this.resetLogoutTimer();
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