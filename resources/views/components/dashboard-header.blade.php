<div class="mb-10 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl shadow-2xl p-8 text-white relative overflow-hidden transform transition-all hover:scale-[1.01] duration-300 group">
  <!-- Floating bubbles -->
  <div class="absolute -top-20 -right-20 w-64 h-64 bg-purple-500/20 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
  <div class="absolute bottom-0 left-10 w-32 h-32 bg-indigo-500/20 rounded-full group-hover:scale-125 transition-transform duration-700"></div>
  <div class="absolute top-1/4 left-1/4 w-16 h-16 bg-white/10 rounded-full group-hover:translate-x-10 transition-transform duration-1000"></div>

  <div class="relative z-10">
    <div class="flex items-center justify-between mb-6">
      <div class="flex-1">
        <h1 class="text-4xl font-bold mb-2 text-transparent bg-clip-text bg-gradient-to-r from-white to-purple-200">Dashboard Overview</h1>
        <div class="flex items-center space-x-4">
          <div class="flex items-center bg-white/10 px-3 py-1 rounded-full backdrop-blur-sm">
            <i class="fas fa-calendar-day mr-2 text-purple-200"></i>
            <span class="font-medium">{{ date('l, F j, Y') }}</span>
          </div>
          <div class="flex items-center bg-white/10 px-3 py-1 rounded-full backdrop-blur-sm">
            <i class="fas fa-clock mr-2 text-purple-200"></i>
            <span class="font-medium">{{ date('h:i A') }}</span>
          </div>
        </div>
      </div>
      <div class="bg-white/10 p-4 rounded-xl backdrop-blur-sm shadow-lg transform group-hover:rotate-6 transition-transform duration-500">
        <i class="fas fa-chart-pie text-4xl text-purple-100"></i>
      </div>
    </div>

    <!-- Mini Stats with Glow Hover -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <!-- Mini stats cards... -->
    </div>
  </div>
</div>