<div class="flex flex-row w-auto flex-shrink-0 pl-4 pr-2 py-4">
        <!-- Sidebar dengan ikon dan menu -->
        <div class="flex flex-col items-center py-4 flex-shrink-0 w-20 bg-cyan-500 rounded-3xl">
          <a href="{{ route('dashboard.pos') }}" class="flex items-center justify-center h-12 w-12 bg-cyan-50 text-cyan-700 rounded-full overflow-hidden">
            <img src="{{ asset('img/logo/logotamansari.jpeg') }}" alt="Logo Tamansari" class="h-full w-full object-cover">
          </a>
          <ul class="flex flex-col space-y-2 mt-12">
            <!-- Dashboard Menu - Visible to all logged in users -->
            <li>
              <a href="{{ route('dashboard.pos') }}" class="flex items-center group" title="Dashboard">
                <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-12 w-12 rounded-2xl group-hover:text-white transition-colors">
                  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                  </svg>
                </span>
              </a>
            </li>

            <!-- Products Menu - For admin and accounting -->
            @role(['admin', 'accounting'])
            <li>
              <a href="{{ route('products.index') }}" class="flex items-center group" title="Products">
                <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-12 w-12 rounded-2xl group-hover:text-white transition-colors">
                  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                  </svg>
                </span>
              </a>
            </li>
            @endrole

            <!-- Community Partners Menu - Only for admin -->
            @role('admin')
            <li>
              <a href="{{ route('partners.index') }}" class="flex items-center group" title="Community Partners">
                <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-12 w-12 rounded-2xl group-hover:text-white transition-colors">
                  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                </span>
              </a>
            </li>
            @endrole

            <!-- POS Menu - For cashier role -->
            @role('cashier')
            <li>
              <a href="{{ route('pos.index') }}" class="flex items-center group" title="Point of Sale">
                <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-12 w-12 rounded-2xl group-hover:text-white transition-colors">
                  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                </span>
              </a>
            </li>
            @endrole

            <!-- Reports Menu - For admin and accounting -->
            @can('administrator','acct')
            <li>
              <a href="{{ route('reports.index') }}" class="flex items-center group" title="Reports">
                <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-12 w-12 rounded-2xl group-hover:text-white transition-colors">
                  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                </span>
              </a>
            </li>
            @endrole

            <!-- User Profile Button - Visible to all logged in users -->
            <li>
              <button @click="showUserModal = true" class="flex items-center w-full focus:outline-none group" title="User Profile">
                <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-12 w-12 rounded-2xl group-hover:text-white transition-colors">
                  <i class="fas fa-user-circle fa-lg"></i>
                </span>
              </button>
            </li>

            <!-- Logout Button - Visible to all logged in users -->
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full focus:outline-none group" title="Logout">
                  <span class="flex items-center justify-center text-cyan-100 hover:bg-red-400 h-12 w-12 rounded-2xl group-hover:text-white transition-colors">
                    <i class="fas fa-sign-out-alt fa-lg"></i>
                  </span>
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>