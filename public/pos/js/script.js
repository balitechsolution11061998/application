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
    isShowModalReceipt: false,
    receiptNo: null,
    receiptDate: null,
    isLoading: false,
    isLoggedIn: false,
    showUserModal: false,
    showLogoutModal: false,
    username: "",
    password: "",
    user: {
      name: "",
      role: ""
    },
    logoutTimer: null,
    inactivityDuration: 5 * 60 * 1000,
    isLoggingIn: false,
    persistSession: true,
    sessionTimeout: 30 * 60 * 1000,
    lastActivity: null,
    isSidebarOpen: window.innerWidth >= 768,
    currentPage: 'dashboard',
    lastSyncTime: null,
    isSyncing: false,
    showDateModal: false,
    useCustomDate: false,
    isSidebarCollapsed: false,
    activeCategory: '',
    categories: [],
    taxRate: 11,
    discountAmount: 0,
    showCustomerModal: false,
    autoPrint: true,
    activeCommunity: '',
    communities: ['Drive A', 'Drive B', 'Drive C', 'Company X', 'Company Y'],
    customer: {
      name: '',
      phone: '',
      email: ''
    },
    staffName: 'John Doe',
    // ... existing data properties ...
    paymentMethods: [
      { value: 'cash', label: 'Cash', icon: 'fas fa-money-bill-wave' },
      { value: 'credit_card', label: 'Credit Card', icon: 'fas fa-credit-card' },
      { value: 'bank_transfer', label: 'Bank Transfer', icon: 'fas fa-university' },
      { value: 'e_wallet', label: 'E-Wallet', icon: 'fas fa-mobile-alt' }
    ],
    selectedPaymentMethod: 'cash',
    showPaymentModal: false,
    // ... rest of your data properties ...
    cash: 0,
    change: 0,
    transactionDate: new Date().toISOString().slice(0, 16),
    showPaymentModal: false,
    creditCard: {
      number: '',
      expiry: '',
      cvv: ''
    },
    bankTransfer: {
      selectedBank: '',
      reference: '',
      banks: [
        { id: 'bca', name: 'BCA' },
        { id: 'mandiri', name: 'Mandiri' },
        { id: 'bni', name: 'BNI' },
        { id: 'bri', name: 'BRI' }
      ]
    },
    eWallet: {
      selectedProvider: '',
      phoneNumber: '',
      providers: [
        { id: 'gopay', name: 'GoPay' },
        { id: 'ovo', name: 'OVO' },
        { id: 'dana', name: 'DANA' },
        { id: 'linkaja', name: 'LinkAja' }
      ]
    },

    hasActiveSession() {
      const authToken = localStorage.getItem('authToken');
      const userData = localStorage.getItem('user');
      return authToken && userData;
    },

    saveCustomerInfo() {
      this.showCustomerModal = false;
      safeToastr.success('Customer information saved');
    },

    filteredProducts() {
      return this.products.filter(product => {
        const matchesCategory = !this.activeCategory || product.category === this.activeCategory;
        const matchesCommunity = !this.activeCommunity || product.community === this.activeCommunity;
        const matchesKeyword = !this.keyword ||
          product.name.toLowerCase().includes(this.keyword.toLowerCase()) ||
          (product.sku && product.sku.toLowerCase().includes(this.keyword.toLowerCase())) ||
          (product.barcode && product.barcode.toLowerCase().includes(this.keyword.toLowerCase()));

        return matchesCategory && matchesCommunity && matchesKeyword;
      });
    },

    getSubtotal() {
      return this.cart.reduce(
        (total, item) => total + item.qty * (item.discount ? item.price * (1 - item.discount / 100) : item.price),
        0
      );
    },

    getTaxAmount() {
      return this.getSubtotal() * (this.taxRate / 100);
    },

    getTotalPrice() {
      return this.getSubtotal() + this.getTaxAmount() - this.discountAmount;
    },

    showDateSetting() {
      const now = new Date();
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

      if (selectedDate > now) {
        safeToastr.error('Transaction date cannot be in the future');
        return;
      }

      this.useCustomDate = true;
      safeToastr.success('Transaction date set successfully');
      this.showDateModal = false;
    },

    init() {
      this.initDatabase();
      this.checkSession();
      this.startActivityMonitor();
      this.initCharts();

      const savedAutoPrint = localStorage.getItem('autoPrint');
      if (savedAutoPrint !== null) {
        this.autoPrint = savedAutoPrint === 'true';
      }
    },

    initCharts() {
      try {
        console.log('Charts initialization would happen here if needed');
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
      localStorage.removeItem('authToken');
      localStorage.removeItem('user');
      localStorage.removeItem('lastActivity');

      this.isLoggedIn = false;
      this.user = { name: '', role: '' };
      this.cart = [];
      this.cash = 0;
      this.change = 0;

      this.showLogoutModal = false;
      this.logout();
      safeToastr.success('Anda telah logout dari sistem');
    },

    checkSessionTimeout() {
      if (!this.persistSession || !this.isLoggedIn) return;

      const now = new Date().getTime();
      const storedLastActivity = localStorage.getItem('lastActivity');
      this.lastActivity = storedLastActivity ? parseInt(storedLastActivity) : now;

      const timeLeft = this.lastActivity + this.sessionTimeout - now;

      if (timeLeft <= 0) {
        this.logout();
        safeToastr.warning('Your session has expired due to inactivity');
      } else if (timeLeft < 5 * 60 * 1000) {
        const minutesLeft = Math.ceil(timeLeft / (60 * 1000));
        safeToastr.info(`Session will expire in ${minutesLeft} minute(s)`);
      }

      const authToken = localStorage.getItem('authToken');
      const userData = localStorage.getItem('user');

      if (!authToken || !userData) {
        window.location.href = '/loginPos';
      } else {
        try {
          this.isLoggedIn = true;
          this.user = JSON.parse(userData);
          this.resetLogoutTimer();
          this.updateActivity();
        } catch (e) {
          console.error("Error parsing user data:", e);
          this.clearSession();
          window.location.href = '/loginPos';
        }
      }
    },

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

    logout() {
      localStorage.removeItem('authToken');
      localStorage.removeItem('user');
      localStorage.removeItem('lastActivity');

      this.isLoggedIn = false;
      this.user = { name: '', role: '' };
      this.cart = [];
      this.cash = 0;
      this.change = 0;

      clearTimeout(this.logoutTimer);
      clearInterval(this.activityInterval);

      this.isLoading = false;

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
            window.location.href = '/loginPos';
          } else {
            console.error('Logout failed from server', data.error);
          }
        }).catch(error => {
          console.error('Logout error', error);
          window.location.href = '/loginPos';
        });
    },

    updateActivity() {
      this.lastActivity = new Date().getTime();
      localStorage.setItem('lastActivity', this.lastActivity);
    },

    startActivityMonitor() {
      this.activityInterval = setInterval(() => this.checkSessionTimeout(), 60000);

      ['click', 'mousemove', 'keypress'].forEach(event => {
        document.addEventListener(event, () => this.updateActivity());
      });
    },

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

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
          throw new Error('CSRF token not found');
        }

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
          this.isLoggedIn = true;
          this.user.name = data.user.name;
          this.user.role = data.user.role;

          localStorage.setItem('authToken', data.access_token || 'dummy-token');
          localStorage.setItem('user', JSON.stringify(data.user));
          this.updateActivity();

          safeToastr.success('Login successful! Welcome back!');

          this.username = '';
          this.password = '';

          this.resetLogoutTimer();

          if (data.redirect) {
            window.location.href = data.redirect;
          }
        } else {
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
      clearTimeout(this.logoutTimer);

      this.logoutTimer = setTimeout(() => {
        let timeLeft = 5;
        const swalInstance = Swal.fire({
          title: 'Anda akan logout otomatis!',
          html: `Sesi Anda akan berakhir dalam <strong>${timeLeft}</strong> detik.`,
          timer: timeLeft * 1000,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading();
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
            clearTimeout(this.logoutTimer);
          },
        });

        swalInstance.then((result) => {
          if (result.dismiss !== Swal.DismissReason.backdrop &&
            result.dismiss !== Swal.DismissReason.close &&
            result.dismiss !== Swal.DismissReason.esc) {
            this.logout();
            this.confirmLogout();
            Swal.fire('Anda telah logout!', 'Sesi Anda telah berakhir karena tidak ada aktivitas.', 'info');
          }
        });
      }, this.inactivityDuration);
    },

    async initDatabase() {
      try {
        this.isLoading = true;
        const productsFromAPI = await this.fetchProductsFromAPI();

        this.products = productsFromAPI.map(product => ({
          ...product,
          isLoading: false,
        }));

        console.log("Products loaded from API:", this.products);
      } catch (error) {
        console.error("Failed to load products from API:", error);
        safeToastr.error('Failed to load products. Please try again later.');
        this.products = [];
      } finally {
        this.isLoading = false;
      }
    },

    checkSession() {
      const authToken = localStorage.getItem('authToken');
      const userData = localStorage.getItem('user');

      if (authToken && userData) {
        try {
          this.isLoggedIn = true;
          this.user = JSON.parse(userData);
          this.resetLogoutTimer();
          this.updateActivity();
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

    handleImageLoad(product) {
      product.isLoading = false;
    },

    async fetchProductsFromAPI() {
      try {
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

    showAnimatedToast(type, message, icon) {
      if (!type || !message) return;

      safeToastr[type](`<i class="${icon} mr-2"></i> ${message}`);
    },

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

    startBlank() {
      this.setFirstTime(false);
      safeToastr.info('Starting with blank data');
    },

    setFirstTime(firstTime) {
      this.firstTime = firstTime;
      if (firstTime) {
        localStorage.removeItem("first_time");
      } else {
        localStorage.setItem("first_time", new Date().getTime());
      }
    },

    filteredProducts() {
      if (!this.products || this.products.length === 0) {
        return [];
      }

      if (!this.keyword) {
        return this.products;
      }

      try {
        const rg = new RegExp(this.keyword, "gi");
        return this.products.filter((p) => p.name.match(rg));
      } catch (e) {
        console.warn('Invalid regex in search:', e);
        return this.products.filter((p) =>
          p.name.toLowerCase().includes(this.keyword.toLowerCase())
        );
      }
    },

    addToCart(product) {
      const index = this.findCartIndex(product);

      product.isLoading = true;

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

        product.isLoading = false;
        this.beep();
        this.updateChange();
      }, 300);
    },

    findCartIndex(product) {
      return this.cart.findIndex((p) => p.productId === product.id);
    },

    addQty(item, qty) {
      const index = this.cart.findIndex((i) => i.productId === item.productId);
      if (index === -1) return;

      item.isLoading = true;

      setTimeout(() => {
        const afterAdd = item.qty + qty;
        if (afterAdd === 0) {
          this.cart.splice(index, 1);
          this.clearSound();
        } else {
          this.cart[index].qty = afterAdd;
          this.beep();
        }

        item.isLoading = false;
        this.updateChange();
      }, 300);
    },

    addCash(amount) {
      this.cash = (this.cash || 0) + amount;
      this.updateChange();
      this.beep();
    },

    getItemsCount() {
      return this.cart.reduce((count, item) => count + item.qty, 0);
    },

    updateChange() {
      this.change = this.cash - this.getTotalPrice();
    },

    updateCash(value) {
      if (!value) {
        this.cash = 0;
      } else {
        this.cash = parseFloat(value.replace(/[^0-9]+/g, ""));
      }
      this.updateChange();
    },

    getTotalPrice() {
      return this.cart.reduce(
        (total, item) => total + item.qty * item.price,
        0
      );
    },

    submitable() {
      return this.change >= 0 && this.cart.length > 0;
    },

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

    closeModalReceipt() {
      this.isShowModalReceipt = false;
    },

    dateFormat(date) {
      try {
        const formatter = new Intl.DateTimeFormat('id', { dateStyle: 'short', timeStyle: 'short' });
        return formatter.format(date);
      } catch (e) {
        console.error('Error formatting date:', e);
        return date.toLocaleString('id');
      }
    },

    numberFormat(number) {
      if (number === null || number === undefined) return "0";

      return number.toString()
        .replace(/^0|\./g, "")
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    },

    priceFormat(number) {
      return number ? `Rp. ${this.numberFormat(number)}` : `Rp. 0`;
    },

    clear() {
      this.cash = 0;
      this.cart = [];
      this.receiptNo = null;
      this.receiptDate = null;
      this.updateChange();
      this.clearSound();
    },

    beep() {
      this.playSound("sound/beep-29.mp3");
    },

    clearSound() {
      this.playSound("sound/button-21.mp3");
    },

    playSound(src) {
      try {
        const sound = new Audio();
        sound.src = src;
        sound.play()
          .catch(e => console.warn('Sound playback failed:', e));
        sound.onended = () => delete (sound);
      } catch (e) {
        console.warn('Error playing sound:', e);
      }
    },

    printAndProceed() {
      try {
        window.print();

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

    saveTransaction() {
      try {
        const transaction = {
          id: this.receiptNo,
          date: this.receiptDate,
          items: [...this.cart],
          total: this.getTotalPrice(),
          cash: this.cash,
          change: this.change
        };

        const existingTransactions = JSON.parse(localStorage.getItem('transactions') || '[]');

        existingTransactions.push(transaction);

        localStorage.setItem('transactions', JSON.stringify(existingTransactions));

        console.log('Transaction saved:', transaction);
      } catch (e) {
        console.error('Error saving transaction:', e);
      }
    }
  };
}