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
    },
    info: (msg) => {
      try {
        if (typeof toastr !== 'undefined') toastr.info(msg);
        else console.info('INFO:', msg);
      } catch (e) {
        console.info('INFO (fallback):', msg);
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
    isSidebarOpen: window.innerWidth >= 768, // Open by default on desktop
    currentPage: 'dashboard', // You can set the default page here
    lastSyncTime: null,
    isSyncing: false,
    showDateModal: false,
    transactionDate: null,
    useCustomDate: false,
    autoPrint: true, // New option for auto printing
      // ... existing data properties ...
  communities: [
    { id: 'kom1', name: 'Tanjung Benoa', logo: '/img/communities/benoa.jpg' },
    { id: 'kom2', name: 'Sanur', logo: '/img/communities/sanur.jpg' },
    { id: 'kom3', name: 'Kuta', logo: '/img/communities/kuta.jpg' },
    { id: 'kom4', name: 'Nusa Dua', logo: '/img/communities/nusadua.jpg' }
  ],
  companies: [
    { id: 'comp1', name: 'Bali Watersport', logo: '/img/companies/bali-ws.jpg', discount: 10 },
    { id: 'comp2', name: 'Ocean Paradise', logo: '/img/companies/ocean.jpg', discount: 15 },
    { id: 'comp3', name: 'Sea Safari', logo: '/img/companies/safari.jpg' },
    { id: 'comp4', name: 'Waterbom', logo: '/img/companies/waterbom.jpg', discount: 5 }
  ],
  activeCommunity: '',
  activeCompany: '',
  isSidebarCollapsed:true,
  communityScrollLeft() {
    this.$refs.communitySlider.scrollBy({ left: -200, behavior: 'smooth' });
  },
  communityScrollRight() {
    this.$refs.communitySlider.scrollBy({ left: 200, behavior: 'smooth' });
  },
  companyScrollLeft() {
    this.$refs.companySlider.scrollBy({ left: -200, behavior: 'smooth' });
  },
  companyScrollRight() {
    this.$refs.companySlider.scrollBy({ left: 200, behavior: 'smooth' });
  },

  filteredProducts() {
    return this.products.filter(product => {
      const matchesKeyword = product.name.toLowerCase().includes(this.keyword.toLowerCase()) || 
                            product.category.toLowerCase().includes(this.keyword.toLowerCase());
      const matchesCommunity = !this.activeCommunity || product.communities.includes(this.activeCommunity);
      const matchesCompany = !this.activeCompany || product.companies.includes(this.activeCompany);
      
      return matchesKeyword && matchesCommunity && matchesCompany;
    });
  },
    
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
    
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen;
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

    init() {
      this.initDatabase(); // Make sure this is called inside `x-init` as a method in the Alpine.js data object
      this.checkSession();
      this.startActivityMonitor();
      this.initCharts();
      
      // Load user preference for auto print if available
      const savedAutoPrint = localStorage.getItem('autoPrint');
      if (savedAutoPrint !== null) {
        this.autoPrint = savedAutoPrint === 'true';
      }
    },

    // Added function to initialize charts if needed
    initCharts() {
      try {
        // This is a placeholder for chart initialization
        console.log('Charts initialization would happen here if needed');
        // Implement actual chart initialization if needed
      } catch (error) {
        console.error('Failed to initialize charts:', error);
      }
    },

    useCurrentDate() {
      this.useCustomDate = false;
      safeToastr.info('Using current date/time');
      this.showDateModal = false;
    },

    getTransactionDate() {
      return this.useCustomDate ? new Date(this.transactionDate) : new Date();
    },

    confirmLogout() {
      // Hapus data session
      localStorage.removeItem('authToken');
      localStorage.removeItem('user');
      localStorage.removeItem('lastActivity');

      // Reset state properly - maintain object structure
      this.isLoggedIn = false;
      this.user = { name: '', role: '' }; // Don't set to null
      this.cart = [];
      this.cash = 0;
      this.change = 0;

      this.showLogoutModal = false;
      this.logout();
      // Use safeToastr instead of direct toastr
      safeToastr.success('Anda telah logout dari sistem');
    },

    // Add to your methods
    checkSessionTimeout() {
      if (!this.persistSession || !this.isLoggedIn) return;

      const now = new Date().getTime();
      const storedLastActivity = localStorage.getItem('lastActivity');
      this.lastActivity = storedLastActivity ? parseInt(storedLastActivity) : now;
      
      const timeLeft = this.lastActivity + this.sessionTimeout - now;

      if (timeLeft <= 0) {
        this.logout();
        safeToastr.warning('Your session has expired due to inactivity');
      } else if (timeLeft < 5 * 60 * 1000) { // Warn when 5 minutes left
        const minutesLeft = Math.ceil(timeLeft / (60 * 1000));
        safeToastr.info(`Session will expire in ${minutesLeft} minute(s)`);
      }

      // Check for session validity (authToken and userData) and redirect if needed
      const authToken = localStorage.getItem('authToken');
      const userData = localStorage.getItem('user');

      if (!authToken || !userData) {
        // No session or user data found, redirect to login page
        window.location.href = '/loginPos';
      } else {
        try {
          this.isLoggedIn = true;
          this.user = JSON.parse(userData);
          this.resetLogoutTimer(); // Reset the inactivity timer
        } catch (e) {
          console.error("Error parsing user data:", e);
          this.clearSession();
          // Redirect to login if user data is corrupted
          window.location.href = '/loginPos';
        }
      }
    },

    // Di dalam method requestLogout
    requestLogout() {
      Swal.fire({
        title: 'Logout Confirmation',
        text: "Do you really want to log out?",
        iconHtml: '<div class="animate-pulse"><i class="fas fa-sign-out-alt text-4xl text-purple-500"></i></div>',
        showCancelButton: true,
        confirmButtonColor: '#667eea',
        cancelButtonColor: '#e2e8f0',
        confirmButtonText: '<i class="fas fa-check mr-2"></i>Yes, Logout',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
        customClass: {
          popup: 'rounded-swal',
          confirmButton: 'shadow-lg hover:shadow-purple',
          cancelButton: 'hover:bg-gray-200'
        },
        background: '#ffffff',
        showClass: {
          popup: 'swal2-show-animate',
          backdrop: 'swal2-backdrop-show-animate'
        },
        hideClass: {
          popup: 'swal2-hide-animate',
          backdrop: 'swal2-backdrop-hide-animate'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          this.logout();
        }
      });
    },

    // Logout function
    logout() {
      // Clear local storage for authToken and user data
      localStorage.removeItem('authToken');
      localStorage.removeItem('user');
      localStorage.removeItem('lastActivity');

      // Reset other relevant states
      this.isLoggedIn = false;
      this.user = { name: '', role: '' };
      this.cart = [];
      this.cash = 0;
      this.change = 0;

      // Clear any timers
      clearTimeout(this.logoutTimer);
      clearInterval(this.activityInterval);

      // Show confirmation message or perform further cleanup
      this.isLoading = false;

      // You can trigger a Laravel logout request if needed, this will log the user out on the server-side.
      // Assuming you have a logout route in Laravel
      fetch('/logout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
      }).then(response => response.json())
        .then(data => {
          if (data.success) {
            console.log('User logged out from server');
            window.location.href = '/loginPos'; // Redirect to the login page or another page after logout
          } else {
            console.error('Logout failed from server', data.error);
          }
        }).catch(error => {
          console.error('Logout error', error);
          // Redirect anyway to ensure user is logged out client-side
          window.location.href = '/loginPos';
        });
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
    async login(event) {
      if (event) {
        event.preventDefault();
      }
      
      if (!this.username || !this.password) {
        safeToastr.error("Please enter both username and password");
        return;
      }
      
      try {
        this.isLoggingIn = true;

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
          throw new Error('CSRF token not found');
        }

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
          this.updateActivity(); // Set initial activity timestamp

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
        swalInstance.then((result) => {
          if (result.dismiss !== Swal.DismissReason.backdrop && 
              result.dismiss !== Swal.DismissReason.close && 
              result.dismiss !== Swal.DismissReason.esc) {
            this.logout(); // Panggil fungsi logout
            this.confirmLogout();
            Swal.fire('Anda telah logout!', 'Sesi Anda telah berakhir karena tidak ada aktivitas.', 'info');
          }
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
          isLoading: false, // Initially not loading after fetch
        }));

        console.log("Products loaded from API:", this.products);
      } catch (error) {
        console.error("Failed to load products from API:", error);
        safeToastr.error('Failed to load products. Please try again later.');
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
          this.updateActivity(); // Update activity timestamp
        } catch (e) {
          console.error("Error parsing user data:", e);
          this.clearSession();
        }
      }
    },

    clearSession() {
      localStorage.removeItem('authToken');
      localStorage.removeItem('user');
      localStorage.removeItem('lastActivity');
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
          throw new Error(`Failed to fetch products: ${response.status} ${response.statusText}`);
        }

        const data = await response.json();
        console.log("Products loaded:", data);

        return data.map(product => ({
          ...product,
          isLoading: false
        }));
      } catch (error) {
        console.error('Error fetching products:', error);
        safeToastr.error('Failed to load products. Please check your connection.');
        return [];
      }
    },
    
    // Show animated toast message with icon
    showAnimatedToast(type, message, icon) {
      if (!type || !message) return;
      
      safeToastr[type](`<i class="${icon} mr-2"></i> ${message}`);
    },

    // Fungsi untuk memuat data sampel dari file JSON lokal
    async startWithSampleData() {
      try {
        this.loadingSampleData = true;
        const response = await fetch("data/sample.json");
        
        if (!response.ok) {
          throw new Error(`Failed to load sample data: ${response.status}`);
        }
        
        const data = await response.json();
        this.products = data.products;
        this.setFirstTime(false);
        safeToastr.success('Sample data loaded successfully!');
      } catch (error) {
        console.error('Error loading sample data:', error);
        safeToastr.error('Failed to load sample data');
      } finally {
        this.loadingSampleData = false;
      }
    },

    // Fungsi untuk memulai dengan data kosong
    startBlank() {
      this.setFirstTime(false);
      safeToastr.info('Starting with blank data');
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
      
      if (!this.keyword) {
        return this.products;
      }
      
      try {
        const rg = new RegExp(this.keyword, "gi");
        return this.products.filter((p) => p.name.match(rg));
      } catch (e) {
        // Handle invalid regex
        console.warn('Invalid regex in search:', e);
        return this.products.filter((p) => 
          p.name.toLowerCase().includes(this.keyword.toLowerCase())
        );
      }
    },

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
      }, 300); // Reduced loading time for better UX
    },

    // Fungsi untuk mencari index produk di keranjang
    findCartIndex(product) {
      return this.cart.findIndex((p) => p.productId === product.id);
    },

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
      }, 300); // Reduced loading time for better UX
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
      if (!value) {
        this.cash = 0;
      } else {
        this.cash = parseFloat(value.replace(/[^0-9]+/g, ""));
      }
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

    // Toggle auto print setting
    toggleAutoPrint() {
      this.autoPrint = !this.autoPrint;
      localStorage.setItem('autoPrint', this.autoPrint);
      safeToastr.info(`Auto print ${this.autoPrint ? 'enabled' : 'disabled'}`);
    },





    submit() {
      if (!this.useCustomDate && !this.transactionDate) {
        safeToastr.error('Please select transaction date first');
        this.showDateSetting();
        return;
      }
    
      const time = this.getTransactionDate();
      this.isShowModalReceipt = true;
      this.receiptNo = `TWPOS-KS-${Math.round(time.getTime() / 1000)}`;
      this.receiptDate = this.dateFormat(time);
      this.resetLogoutTimer();
    
      if (this.autoPrint) {
        this.$nextTick(() => {
          setTimeout(() => {
            this.printAndProceed();
          }, 100);
        });
      }
    },

    // Fungsi untuk menutup modal struk
    closeModalReceipt() {
      this.isShowModalReceipt = false;
    },

    // Fungsi untuk memformat tanggal
    dateFormat(date) {
      try {
        const formatter = new Intl.DateTimeFormat('id', { dateStyle: 'short', timeStyle: 'short' });
        return formatter.format(date);
      } catch (e) {
        console.error('Error formatting date:', e);
        return date.toLocaleString('id'); // Fallback
      }
    },

    // Fungsi untuk memformat angka
    numberFormat(number) {
      if (number === null || number === undefined) return "0";
      
      return number.toString()
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
      try {
        const sound = new Audio();
        sound.src = src;
        sound.play()
          .catch(e => console.warn('Sound playback failed:', e));
        sound.onended = () => delete(sound);
      } catch (e) {
        console.warn('Error playing sound:', e);
      }
    },

    // Fungsi untuk mencetak struk dan melanjutkan
    printAndProceed() {
      try {
        window.print();
        
        // Delay untuk memastikan print dialog terbuka
        setTimeout(() => {
          this.isShowModalReceipt = false;
          this.saveTransaction();
          this.clear();
          safeToastr.success('Transaction completed successfully');
        }, 500);
      } catch (error) {
        console.error('Print error:', error);
        safeToastr.error('Failed to print receipt. Please try again.');
      }
    },
    
    // Save transaction to history (placeholder)
    saveTransaction() {
      try {
        // Create transaction object
        const transaction = {
          id: this.receiptNo,
          date: this.receiptDate,
          items: [...this.cart],
          total: this.getTotalPrice(),
          cash: this.cash,
          change: this.change
        };
        
        // Get existing transactions or initialize empty array
        const existingTransactions = JSON.parse(localStorage.getItem('transactions') || '[]');
        
        // Add new transaction
        existingTransactions.push(transaction);
        
        // Save back to localStorage
        localStorage.setItem('transactions', JSON.stringify(existingTransactions));
        
        console.log('Transaction saved:', transaction);
      } catch (e) {
        console.error('Error saving transaction:', e);
      }
    }
  };
}