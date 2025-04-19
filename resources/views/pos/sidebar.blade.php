<!-- Sidebar -->
<div class="hide-print flex flex-col bg-gradient-to-b from-indigo-700 to-indigo-900 text-white shadow-xl transition-all duration-300 ease-in-out"
     :class="{ 'w-20': isSidebarCollapsed, 'w-64': !isSidebarCollapsed }">
  
  <!-- Logo and Brand - Collapsible -->
  <div class="p-4 border-b border-indigo-800 flex items-center justify-center hover:bg-indigo-800/30 transition-all duration-300 rounded-b-2xl"
       :class="{ 'px-2': isSidebarCollapsed }">
    <div class="flex flex-col items-center" :class="{ 'flex-row': isSidebarCollapsed }">
      <div class="w-10 h-10 rounded-xl bg-white p-1 shadow-lg overflow-hidden transition-all duration-300 hover:rotate-6 hover:scale-110"
           :class="{ 'mb-0': isSidebarCollapsed, 'mb-2': !isSidebarCollapsed }">
        <img src="/img/logo/logotamansari.jpeg" alt="Taman Sari Logo" class="h-full w-full object-cover rounded-lg">
      </div>
      <div class="text-center transition-opacity duration-300" :class="{ 'opacity-0 w-0 h-0': isSidebarCollapsed, 'opacity-100': !isSidebarCollapsed }">
        <h1 class="text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-indigo-200">Taman Sari</h1>
        <p class="text-xs text-indigo-200/80 mt-0.5">Point of Sale</p>
      </div>
    </div>
  </div>

  <!-- User Info - Collapsible -->
  <div class="p-3 border-b border-indigo-800/50 flex items-center justify-center hover:bg-indigo-800/30 transition-all duration-300 rounded-lg mx-2 my-2"
       :class="{ 'px-2': isSidebarCollapsed }">
    <div class="flex items-center group" :class="{ 'justify-center': isSidebarCollapsed }">
      <div class="relative">
        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-300 to-indigo-400 flex items-center justify-center shadow-inner transition-all duration-300 group-hover:rotate-6">
          <i class="fas fa-user text-indigo-700 text-sm"></i>
        </div>
        <span class="absolute bottom-0 right-0 w-2 h-2 bg-green-400 rounded-full border border-indigo-800 animate-pulse"></span>
      </div>
      <div class="ml-2 transition-all duration-300" :class="{ 'opacity-0 w-0 h-0': isSidebarCollapsed, 'opacity-100': !isSidebarCollapsed }">
        <p class="text-sm font-medium text-white/90" x-text="username || 'Guest'"></p>
      </div>
    </div>
  </div>

  <!-- Navigation Menu -->
  <nav class="flex-1 overflow-y-auto py-2 px-2">
    <!-- Toggle Button - Centered when collapsed -->
    <div class="flex mb-2" :class="{ 'justify-center': isSidebarCollapsed }">
      <button @click="isSidebarCollapsed = !isSidebarCollapsed" 
        class="p-2 rounded-xl bg-indigo-800/50 text-white hover:bg-indigo-600 transition-all duration-300 hover:shadow-lg hover:scale-105"
        :title="isSidebarCollapsed ? 'Expand menu' : 'Collapse menu'">
        <i :class="isSidebarCollapsed ? 'fas fa-chevron-right text-xs' : 'fas fa-chevron-left text-xs'"></i>
      </button>
    </div>

    <ul class="space-y-1">
      <!-- Dashboard -->
      <li>
        <a href="/pos/dashboard" 
          class="sidebar-item flex items-center px-3 py-2 rounded-xl hover:bg-indigo-600/90 transition-all duration-300 group"
          :class="{ 
            'bg-indigo-600/80 shadow-md': currentPage === 'dashboard', 
            'justify-center': isSidebarCollapsed,
            'px-3': !isSidebarCollapsed
          }">
          <div class="flex items-center justify-center w-7 h-7 rounded-xl bg-indigo-800/50 group-hover:bg-white/20 transition-all duration-300">
            <i class="fas fa-tachometer-alt text-xs group-hover:scale-110 transition-transform"></i>
          </div>
          <span class="ml-3 text-sm font-medium text-white/90 group-hover:text-white transition-all"
                :class="{ 'opacity-0 w-0 h-0': isSidebarCollapsed, 'opacity-100': !isSidebarCollapsed }">Dashboard</span>
          <span x-show="isSidebarCollapsed" class="sr-only">Dashboard</span>
          <div x-show="isSidebarCollapsed && currentPage === 'dashboard'" class="absolute right-2 w-1.5 h-1.5 bg-white rounded-full"></div>
        </a>
      </li>

      <!-- POS -->
      <li>
        <a href="/poskasir" 
          class="sidebar-item flex items-center px-3 py-2 rounded-xl hover:bg-indigo-600/90 transition-all duration-300 group"
          :class="{ 
            'bg-indigo-600/80 shadow-md': currentPage === 'pos', 
            'justify-center': isSidebarCollapsed,
            'px-3': !isSidebarCollapsed
          }">
          <div class="flex items-center justify-center w-7 h-7 rounded-xl bg-indigo-800/50 group-hover:bg-white/20 transition-all duration-300">
            <i class="fas fa-cash-register text-xs group-hover:scale-110 transition-transform"></i>
          </div>
          <span class="ml-3 text-sm font-medium text-white/90 group-hover:text-white transition-all"
                :class="{ 'opacity-0 w-0 h-0': isSidebarCollapsed, 'opacity-100': !isSidebarCollapsed }">POS</span>
          <span x-show="isSidebarCollapsed" class="sr-only">POS</span>
          <div x-show="isSidebarCollapsed && currentPage === 'pos'" class="absolute right-2 w-1.5 h-1.5 bg-white rounded-full"></div>
        </a>
      </li>

      <!-- Products -->
      <li>
        <a href="/pos/products" 
          class="sidebar-item flex items-center px-3 py-2 rounded-xl hover:bg-indigo-600/90 transition-all duration-300 group"
          :class="{ 
            'bg-indigo-600/80 shadow-md': currentPage === 'products', 
            'justify-center': isSidebarCollapsed,
            'px-3': !isSidebarCollapsed
          }">
          <div class="flex items-center justify-center w-7 h-7 rounded-xl bg-indigo-800/50 group-hover:bg-white/20 transition-all duration-300">
            <i class="fas fa-box-open text-xs group-hover:scale-110 transition-transform"></i>
          </div>
          <span class="ml-3 text-sm font-medium text-white/90 group-hover:text-white transition-all"
                :class="{ 'opacity-0 w-0 h-0': isSidebarCollapsed, 'opacity-100': !isSidebarCollapsed }">Products</span>
          <span x-show="isSidebarCollapsed" class="sr-only">Products</span>
          <div x-show="isSidebarCollapsed && currentPage === 'products'" class="absolute right-2 w-1.5 h-1.5 bg-white rounded-full"></div>
        </a>
      </li>

      <!-- Orders -->
      <li>
        <a href="/pos/orders" 
          class="sidebar-item flex items-center px-3 py-2 rounded-xl hover:bg-indigo-600/90 transition-all duration-300 group"
          :class="{ 
            'bg-indigo-600/80 shadow-md': currentPage === 'orders', 
            'justify-center': isSidebarCollapsed,
            'px-3': !isSidebarCollapsed
          }">
          <div class="flex items-center justify-center w-7 h-7 rounded-xl bg-indigo-800/50 group-hover:bg-white/20 transition-all duration-300">
            <i class="fas fa-shopping-bag text-xs group-hover:scale-110 transition-transform"></i>
          </div>
          <span class="ml-3 text-sm font-medium text-white/90 group-hover:text-white transition-all"
                :class="{ 'opacity-0 w-0 h-0': isSidebarCollapsed, 'opacity-100': !isSidebarCollapsed }">Orders</span>
          <span x-show="isSidebarCollapsed" class="sr-only">Orders</span>
          <div x-show="isSidebarCollapsed && currentPage === 'orders'" class="absolute right-2 w-1.5 h-1.5 bg-white rounded-full"></div>
        </a>
      </li>

      <!-- Customers -->
      <li>
        <a href="/pos/customers" 
          class="sidebar-item flex items-center px-3 py-2 rounded-xl hover:bg-indigo-600/90 transition-all duration-300 group"
          :class="{ 
            'bg-indigo-600/80 shadow-md': currentPage === 'customers', 
            'justify-center': isSidebarCollapsed,
            'px-3': !isSidebarCollapsed
          }">
          <div class="flex items-center justify-center w-7 h-7 rounded-xl bg-indigo-800/50 group-hover:bg-white/20 transition-all duration-300">
            <i class="fas fa-users text-xs group-hover:scale-110 transition-transform"></i>
          </div>
          <span class="ml-3 text-sm font-medium text-white/90 group-hover:text-white transition-all"
                :class="{ 'opacity-0 w-0 h-0': isSidebarCollapsed, 'opacity-100': !isSidebarCollapsed }">Customers</span>
          <span x-show="isSidebarCollapsed" class="sr-only">Customers</span>
          <div x-show="isSidebarCollapsed && currentPage === 'customers'" class="absolute right-2 w-1.5 h-1.5 bg-white rounded-full"></div>
        </a>
      </li>

      <!-- Reports -->
      <li>
        <a href="/pos/reports" 
          class="sidebar-item flex items-center px-3 py-2 rounded-xl hover:bg-indigo-600/90 transition-all duration-300 group"
          :class="{ 
            'bg-indigo-600/80 shadow-md': currentPage === 'reports', 
            'justify-center': isSidebarCollapsed,
            'px-3': !isSidebarCollapsed
          }">
          <div class="flex items-center justify-center w-7 h-7 rounded-xl bg-indigo-800/50 group-hover:bg-white/20 transition-all duration-300">
            <i class="fas fa-chart-line text-xs group-hover:scale-110 transition-transform"></i>
          </div>
          <span class="ml-3 text-sm font-medium text-white/90 group-hover:text-white transition-all"
                :class="{ 'opacity-0 w-0 h-0': isSidebarCollapsed, 'opacity-100': !isSidebarCollapsed }">Reports</span>
          <span x-show="isSidebarCollapsed" class="sr-only">Reports</span>
          <div x-show="isSidebarCollapsed && currentPage === 'reports'" class="absolute right-2 w-1.5 h-1.5 bg-white rounded-full"></div>
        </a>
      </li>

      <!-- Settings -->
      <li>
        <a href="/pos/settings" 
          class="sidebar-item flex items-center px-3 py-2 rounded-xl hover:bg-indigo-600/90 transition-all duration-300 group"
          :class="{ 
            'bg-indigo-600/80 shadow-md': currentPage === 'settings', 
            'justify-center': isSidebarCollapsed,
            'px-3': !isSidebarCollapsed
          }">
          <div class="flex items-center justify-center w-7 h-7 rounded-xl bg-indigo-800/50 group-hover:bg-white/20 transition-all duration-300">
            <i class="fas fa-cog text-xs group-hover:scale-110 transition-transform"></i>
          </div>
          <span class="ml-3 text-sm font-medium text-white/90 group-hover:text-white transition-all"
                :class="{ 'opacity-0 w-0 h-0': isSidebarCollapsed, 'opacity-100': !isSidebarCollapsed }">Settings</span>
          <span x-show="isSidebarCollapsed" class="sr-only">Settings</span>
          <div x-show="isSidebarCollapsed && currentPage === 'settings'" class="absolute right-2 w-1.5 h-1.5 bg-white rounded-full"></div>
        </a>
      </li>

      <!-- Divider -->
      <li class="border-t border-indigo-800/50 my-2 mx-3 rounded-full"></li>

      <!-- Help -->
      <li>
        <a href="/pos/help" 
          class="sidebar-item flex items-center px-3 py-2 rounded-xl hover:bg-indigo-600/90 transition-all duration-300 group"
          :class="{ 
            'bg-indigo-600/80 shadow-md': currentPage === 'help', 
            'justify-center': isSidebarCollapsed,
            'px-3': !isSidebarCollapsed
          }">
          <div class="flex items-center justify-center w-7 h-7 rounded-xl bg-indigo-800/50 group-hover:bg-white/20 transition-all duration-300">
            <i class="fas fa-question-circle text-xs group-hover:scale-110 transition-transform"></i>
          </div>
          <span class="ml-3 text-sm font-medium text-white/90 group-hover:text-white transition-all"
                :class="{ 'opacity-0 w-0 h-0': isSidebarCollapsed, 'opacity-100': !isSidebarCollapsed }">Help</span>
          <span x-show="isSidebarCollapsed" class="sr-only">Help</span>
          <div x-show="isSidebarCollapsed && currentPage === 'help'" class="absolute right-2 w-1.5 h-1.5 bg-white rounded-full"></div>
        </a>
      </li>
    </ul>
  </nav>

  <!-- Sync Status & Logout Button -->
  <div class="p-3 border-t border-indigo-800/50">
    <!-- Sync Status - Collapsible -->
    <div class="flex items-center justify-between mb-3 px-2 py-1.5 rounded-xl bg-indigo-800/30 hover:bg-indigo-800/50 transition-all duration-300"
         :class="{ 'justify-center': isSidebarCollapsed }">
      <div class="flex items-center space-x-2">
        <div class="w-2 h-2 rounded-full bg-green-400 pulse"></div>
        <span class="text-xs font-medium text-white/90" 
              :class="{ 'opacity-0 w-0 h-0': isSidebarCollapsed, 'opacity-100': !isSidebarCollapsed }">Online</span>
      </div>
      <div class="flex items-center" :class="{ 'opacity-0 w-0 h-0': isSidebarCollapsed, 'opacity-100': !isSidebarCollapsed }">
        <span class="text-xs mr-2 truncate text-white/80" x-text="lastSyncTime || 'Not synced'"></span>
        <button @click="syncData()" class="text-indigo-200 hover:text-white transition-colors hover:scale-110">
          <i class="fas fa-sync-alt text-xs" :class="{'fa-spin': isSyncing}"></i>
        </button>
      </div>
      <button x-show="isSidebarCollapsed" @click="syncData()" 
              class="text-indigo-200 hover:text-white transition-colors hover:scale-110"
              title="Sync Data">
        <i class="fas fa-sync-alt text-xs" :class="{'fa-spin': isSyncing}"></i>
      </button>
    </div>

    <!-- Logout Button - Collapsible -->
    <button @click="requestLogout()" 
      class="w-full flex items-center justify-center space-x-2 bg-gradient-to-r from-red-500/90 to-red-600/90 hover:from-red-600 hover:to-red-700 text-white py-2 rounded-xl transition-all duration-300 hover:shadow-md group"
      :class="{ 'px-2': isSidebarCollapsed, 'px-3': !isSidebarCollapsed }">
      <i class="fas fa-sign-out-alt group-hover:scale-110 transition-transform"></i>
      <span class="text-sm font-medium group-hover:scale-105 transition-transform"
            :class="{ 'opacity-0 w-0 h-0': isSidebarCollapsed, 'opacity-100': !isSidebarCollapsed }">Logout</span>
    </button>
  </div>

  <!-- Version Info - Collapsible -->
  <div class="p-2 text-center">
    <p class="text-xs text-indigo-300/80 transition-all duration-300"
       :class="{ 'text-center': isSidebarCollapsed, 'text-left px-3': !isSidebarCollapsed }">
      <span x-show="!isSidebarCollapsed">Taman Sari POS </span>v1.2.0
    </p>
  </div>
</div>