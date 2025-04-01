<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NexTech - Futuristic Tech Blog</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/build/three.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/controls/OrbitControls.js"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          animation: {
            'fade-in': 'fadeIn 0.8s ease-in-out',
            'slide-up': 'slideUp 0.6s ease-out',
            'float': 'float 6s ease-in-out infinite',
            'gradient-x': 'gradientX 8s ease infinite',
            'gradient-y': 'gradientY 8s ease infinite',
            'pulse-slow': 'pulse 5s infinite cubic-bezier(0.4, 0, 0.6, 1)',
            'marquee': 'marquee 60s linear infinite',
            'marquee-reverse': 'marquee 60s linear infinite reverse',
            'wave': 'wave 2s linear infinite',
            'hologram': 'hologram 3s linear infinite',
          },
          keyframes: {
            fadeIn: {
              '0%': {
                opacity: '0'
              },
              '100%': {
                opacity: '1'
              },
            },
            slideUp: {
              '0%': {
                transform: 'translateY(30px)',
                opacity: '0'
              },
              '100%': {
                transform: 'translateY(0)',
                opacity: '1'
              },
            },
            float: {
              '0%, 100%': {
                transform: 'translateY(0)'
              },
              '50%': {
                transform: 'translateY(-20px)'
              },
            },
            gradientX: {
              '0%, 100%': {
                'background-position': '0% 50%'
              },
              '50%': {
                'background-position': '100% 50%'
              },
            },
            gradientY: {
              '0%, 100%': {
                'background-position': '50% 0%'
              },
              '50%': {
                'background-position': '50% 100%'
              },
            },
            marquee: {
              '0%': {
                transform: 'translateX(0)'
              },
              '100%': {
                transform: 'translateX(-50%)'
              },
            },
            wave: {
              '0%': {
                transform: 'rotate(0deg)'
              },
              '10%': {
                transform: 'rotate(14deg)'
              },
              '20%': {
                transform: 'rotate(-8deg)'
              },
              '30%': {
                transform: 'rotate(14deg)'
              },
              '40%': {
                transform: 'rotate(-4deg)'
              },
              '50%': {
                transform: 'rotate(10deg)'
              },
              '60%': {
                transform: 'rotate(0deg)'
              },
              '100%': {
                transform: 'rotate(0deg)'
              },
            },
            hologram: {
              '0%': {
                opacity: 0.3
              },
              '50%': {
                opacity: 0.8
              },
              '100%': {
                opacity: 0.3
              },
            }
          }
        }
      }
    }
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap');

    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8fafc;
      transition: background-color 0.5s ease;
    }

    body.dark {
      background-color: #0f172a;
    }

    .loading-spinner {
      animation: spin 1.5s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .gradient-text {
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      background-image: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
      background-size: 300% 300%;
      animation: gradientX 6s ease infinite;
    }

    .glow {
      box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
    }

    .glow:hover {
      box-shadow: 0 0 25px rgba(59, 130, 246, 0.7);
    }

    .tech-card {
      perspective: 1000px;
    }

    .tech-card-inner {
      transition: transform 0.6s;
      transform-style: preserve-3d;
    }

    .tech-card:hover .tech-card-inner {
      transform: rotateY(10deg) rotateX(5deg);
    }

    .parallax-bg {
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }

    .holographic-effect {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 50%, rgba(255, 255, 255, 0.1) 100%);
      position: relative;
      overflow: hidden;
    }

    .holographic-effect::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(to bottom right,
          rgba(255, 255, 255, 0) 45%,
          rgba(255, 255, 255, 0.1) 50%,
          rgba(255, 255, 255, 0) 55%);
      transform: rotate(30deg);
      animation: shine 3s infinite;
    }

    @keyframes shine {
      0% {
        transform: translateX(-100%) rotate(30deg);
      }

      100% {
        transform: translateX(100%) rotate(30deg);
      }
    }

    .title-font {
      font-family: 'Space Grotesk', sans-serif;
    }

    .neon-text {
      text-shadow: 0 0 5px rgba(59, 130, 246, 0.8),
        0 0 10px rgba(59, 130, 246, 0.6),
        0 0 15px rgba(59, 130, 246, 0.4);
    }

    .particles {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: 0;
    }

    .particle {
      position: absolute;
      background: rgba(255, 255, 255, 0.5);
      border-radius: 50%;
      animation: float-particle linear infinite;
    }

    @keyframes float-particle {
      0% {
        transform: translateY(0) translateX(0);
        opacity: 0;
      }

      10% {
        opacity: 1;
      }

      90% {
        opacity: 1;
      }

      100% {
        transform: translateY(-100vh) translateX(20px);
        opacity: 0;
      }
    }

    /* 3D Sphere Canvas */
    #techSphere {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
      opacity: 0.3;
    }

    /* AI Assistant */
    .ai-assistant {
      position: fixed;
      bottom: 30px;
      right: 30px;
      z-index: 100;
      transition: all 0.3s ease;
    }

    .ai-assistant-button {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: linear-gradient(135deg, #3b82f6, #8b5cf6);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 10px 25px rgba(59, 130, 246, 0.5);
      transition: all 0.3s ease;
    }

    .ai-assistant-button:hover {
      transform: scale(1.1);
      box-shadow: 0 15px 30px rgba(59, 130, 246, 0.7);
    }

    .ai-assistant-chat {
      position: absolute;
      bottom: 80px;
      right: 0;
      width: 350px;
      max-height: 500px;
      background: white;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      transform: scale(0);
      transform-origin: bottom right;
      transition: all 0.3s ease;
      opacity: 0;
    }

    .ai-assistant.active .ai-assistant-chat {
      transform: scale(1);
      opacity: 1;
    }

    /* Dark mode styles */
    .dark .ai-assistant-chat {
      background: #1e293b;
      color: white;
    }

    /* Podcast player */
    .podcast-player {
      background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.1));
      border-radius: 16px;
      backdrop-filter: blur(10px);
    }

    .dark .podcast-player {
      background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.2));
    }

    /* Holographic effect for cards */
    .hologram-card {
      position: relative;
      overflow: hidden;
    }

    .hologram-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.8), transparent);
      animation: hologram 3s linear infinite;
    }

    /* Voice search */
    .voice-search.active {
      animation: wave 2s linear infinite;
    }

    /* Theme switcher */
    .theme-switcher {
      position: relative;
      width: 60px;
      height: 30px;
      border-radius: 15px;
      background: #e2e8f0;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .dark .theme-switcher {
      background: #334155;
    }

    .theme-switcher-toggle {
      position: absolute;
      top: 2px;
      left: 2px;
      width: 26px;
      height: 26px;
      border-radius: 50%;
      background: white;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
    }

    .dark .theme-switcher-toggle {
      transform: translateX(30px);
      background: #0f172a;
    }

    /* Tech news ticker */
    .ticker-container {
      overflow: hidden;
      white-space: nowrap;
    }

    .ticker-item {
      display: inline-block;
      padding-right: 40px;
      position: relative;
    }

    .ticker-item::after {
      content: '';
      position: absolute;
      top: 50%;
      right: 15px;
      width: 6px;
      height: 6px;
      background: currentColor;
      border-radius: 50%;
      transform: translateY(-50%);
    }

    /* Job board cards */
    .job-card {
      transition: all 0.3s ease;
      border: 1px solid #e2e8f0;
    }

    .dark .job-card {
      border-color: #334155;
    }

    .job-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .dark .job-card:hover {
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    /* Event calendar */
    .event-day {
      transition: all 0.3s ease;
    }

    .event-day:hover {
      transform: scale(1.05);
    }

    /* Tooltip */
    .tooltip {
      position: relative;
    }

    .tooltip-text {
      visibility: hidden;
      width: 200px;
      background-color: #333;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 5px;
      position: absolute;
      z-index: 1;
      bottom: 125%;
      left: 50%;
      transform: translateX(-50%);
      opacity: 0;
      transition: opacity 0.3s;
    }

    .tooltip:hover .tooltip-text {
      visibility: visible;
      opacity: 1;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .ai-assistant-chat {
        width: 300px;
        max-height: 400px;
      }

      #techSphere {
        opacity: 0.2;
      }
    }
    /* Add this to your stylesheet */
.code-editor-container {
  position: relative;
  border-radius: 0.5rem;
  overflow: hidden;
  border: 1px solid rgba(55, 65, 81, 0.5);
  background-color: rgba(17, 24, 39, 0.8);
}

.editor-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.5rem 1rem;
  background-color: rgba(31, 41, 55, 0.8);
}

#codeEditor, #challengeEditor {
  width: 100%;
  min-height: 200px;
  padding: 1rem;
  font-family: 'Fira Code', 'Consolas', 'Monaco', 'Courier New', monospace;
  font-size: 14px;
  line-height: 1.5;
  color: #e5e7eb;
  background-color: rgba(17, 24, 39, 0.8);
  border: none;
  resize: none;
  outline: none;
  tab-size: 2;
  white-space: pre;
}

#codeEditor:focus, #challengeEditor:focus {
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

.run-button {
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  background-color: rgba(59, 130, 246, 0.2);
  color: #93c5fd;
  border: 1px solid rgba(59, 130, 246, 0.3);
  cursor: pointer;
  transition: all 0.2s;
}

.run-button:hover {
  background-color: rgba(59, 130, 246, 0.3);
}

/* For line numbers if needed */
.code-editor-container.with-line-numbers {
  position: relative;
}

.code-editor-container.with-line-numbers textarea {
  padding-left: 3.5rem;
}

.line-numbers {
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 2.5rem;
  padding: 1rem 0.5rem;
  text-align: right;
  font-family: monospace;
  color: #6b7280;
  background-color: rgba(31, 41, 55, 0.5);
  border-right: 1px solid rgba(55, 65, 81, 0.5);
  user-select: none;
}
  </style>
</head>

<body class="antialiased">
  <!-- Loading Screen with Futuristic Animation -->
  <div id="loading" class="fixed inset-0 bg-gray-900 z-50 flex flex-col items-center justify-center transition-all duration-1000">
    <div class="relative">
      <div class="absolute inset-0 rounded-full bg-blue-600 opacity-20 blur-lg animate-pulse-slow"></div>
      <div class="loading-spinner text-6xl text-blue-400 relative">
        <i class="fas fa-atom"></i>
      </div>
    </div>
    <h2 class="text-3xl font-bold text-white mt-8 title-font neon-text animate-pulse">NexTech</h2>
    <p class="text-blue-200 mt-4 animate-pulse">Initializing next-gen experience...</p>

    <!-- Floating particles -->
    <div class="particles">
      <!-- Particles will be generated by JS -->
    </div>
  </div>

  <!-- 3D Tech Sphere Background -->
  <canvas id="techSphere"></canvas>

  <!-- Futuristic Navigation -->
  <header class="bg-gray-900/90 backdrop-blur-md sticky top-0 z-40 border-b border-gray-800 shadow-lg animate-fade-in dark:bg-gray-900/80">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
      <div class="flex items-center space-x-3">
        <div class="holographic-effect rounded-full p-2 glow">
          <i class="fas fa-brain text-2xl text-blue-400"></i>
        </div>
        <h1 class="text-2xl font-bold text-white title-font">Nex<span class="gradient-text">Tech</span></h1>
      </div>

      <nav class="hidden lg:flex space-x-1">
        <a href="#" class="px-4 py-2 rounded-md text-blue-400 font-medium hover:bg-gray-800/50 hover:text-white transition-all flex items-center group dark:hover:bg-gray-800">
          <span class="mr-2">Home</span>
          <i class="fas fa-home text-sm opacity-0 group-hover:opacity-100 transition-opacity"></i>
        </a>
        <a href="#articles" class="px-4 py-2 rounded-md text-gray-300 font-medium hover:bg-gray-800/50 hover:text-white transition-all flex items-center group dark:hover:bg-gray-800">
          <span class="mr-2">Articles</span>
          <i class="fas fa-newspaper text-sm opacity-0 group-hover:opacity-100 transition-opacity"></i>
        </a>
        <a href="#tutorials" class="px-4 py-2 rounded-md text-gray-300 font-medium hover:bg-gray-800/50 hover:text-white transition-all flex items-center group dark:hover:bg-gray-800">
          <span class="mr-2">Tutorials</span>
          <i class="fas fa-graduation-cap text-sm opacity-0 group-hover:opacity-100 transition-opacity"></i>
        </a>
        <a href="#reviews" class="px-4 py-2 rounded-md text-gray-300 font-medium hover:bg-gray-800/50 hover:text-white transition-all flex items-center group dark:hover:bg-gray-800">
          <span class="mr-2">Reviews</span>
          <i class="fas fa-star text-sm opacity-0 group-hover:opacity-100 transition-opacity"></i>
        </a>
        <a href="#about" class="px-4 py-2 rounded-md text-gray-300 font-medium hover:bg-gray-800/50 hover:text-white transition-all flex items-center group dark:hover:bg-gray-800">
          <span class="mr-2">About</span>
          <i class="fas fa-info-circle text-sm opacity-0 group-hover:opacity-100 transition-opacity"></i>
        </a>
      </nav>

      <div class="flex items-center space-x-4">
        <button id="themeToggle" class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-800 hover:bg-gray-700 transition-colors dark:bg-gray-700 dark:hover:bg-gray-600">
          <i class="fas fa-moon text-yellow-400 dark:hidden"></i>
          <i class="fas fa-sun text-yellow-300 hidden dark:block"></i>
        </button>
        <button class="lg:hidden text-gray-300 hover:text-white transition-colors">
          <i class="fas fa-bars text-xl"></i>
        </button>
        <button class="hidden md:flex items-center bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-5 py-2.5 rounded-full hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg glow hover:shadow-xl">
          <i class="fas fa-user-astronaut mr-2"></i>
          <span>Join Community</span>
        </button>
      </div>
    </div>
  </header>

  <!-- Futuristic Hero Section with Parallax -->
  <section class="relative overflow-hidden bg-gray-900 text-white py-24">
    <!-- Animated gradient background -->
    <div class="absolute inset-0 bg-gradient-to-r from-blue-900/30 via-purple-900/30 to-pink-900/30 animate-gradient-x"></div>

    <!-- Floating tech elements -->
    <div class="absolute top-20 left-10 w-16 h-16 rounded-full bg-blue-500/20 blur-xl animate-float"></div>
    <div class="absolute bottom-1/4 right-1/4 w-24 h-24 rounded-full bg-purple-500/20 blur-xl animate-float" style="animation-delay: 2s;"></div>
    <div class="absolute top-1/3 right-20 w-20 h-20 rounded-full bg-pink-500/20 blur-xl animate-float" style="animation-delay: 4s;"></div>

    <div class="container mx-auto px-4 relative z-10">
      <div class="max-w-4xl mx-auto text-center animate-slide-up">
        <span class="inline-block bg-white/10 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm mb-6 text-blue-300 border border-blue-400/30 animate-fade-in">
          <i class="fas fa-bolt mr-1"></i> TRENDING: AI Revolution 2023
        </span>
        <h2 class="text-4xl md:text-6xl font-bold mb-6 leading-tight title-font">
          Explore The <span class="gradient-text">Future</span> of Technology
        </h2>
        <p class="text-xl md:text-2xl mb-10 opacity-90 max-w-3xl mx-auto">
          Discover cutting-edge innovations, in-depth tutorials, and expert analysis on AI, Web3, Quantum Computing and beyond.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4 max-w-xl mx-auto">
          <div class="relative flex-grow">
            <input type="text" placeholder="Search futuristic tech..."
              class="w-full px-6 py-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900 pr-14 bg-white/90 backdrop-blur-sm dark:bg-gray-800/90 dark:text-white">
            <button id="voiceSearch" class="absolute right-12 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-blue-600 transition-colors dark:hover:text-blue-400">
              <i class="fas fa-microphone"></i>
            </button>
            <button class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-blue-600 transition-colors dark:hover:text-blue-400">
              <i class="fas fa-search-plus text-lg"></i>
            </button>
          </div>
          <button class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-4 rounded-xl font-bold hover:from-blue-600 hover:to-blue-700 transition-all shadow-lg glow flex items-center justify-center whitespace-nowrap">
            <i class="fas fa-rocket mr-2"></i> Explore Now
          </button>
        </div>
        <div id="voiceStatus" class="mt-2 text-blue-300 hidden">
          <i class="fas fa-circle-notch fa-spin mr-2"></i>
          <span>Listening...</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Categories -->
  <section class="container mx-auto px-4 py-16">
    <div class="text-center mb-16 animate-fade-in">
      <span class="text-blue-500 font-medium">TECH DOMAINS</span>
      <h3 class="text-3xl md:text-4xl font-bold mt-2 mb-4 title-font">Explore <span class="gradient-text">Cutting-Edge</span> Fields</h3>
      <p class="text-gray-600 max-w-2xl mx-auto dark:text-gray-400">Dive into the most revolutionary technology categories shaping our future</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- AI Category -->
      <div class="tech-card group">
        <div class="tech-card-inner h-full bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 border border-gray-200/50 dark:from-blue-900/20 dark:to-indigo-900/20 dark:border-gray-700/50">
          <div class="relative h-40 overflow-hidden">
            <img src="https://source.unsplash.com/random/600x400/?ai,neural" alt="AI"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900/60 to-transparent"></div>
            <div class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">
              <i class="fas fa-arrow-up mr-1"></i> +32%
            </div>
          </div>
          <div class="p-6">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4 dark:bg-blue-900/30">
                <i class="fas fa-robot text-2xl text-blue-600 dark:text-blue-400"></i>
              </div>
              <h4 class="text-xl font-bold text-gray-800 dark:text-white">Artificial Intelligence</h4>
            </div>
            <p class="text-gray-600 mb-5 dark:text-gray-400">Explore the latest in machine learning, neural networks and AI applications.</p>
            <a href="#" class="text-blue-600 font-medium hover:underline inline-flex items-center dark:text-blue-400">
              Discover AI <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Web3 Category -->
      <div class="tech-card group">
        <div class="tech-card-inner h-full bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 border border-gray-200/50 dark:from-purple-900/20 dark:to-pink-900/20 dark:border-gray-700/50">
          <div class="relative h-40 overflow-hidden">
            <img src="https://source.unsplash.com/random/600x400/?blockchain,crypto" alt="Web3"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-transparent"></div>
            <div class="absolute top-4 right-4 bg-purple-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">
              <i class="fas fa-bolt mr-1"></i> Trending
            </div>
          </div>
          <div class="p-6">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-4 dark:bg-purple-900/30">
                <i class="fas fa-cube text-2xl text-purple-600 dark:text-purple-400"></i>
              </div>
              <h4 class="text-xl font-bold text-gray-800 dark:text-white">Web3 & Blockchain</h4>
            </div>
            <p class="text-gray-600 mb-5 dark:text-gray-400">Dive into decentralized apps, smart contracts and the future of the internet.</p>
            <a href="#" class="text-purple-600 font-medium hover:underline inline-flex items-center dark:text-purple-400">
              Explore Web3 <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Quantum Category -->
      <div class="tech-card group">
        <div class="tech-card-inner h-full bg-gradient-to-br from-cyan-50 to-blue-50 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 border border-gray-200/50 dark:from-cyan-900/20 dark:to-blue-900/20 dark:border-gray-700/50">
          <div class="relative h-40 overflow-hidden">
            <img src="https://source.unsplash.com/random/600x400/?quantum,physics" alt="Quantum"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-cyan-900/60 to-transparent"></div>
            <div class="absolute top-4 right-4 bg-cyan-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">
              <i class="fas fa-atom mr-1"></i> Emerging
            </div>
          </div>
          <div class="p-6">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 rounded-full bg-cyan-100 flex items-center justify-center mr-4 dark:bg-cyan-900/30">
                <i class="fas fa-atom text-2xl text-cyan-600 dark:text-cyan-400"></i>
              </div>
              <h4 class="text-xl font-bold text-gray-800 dark:text-white">Quantum Computing</h4>
            </div>
            <p class="text-gray-600 mb-5 dark:text-gray-400">Discover the next frontier in computational power and its applications.</p>
            <a href="#" class="text-cyan-600 font-medium hover:underline inline-flex items-center dark:text-cyan-400">
              Learn Quantum <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- IoT Category -->
      <div class="tech-card group">
        <div class="tech-card-inner h-full bg-gradient-to-br from-green-50 to-teal-50 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 border border-gray-200/50 dark:from-green-900/20 dark:to-teal-900/20 dark:border-gray-700/50">
          <div class="relative h-40 overflow-hidden">
            <img src="https://source.unsplash.com/random/600x400/?iot,smartcity" alt="IoT"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-green-900/60 to-transparent"></div>
            <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">
              <i class="fas fa-network-wired mr-1"></i> Growing
            </div>
          </div>
          <div class="p-6">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4 dark:bg-green-900/30">
                <i class="fas fa-satellite-dish text-2xl text-green-600 dark:text-green-400"></i>
              </div>
              <h4 class="text-xl font-bold text-gray-800 dark:text-white">IoT & Smart Tech</h4>
            </div>
            <p class="text-gray-600 mb-5 dark:text-gray-400">Connect with the world of smart devices and interconnected systems.</p>
            <a href="#" class="text-green-600 font-medium hover:underline inline-flex items-center dark:text-green-400">
              Connect IoT <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Articles -->
  <section id="articles" class="bg-gray-50 py-16 dark:bg-gray-900/50">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row justify-between items-center mb-12 animate-fade-in">
        <div>
          <span class="text-blue-500 font-medium">FEATURED CONTENT</span>
          <h3 class="text-3xl md:text-4xl font-bold mt-2 title-font">Latest <span class="gradient-text">Tech Insights</span></h3>
        </div>
        <a href="#" class="mt-4 md:mt-0 inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors dark:text-blue-400 dark:hover:text-blue-300">
          View All Articles <i class="fas fa-arrow-right ml-2"></i>
        </a>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Featured Article -->
        <div class="lg:col-span-2 animate-slide-up">
          <div class="group relative h-full rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/30 to-transparent z-10"></div>
            <img src="https://source.unsplash.com/random/1200x800/?ai,future" alt="Featured Article"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            <div class="absolute bottom-0 left-0 p-8 z-20 w-full">
              <div class="flex items-center text-sm text-white/80 mb-3">
                <span class="bg-blue-600/90 text-white px-3 py-1 rounded-full mr-3">AI</span>
                <span><i class="far fa-clock mr-1"></i> March 25, 2023</span>
                <span class="ml-3"><i class="far fa-eye mr-1"></i> 5.2K</span>
              </div>
              <h4 class="text-2xl md:text-3xl font-bold text-white mb-4 group-hover:text-blue-300 transition-colors">
                How AI Will Transform Every Industry in the Next Decade
              </h4>
              <p class="text-white/90 mb-5">An in-depth analysis of AI's disruptive potential across sectors from healthcare to finance.</p>
              <div class="flex items-center">
                <div class="flex -space-x-2 mr-4">
                  <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Author"
                    class="w-10 h-10 rounded-full border-2 border-white/80">
                  <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Co-author"
                    class="w-10 h-10 rounded-full border-2 border-white/80">
                </div>
                <div>
                  <p class="text-sm font-medium text-white">By Sarah Johnson & Mark Chen</p>
                  <p class="text-xs text-white/70">AI Researchers</p>
                </div>
                <a href="#" class="ml-auto text-white hover:text-blue-300 font-medium inline-flex items-center transition-colors">
                  Read More <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Side Featured Articles -->
        <div class="space-y-6">
          <!-- Article 1 -->
          <div class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 animate-slide-up dark:bg-gray-800" style="animation-delay: 0.1s">
            <div class="relative h-40 overflow-hidden">
              <img src="https://source.unsplash.com/random/600x400/?metaverse" alt="Metaverse"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
              <div class="absolute inset-0 bg-gradient-to-t from-gray-900/50 to-transparent"></div>
              <span class="absolute top-3 left-3 bg-purple-600 text-white px-2 py-0.5 rounded text-xs font-bold">
                Web3
              </span>
            </div>
            <div class="p-5">
              <h4 class="text-lg font-bold mb-2 text-gray-800 group-hover:text-blue-600 transition-colors dark:text-white dark:group-hover:text-blue-400">
                Building the Metaverse: Challenges and Opportunities
              </h4>
              <p class="text-gray-600 text-sm mb-4 dark:text-gray-400">Exploring the technical hurdles and business potential of the next internet evolution.</p>
              <div class="flex justify-between items-center">
                <span class="text-xs text-gray-500 dark:text-gray-400"><i class="far fa-clock mr-1"></i> 8 min read</span>
                <a href="#" class="text-blue-600 text-sm hover:underline inline-flex items-center dark:text-blue-400">
                  Read <i class="fas fa-arrow-right ml-1 text-xs transition-transform group-hover:translate-x-1"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Article 2 -->
          <div class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 animate-slide-up dark:bg-gray-800" style="animation-delay: 0.2s">
            <div class="relative h-40 overflow-hidden">
              <img src="https://source.unsplash.com/random/600x400/?quantum,computer" alt="Quantum"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
              <div class="absolute inset-0 bg-gradient-to-t from-gray-900/50 to-transparent"></div>
              <span class="absolute top-3 left-3 bg-cyan-600 text-white px-2 py-0.5 rounded text-xs font-bold">
                Quantum
              </span>
            </div>
            <div class="p-5">
              <h4 class="text-lg font-bold mb-2 text-gray-800 group-hover:text-blue-600 transition-colors dark:text-white dark:group-hover:text-blue-400">
                Quantum Supremacy: What It Means for Cryptography
              </h4>
              <p class="text-gray-600 text-sm mb-4 dark:text-gray-400">How quantum computers will break current encryption and what comes next.</p>
              <div class="flex justify-between items-center">
                <span class="text-xs text-gray-500 dark:text-gray-400"><i class="far fa-clock mr-1"></i> 6 min read</span>
                <a href="#" class="text-blue-600 text-sm hover:underline inline-flex items-center dark:text-blue-400">
                  Read <i class="fas fa-arrow-right ml-1 text-xs transition-transform group-hover:translate-x-1"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Article 3 -->
          <div class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 animate-slide-up dark:bg-gray-800" style="animation-delay: 0.3s">
            <div class="relative h-40 overflow-hidden">
              <img src="https://source.unsplash.com/random/600x400/?robot,humanoid" alt="Robotics"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
              <div class="absolute inset-0 bg-gradient-to-t from-gray-900/50 to-transparent"></div>
              <span class="absolute top-3 left-3 bg-red-600 text-white px-2 py-0.5 rounded text-xs font-bold">
                Robotics
              </span>
            </div>
            <div class="p-5">
              <h4 class="text-lg font-bold mb-2 text-gray-800 group-hover:text-blue-600 transition-colors dark:text-white dark:group-hover:text-blue-400">
                Humanoid Robots in Daily Life: Closer Than We Think
              </h4>
              <p class="text-gray-600 text-sm mb-4 dark:text-gray-400">Examining the rapid advancements in bipedal robotics and AI integration.</p>
              <div class="flex justify-between items-center">
                <span class="text-xs text-gray-500 dark:text-gray-400"><i class="far fa-clock mr-1"></i> 7 min read</span>
                <a href="#" class="text-blue-600 text-sm hover:underline inline-flex items-center dark:text-blue-400">
                  Read <i class="fas fa-arrow-right ml-1 text-xs transition-transform group-hover:translate-x-1"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Tech Podcast Section -->
  <section class="container mx-auto px-4 py-16">
    <div class="text-center mb-16 animate-fade-in">
      <span class="text-blue-500 font-medium">TECH PODCAST</span>
      <h3 class="text-3xl md:text-4xl font-bold mt-2 mb-4 title-font">Listen to <span class="gradient-text">Tech Talks</span></h3>
      <p class="text-gray-600 max-w-2xl mx-auto dark:text-gray-400">Dive deeper with our exclusive interviews with industry leaders and innovators</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Podcast 1 -->
      <div class="podcast-player p-6 rounded-2xl shadow-lg animate-slide-up">
        <div class="flex items-center mb-6">
          <div class="w-16 h-16 rounded-lg overflow-hidden mr-4">
            <img src="https://source.unsplash.com/random/300x300/?ai" alt="AI Podcast" class="w-full h-full object-cover">
          </div>
          <div>
            <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">EPISODE 42</span>
            <h4 class="text-lg font-bold text-gray-800 dark:text-white">The Future of Generative AI</h4>
          </div>
        </div>
        <p class="text-gray-600 mb-6 dark:text-gray-400">Interview with Dr. Lisa Zhang about the ethical implications of generative AI models.</p>
        <audio controls class="w-full mb-4">
          <source src="#" type="audio/mpeg">
          Your browser does not support the audio element.
        </audio>
        <div class="flex justify-between items-center text-sm">
          <span class="text-gray-500 dark:text-gray-400"><i class="far fa-clock mr-1"></i> 58 min</span>
          <div class="flex space-x-3">
            <a href="#" class="text-gray-500 hover:text-blue-600 dark:hover:text-blue-400"><i class="fas fa-share-alt"></i></a>
            <a href="#" class="text-gray-500 hover:text-blue-600 dark:hover:text-blue-400"><i class="far fa-bookmark"></i></a>
            <a href="#" class="text-gray-500 hover:text-blue-600 dark:hover:text-blue-400"><i class="fas fa-download"></i></a>
          </div>
        </div>
      </div>

      <!-- Podcast 2 -->
      <div class="podcast-player p-6 rounded-2xl shadow-lg animate-slide-up" style="animation-delay: 0.1s">
        <div class="flex items-center mb-6">
          <div class="w-16 h-16 rounded-lg overflow-hidden mr-4">
            <img src="https://source.unsplash.com/random/300x300/?blockchain" alt="Blockchain Podcast" class="w-full h-full object-cover">
          </div>
          <div>
            <span class="text-xs font-semibold text-purple-600 dark:text-purple-400">EPISODE 41</span>
            <h4 class="text-lg font-bold text-gray-800 dark:text-white">Web3: Hype vs Reality</h4>
          </div>
        </div>
        <p class="text-gray-600 mb-6 dark:text-gray-400">Discussion with blockchain pioneer Mark Thompson about practical Web3 applications.</p>
        <audio controls class="w-full mb-4">
          <source src="#" type="audio/mpeg">
          Your browser does not support the audio element.
        </audio>
        <div class="flex justify-between items-center text-sm">
          <span class="text-gray-500 dark:text-gray-400"><i class="far fa-clock mr-1"></i> 1h 12min</span>
          <div class="flex space-x-3">
            <a href="#" class="text-gray-500 hover:text-purple-600 dark:hover:text-purple-400"><i class="fas fa-share-alt"></i></a>
            <a href="#" class="text-gray-500 hover:text-purple-600 dark:hover:text-purple-400"><i class="far fa-bookmark"></i></a>
            <a href="#" class="text-gray-500 hover:text-purple-600 dark:hover:text-purple-400"><i class="fas fa-download"></i></a>
          </div>
        </div>
      </div>

      <!-- Podcast 3 -->
      <div class="podcast-player p-6 rounded-2xl shadow-lg animate-slide-up" style="animation-delay: 0.2s">
        <div class="flex items-center mb-6">
          <div class="w-16 h-16 rounded-lg overflow-hidden mr-4">
            <img src="https://source.unsplash.com/random/300x300/?quantum" alt="Quantum Podcast" class="w-full h-full object-cover">
          </div>
          <div>
            <span class="text-xs font-semibold text-cyan-600 dark:text-cyan-400">EPISODE 40</span>
            <h4 class="text-lg font-bold text-gray-800 dark:text-white">Quantum Computing Breakthroughs</h4>
          </div>
        </div>
        <p class="text-gray-600 mb-6 dark:text-gray-400">Dr. Emily Wilson explains recent quantum supremacy achievements and what's next.</p>
        <audio controls class="w-full mb-4">
          <source src="#" type="audio/mpeg">
          Your browser does not support the audio element.
        </audio>
        <div class="flex justify-between items-center text-sm">
          <span class="text-gray-500 dark:text-gray-400"><i class="far fa-clock mr-1"></i> 45 min</span>
          <div class="flex space-x-3">
            <a href="#" class="text-gray-500 hover:text-cyan-600 dark:hover:text-cyan-400"><i class="fas fa-share-alt"></i></a>
            <a href="#" class="text-gray-500 hover:text-cyan-600 dark:hover:text-cyan-400"><i class="far fa-bookmark"></i></a>
            <a href="#" class="text-gray-500 hover:text-cyan-600 dark:hover:text-cyan-400"><i class="fas fa-download"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center mt-12">
      <button class="bg-white border-2 border-blue-500 text-blue-600 px-8 py-3 rounded-xl font-bold hover:bg-blue-50 transition-colors shadow-md hover:shadow-lg inline-flex items-center group dark:bg-gray-800 dark:border-blue-400 dark:text-blue-400 dark:hover:bg-gray-700">
        <span>View All Episodes</span>
        <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
      </button>
    </div>
  </section>

  <!-- Developer Tools Showcase -->
  <section class="bg-gray-100 py-16 dark:bg-gray-800/50">
    <div class="container mx-auto px-4">
      <div class="text-center mb-16 animate-fade-in">
        <span class="text-blue-500 font-medium">DEVELOPER RESOURCES</span>
        <h3 class="text-3xl md:text-4xl font-bold mt-2 mb-4 title-font">Essential <span class="gradient-text">Tech Tools</span></h3>
        <p class="text-gray-600 max-w-2xl mx-auto dark:text-gray-400">Curated collection of frameworks, libraries and tools for modern developers</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Tool 1 -->
        <div class="hologram-card bg-white rounded-xl shadow-md overflow-hidden dark:bg-gray-800">
          <div class="p-5">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mr-4 dark:bg-blue-900/30">
                <i class="fab fa-react text-2xl text-blue-600 dark:text-blue-400"></i>
              </div>
              <h4 class="text-lg font-bold text-gray-800 dark:text-white">React 18</h4>
            </div>
            <p class="text-gray-600 text-sm mb-4 dark:text-gray-400">The latest version of Facebook's popular JavaScript library for building user interfaces.</p>
            <div class="flex justify-between items-center">
              <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded dark:bg-blue-900/30 dark:text-blue-400">Frontend</span>
              <a href="#" class="text-blue-600 text-sm hover:underline inline-flex items-center dark:text-blue-400">
                Explore <i class="fas fa-arrow-right ml-1 text-xs"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Tool 2 -->
        <div class="hologram-card bg-white rounded-xl shadow-md overflow-hidden dark:bg-gray-800">
          <div class="p-5">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mr-4 dark:bg-green-900/30">
                <i class="fab fa-node-js text-2xl text-green-600 dark:text-green-400"></i>
              </div>
              <h4 class="text-lg font-bold text-gray-800 dark:text-white">Node.js 20</h4>
            </div>
            <p class="text-gray-600 text-sm mb-4 dark:text-gray-400">JavaScript runtime built on Chrome's V8 engine for building scalable network applications.</p>
            <div class="flex justify-between items-center">
              <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded dark:bg-green-900/30 dark:text-green-400">Backend</span>
              <a href="#" class="text-green-600 text-sm hover:underline inline-flex items-center dark:text-green-400">
                Explore <i class="fas fa-arrow-right ml-1 text-xs"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Tool 3 -->
        <div class="hologram-card bg-white rounded-xl shadow-md overflow-hidden dark:bg-gray-800">
          <div class="p-5">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center mr-4 dark:bg-purple-900/30">
                <i class="fas fa-cube text-2xl text-purple-600 dark:text-purple-400"></i>
              </div>
              <h4 class="text-lg font-bold text-gray-800 dark:text-white">Solidity 0.8</h4>
            </div>
            <p class="text-gray-600 text-sm mb-4 dark:text-gray-400">Contract-oriented programming language for writing smart contracts on Ethereum.</p>
            <div class="flex justify-between items-center">
              <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded dark:bg-purple-900/30 dark:text-purple-400">Blockchain</span>
              <a href="#" class="text-purple-600 text-sm hover:underline inline-flex items-center dark:text-purple-400">
                Explore <i class="fas fa-arrow-right ml-1 text-xs"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Tool 4 -->
        <div class="hologram-card bg-white rounded-xl shadow-md overflow-hidden dark:bg-gray-800">
          <div class="p-5">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center mr-4 dark:bg-red-900/30">
                <i class="fas fa-robot text-2xl text-red-600 dark:text-red-400"></i>
              </div>
              <h4 class="text-lg font-bold text-gray-800 dark:text-white">TensorFlow 2.0</h4>
            </div>
            <p class="text-gray-600 text-sm mb-4 dark:text-gray-400">End-to-end open source platform for machine learning with comprehensive tools.</p>
            <div class="flex justify-between items-center">
              <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded dark:bg-red-900/30 dark:text-red-400">AI/ML</span>
              <a href="#" class="text-red-600 text-sm hover:underline inline-flex items-center dark:text-red-400">
                Explore <i class="fas fa-arrow-right ml-1 text-xs"></i>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="text-center mt-12">
        <button class="bg-white border-2 border-blue-500 text-blue-600 px-8 py-3 rounded-xl font-bold hover:bg-blue-50 transition-colors shadow-md hover:shadow-lg inline-flex items-center group dark:bg-gray-800 dark:border-blue-400 dark:text-blue-400 dark:hover:bg-gray-700">
          <span>View All Tools</span>
          <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
        </button>
      </div>
    </div>
  </section>

  <!-- Tech Job Board -->
  <section class="container mx-auto px-4 py-16">
    <div class="text-center mb-16 animate-fade-in">
      <span class="text-blue-500 font-medium">CAREER OPPORTUNITIES</span>
      <h3 class="text-3xl md:text-4xl font-bold mt-2 mb-4 title-font">Tech <span class="gradient-text">Job Board</span></h3>
      <p class="text-gray-600 max-w-2xl mx-auto dark:text-gray-400">Find your next career opportunity in cutting-edge technology companies</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Job 1 -->
      <div class="job-card bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 dark:bg-gray-800">
        <div class="flex items-start mb-4">
          <div class="w-16 h-16 rounded-lg overflow-hidden mr-4">
            <img src="https://source.unsplash.com/random/300x300/?tech,company" alt="Company" class="w-full h-full object-cover">
          </div>
          <div>
            <h4 class="text-xl font-bold text-gray-800 dark:text-white">Senior AI Engineer</h4>
            <p class="text-gray-600 dark:text-gray-400">QuantumLeap AI • San Francisco, CA • Remote</p>
          </div>
          <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full dark:bg-blue-900/30 dark:text-blue-400">$150K-$200K</span>
        </div>
        <p class="text-gray-600 mb-4 dark:text-gray-400">We're looking for an experienced AI engineer to lead our machine learning initiatives and develop next-gen AI models.</p>
        <div class="flex flex-wrap gap-2 mb-4">
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">Python</span>
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">TensorFlow</span>
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">PyTorch</span>
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">NLP</span>
        </div>
        <div class="flex justify-between items-center">
          <span class="text-xs text-gray-500 dark:text-gray-400">Posted 2 days ago</span>
          <button class="text-blue-600 text-sm font-medium hover:underline inline-flex items-center dark:text-blue-400">
            Apply Now <i class="fas fa-arrow-right ml-2"></i>
          </button>
        </div>
      </div>

      <!-- Job 2 -->
      <div class="job-card bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 dark:bg-gray-800">
        <div class="flex items-start mb-4">
          <div class="w-16 h-16 rounded-lg overflow-hidden mr-4">
            <img src="https://source.unsplash.com/random/300x300/?blockchain,company" alt="Company" class="w-full h-full object-cover">
          </div>
          <div>
            <h4 class="text-xl font-bold text-gray-800 dark:text-white">Blockchain Developer</h4>
            <p class="text-gray-600 dark:text-gray-400">ChainFuture • New York, NY • Hybrid</p>
          </div>
          <span class="ml-auto bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full dark:bg-purple-900/30 dark:text-purple-400">$130K-$180K</span>
        </div>
        <p class="text-gray-600 mb-4 dark:text-gray-400">Join our team to build decentralized applications and smart contracts on Ethereum and other blockchain platforms.</p>
        <div class="flex flex-wrap gap-2 mb-4">
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">Solidity</span>
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">Rust</span>
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">Web3.js</span>
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">Ethereum</span>
        </div>
        <div class="flex justify-between items-center">
          <span class="text-xs text-gray-500 dark:text-gray-400">Posted 1 week ago</span>
          <button class="text-purple-600 text-sm font-medium hover:underline inline-flex items-center dark:text-purple-400">
            Apply Now <i class="fas fa-arrow-right ml-2"></i>
          </button>
        </div>
      </div>

      <!-- Job 3 -->
      <div class="job-card bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 dark:bg-gray-800">
        <div class="flex items-start mb-4">
          <div class="w-16 h-16 rounded-lg overflow-hidden mr-4">
            <img src="https://source.unsplash.com/random/300x300/?quantum,company" alt="Company" class="w-full h-full object-cover">
          </div>
          <div>
            <h4 class="text-xl font-bold text-gray-800 dark:text-white">Quantum Software Engineer</h4>
            <p class="text-gray-600 dark:text-gray-400">QubitTech • Boston, MA • On-site</p>
          </div>
          <span class="ml-auto bg-cyan-100 text-cyan-800 text-xs px-3 py-1 rounded-full dark:bg-cyan-900/30 dark:text-cyan-400">$160K-$220K</span>
        </div>
        <p class="text-gray-600 mb-4 dark:text-gray-400">Develop quantum algorithms and software for our quantum computing platform using Qiskit and Cirq.</p>
        <div class="flex flex-wrap gap-2 mb-4">
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">Python</span>
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">Qiskit</span>
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">Quantum Physics</span>
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">Linear Algebra</span>
        </div>
        <div class="flex justify-between items-center">
          <span class="text-xs text-gray-500 dark:text-gray-400">Posted 3 days ago</span>
          <button class="text-cyan-600 text-sm font-medium hover:underline inline-flex items-center dark:text-cyan-400">
            Apply Now <i class="fas fa-arrow-right ml-2"></i>
          </button>
        </div>
      </div>

      <!-- Job 4 -->
      <div class="job-card bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 dark:bg-gray-800">
        <div class="flex items-start mb-4">
          <div class="w-16 h-16 rounded-lg overflow-hidden mr-4">
            <img src="https://source.unsplash.com/random/300x300/?robotics,company" alt="Company" class="w-full h-full object-cover">
          </div>
          <div>
            <h4 class="text-xl font-bold text-gray-800 dark:text-white">Robotics Engineer</h4>
            <p class="text-gray-600 dark:text-gray-400">AutoBotics • Seattle, WA • On-site</p>
          </div>
          <span class="ml-auto bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full dark:bg-green-900/30 dark:text-green-400">$140K-$190K</span>
        </div>
        <p class="text-gray-600 mb-4 dark:text-gray-400">Design and implement control systems for our next generation of autonomous robotic platforms.</p>
        <div class="flex flex-wrap gap-2 mb-4">
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">C++</span>
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">ROS</span>
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">Computer Vision</span>
          <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded dark:bg-gray-700 dark:text-gray-300">Machine Learning</span>
        </div>
        <div class="flex justify-between items-center">
          <span class="text-xs text-gray-500 dark:text-gray-400">Posted 5 days ago</span>
          <button class="text-green-600 text-sm font-medium hover:underline inline-flex items-center dark:text-green-400">
            Apply Now <i class="fas fa-arrow-right ml-2"></i>
          </button>
        </div>
      </div>
    </div>

    <div class="text-center mt-12">
      <button class="bg-white border-2 border-blue-500 text-blue-600 px-8 py-3 rounded-xl font-bold hover:bg-blue-50 transition-colors shadow-md hover:shadow-lg inline-flex items-center group dark:bg-gray-800 dark:border-blue-400 dark:text-blue-400 dark:hover:bg-gray-700">
        <span>View All Jobs</span>
        <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
      </button>
    </div>
  </section>

  <!-- Tech Events Calendar -->
  <section class="bg-gray-50 py-16 dark:bg-gray-900/50">
    <div class="container mx-auto px-4">
      <div class="text-center mb-16 animate-fade-in">
        <span class="text-blue-500 font-medium">UPCOMING EVENTS</span>
        <h3 class="text-3xl md:text-4xl font-bold mt-2 mb-4 title-font">Tech <span class="gradient-text">Events Calendar</span></h3>
        <p class="text-gray-600 max-w-2xl mx-auto dark:text-gray-400">Stay updated with the most important tech conferences, meetups and webinars</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Event 1 -->
        <div class="event-day bg-white rounded-xl shadow-md overflow-hidden dark:bg-gray-800">
          <div class="bg-blue-600 text-white text-center py-3">
            <h4 class="font-bold text-lg">June 15-17, 2023</h4>
          </div>
          <div class="p-6">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4 dark:bg-blue-900/30">
                <i class="fas fa-robot text-blue-600 dark:text-blue-400"></i>
              </div>
              <h4 class="text-lg font-bold text-gray-800 dark:text-white">AI Summit 2023</h4>
            </div>
            <p class="text-gray-600 mb-4 dark:text-gray-400">The premier conference on artificial intelligence and machine learning innovations.</p>
            <div class="flex items-center text-sm text-gray-500 mb-4 dark:text-gray-400">
              <i class="fas fa-map-marker-alt mr-2"></i>
              <span>San Francisco, CA & Online</span>
            </div>
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium transition-colors">
              Register Now
            </button>
          </div>
        </div>

        <!-- Event 2 -->
        <div class="event-day bg-white rounded-xl shadow-md overflow-hidden dark:bg-gray-800">
          <div class="bg-purple-600 text-white text-center py-3">
            <h4 class="font-bold text-lg">July 8-10, 2023</h4>
          </div>
          <div class="p-6">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-4 dark:bg-purple-900/30">
                <i class="fas fa-cube text-purple-600 dark:text-purple-400"></i>
              </div>
              <h4 class="text-lg font-bold text-gray-800 dark:text-white">Web3 Conference</h4>
            </div>
            <p class="text-gray-600 mb-4 dark:text-gray-400">Exploring the future of decentralized web, blockchain and digital ownership.</p>
            <div class="flex items-center text-sm text-gray-500 mb-4 dark:text-gray-400">
              <i class="fas fa-map-marker-alt mr-2"></i>
              <span>Virtual Event</span>
            </div>
            <button class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg font-medium transition-colors">
              Register Now
            </button>
          </div>
        </div>

        <!-- Event 3 -->
        <div class="event-day bg-white rounded-xl shadow-md overflow-hidden dark:bg-gray-800">
          <div class="bg-cyan-600 text-white text-center py-3">
            <h4 class="font-bold text-lg">August 22-24, 2023</h4>
          </div>
          <div class="p-6">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 rounded-full bg-cyan-100 flex items-center justify-center mr-4 dark:bg-cyan-900/30">
                <i class="fas fa-atom text-cyan-600 dark:text-cyan-400"></i>
              </div>
              <h4 class="text-lg font-bold text-gray-800 dark:text-white">Quantum Tech Expo</h4>
            </div>
            <p class="text-gray-600 mb-4 dark:text-gray-400">Showcasing breakthroughs in quantum computing, communication and cryptography.</p>
            <div class="flex items-center text-sm text-gray-500 mb-4 dark:text-gray-400">
              <i class="fas fa-map-marker-alt mr-2"></i>
              <span>Boston, MA & Online</span>
            </div>
            <button class="w-full bg-cyan-600 hover:bg-cyan-700 text-white py-2 rounded-lg font-medium transition-colors">
              Register Now
            </button>
          </div>
        </div>
      </div>

      <div class="text-center mt-12">
        <button class="bg-white border-2 border-blue-500 text-blue-600 px-8 py-3 rounded-xl font-bold hover:bg-blue-50 transition-colors shadow-md hover:shadow-lg inline-flex items-center group dark:bg-gray-800 dark:border-blue-400 dark:text-blue-400 dark:hover:bg-gray-700">
          <span>View All Events</span>
          <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
        </button>
      </div>
    </div>
  </section>

  <!-- Futuristic CTA -->
  <section class="relative overflow-hidden py-20 bg-gradient-to-br from-gray-900 to-blue-900/80 text-white">
    <!-- Animated background elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20">
      <div class="absolute top-0 left-0 w-1 h-1 bg-white rounded-full" style="box-shadow: 0 0 20px 10px white;"></div>
      <div class="absolute top-1/4 left-1/4 w-1 h-1 bg-white rounded-full" style="box-shadow: 0 0 30px 15px white;"></div>
      <div class="absolute top-1/2 right-1/4 w-1 h-1 bg-white rounded-full" style="box-shadow: 0 0 25px 10px white;"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
      <div class="max-w-4xl mx-auto text-center">
        <div class="inline-block bg-white/10 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm mb-6 text-blue-300 border border-blue-400/30">
          <i class="fas fa-gem mr-1"></i> EXCLUSIVE CONTENT
        </div>
        <h3 class="text-3xl md:text-5xl font-bold mb-6 leading-tight title-font">
          Join Our <span class="gradient-text">Tech Community</span> Today
        </h3>
        <p class="text-xl mb-10 opacity-90 max-w-3xl mx-auto">
          Get access to premium articles, exclusive tech reports, and connect with like-minded innovators.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4 max-w-xl mx-auto">
          <div class="relative flex-grow">
            <input type="email" placeholder="Your email address"
              class="w-full px-6 py-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900 pr-14 bg-white/90 backdrop-blur-sm">
          </div>
          <button class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-4 rounded-xl font-bold hover:from-blue-600 hover:to-blue-700 transition-all shadow-lg glow hover:shadow-xl flex items-center justify-center whitespace-nowrap">
            <i class="fas fa-lock-open mr-2"></i> Get Access
          </button>
        </div>

        <div class="mt-8 flex flex-wrap justify-center gap-4">
          <div class="flex items-center">
            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center mr-2">
              <i class="fas fa-check text-xs text-white"></i>
            </div>
            <span class="text-sm">Weekly Tech Briefings</span>
          </div>
          <div class="flex items-center">
            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center mr-2">
              <i class="fas fa-check text-xs text-white"></i>
            </div>
            <span class="text-sm">Exclusive Content</span>
          </div>
          <div class="flex items-center">
            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center mr-2">
              <i class="fas fa-check text-xs text-white"></i>
            </div>
            <span class="text-sm">Community Access</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Tech News Ticker -->
  <div class="bg-gray-800 text-white py-3 overflow-hidden dark:bg-gray-900">
    <div class="container mx-auto px-4">
      <div class="flex items-center">
        <div class="bg-blue-600 text-white px-3 py-1 rounded mr-4 whitespace-nowrap flex items-center">
          <i class="fas fa-bolt mr-2"></i> BREAKING
        </div>
        <div class="ticker-container overflow-hidden">
          <div class="animate-marquee whitespace-nowrap">
            <span class="ticker-item">OpenAI announces GPT-5 with multimodal capabilities</span>
            <span class="ticker-item">Quantum computer breaks encryption record with 128-qubit processor</span>
            <span class="ticker-item">Apple reveals AR glasses for 2024 release with revolutionary interface</span>
            <span class="ticker-item">Tesla humanoid robots enter production, first units shipping to factories</span>
            <span class="ticker-item">Web3 internet protocol reaches 1M nodes, surpassing traditional CDNs</span>
            <span class="ticker-item">Neuralink receives FDA approval for human trials of brain-computer interface</span>
            <span class="ticker-item">Fusion energy breakthrough: Net energy gain sustained for 30 minutes</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Latest Tutorials -->
  <section id="tutorials" class="container mx-auto px-4 py-16">
    <div class="text-center mb-16 animate-fade-in">
      <span class="text-blue-500 font-medium">LEARN FUTURE TECH</span>
      <h3 class="text-3xl md:text-4xl font-bold mt-2 mb-4 title-font">Master <span class="gradient-text">Next-Gen</span> Skills</h3>
      <p class="text-gray-600 max-w-2xl mx-auto dark:text-gray-400">Hands-on tutorials to help you stay ahead in the rapidly evolving tech landscape</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Tutorial 1 -->
      <div class="group bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-500 overflow-hidden animate-slide-up dark:bg-gray-800">
        <div class="relative h-48 overflow-hidden">
          <img src="https://source.unsplash.com/random/600x400/?coding,blockchain" alt="Blockchain Tutorial"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
          <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
          <div class="absolute bottom-4 left-4">
            <span class="bg-purple-600 text-white px-2 py-1 rounded text-xs font-bold">ADVANCED</span>
          </div>
          <div class="absolute top-4 right-4 bg-white/90 text-purple-600 w-12 h-12 rounded-full flex items-center justify-center shadow-md dark:bg-gray-900/90">
            <i class="fas fa-code text-xl"></i>
          </div>
        </div>
        <div class="p-6">
          <div class="flex items-center text-sm text-gray-500 mb-3 dark:text-gray-400">
            <span><i class="far fa-clock mr-1"></i> 45 min</span>
            <span class="mx-2">•</span>
            <span><i class="fas fa-signal mr-1"></i> Intermediate</span>
          </div>
          <h4 class="text-xl font-bold mb-3 text-gray-800 group-hover:text-blue-600 transition-colors dark:text-white dark:group-hover:text-blue-400">
            Building a DApp with Solidity and React
          </h4>
          <p class="text-gray-600 mb-5 dark:text-gray-400">Step-by-step guide to creating your first decentralized application on Ethereum.</p>
          <div class="flex justify-between items-center">
            <div class="flex items-center">
              <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Instructor"
                class="w-8 h-8 rounded-full mr-2">
              <span class="text-sm font-medium dark:text-gray-300">Alex Chen</span>
            </div>
            <a href="#" class="text-blue-600 hover:underline inline-flex items-center dark:text-blue-400">
              Start <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Tutorial 2 -->
      <div class="group bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-500 overflow-hidden animate-slide-up dark:bg-gray-800" style="animation-delay: 0.1s">
        <div class="relative h-48 overflow-hidden">
          <img src="https://source.unsplash.com/random/600x400/?machine,learning" alt="ML Tutorial"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
          <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
          <div class="absolute bottom-4 left-4">
            <span class="bg-blue-600 text-white px-2 py-1 rounded text-xs font-bold">PYTHON</span>
          </div>
          <div class="absolute top-4 right-4 bg-white/90 text-blue-600 w-12 h-12 rounded-full flex items-center justify-center shadow-md dark:bg-gray-900/90">
            <i class="fas fa-brain text-xl"></i>
          </div>
        </div>
        <div class="p-6">
          <div class="flex items-center text-sm text-gray-500 mb-3 dark:text-gray-400">
            <span><i class="far fa-clock mr-1"></i> 1h 15min</span>
            <span class="mx-2">•</span>
            <span><i class="fas fa-signal mr-1"></i> Beginner</span>
          </div>
          <h4 class="text-xl font-bold mb-3 text-gray-800 group-hover:text-blue-600 transition-colors dark:text-white dark:group-hover:text-blue-400">
            Introduction to TensorFlow 2.0
          </h4>
          <p class="text-gray-600 mb-5 dark:text-gray-400">Learn the fundamentals of deep learning with Google's powerful ML framework.</p>
          <div class="flex justify-between items-center">
            <div class="flex items-center">
              <img src="https://randomuser.me/api/portraits/women/33.jpg" alt="Instructor"
                class="w-8 h-8 rounded-full mr-2">
              <span class="text-sm font-medium dark:text-gray-300">Priya Patel</span>
            </div>
            <a href="#" class="text-blue-600 hover:underline inline-flex items-center dark:text-blue-400">
              Start <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Tutorial 3 -->
      <div class="group bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-500 overflow-hidden animate-slide-up dark:bg-gray-800" style="animation-delay: 0.2s">
        <div class="relative h-48 overflow-hidden">
          <img src="https://source.unsplash.com/random/600x400/?quantum,physics" alt="Quantum Tutorial"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
          <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
          <div class="absolute bottom-4 left-4">
            <span class="bg-cyan-600 text-white px-2 py-1 rounded text-xs font-bold">NEW</span>
          </div>
          <div class="absolute top-4 right-4 bg-white/90 text-cyan-600 w-12 h-12 rounded-full flex items-center justify-center shadow-md dark:bg-gray-900/90">
            <i class="fas fa-atom text-xl"></i>
          </div>
        </div>
        <div class="p-6">
          <div class="flex items-center text-sm text-gray-500 mb-3 dark:text-gray-400">
            <span><i class="far fa-clock mr-1"></i> 2h 30min</span>
            <span class="mx-2">•</span>
            <span><i class="fas fa-signal mr-1"></i> Advanced</span>
          </div>
          <h4 class="text-xl font-bold mb-3 text-gray-800 group-hover:text-blue-600 transition-colors dark:text-white dark:group-hover:text-blue-400">
            Quantum Programming with Qiskit
          </h4>
          <p class="text-gray-600 mb-5 dark:text-gray-400">Hands-on introduction to quantum algorithms and IBM's quantum computing platform.</p>
          <div class="flex justify-between items-center">
            <div class="flex items-center">
              <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Instructor"
                class="w-8 h-8 rounded-full mr-2">
              <span class="text-sm font-medium dark:text-gray-300">Dr. James Wilson</span>
            </div>
            <a href="#" class="text-blue-600 hover:underline inline-flex items-center dark:text-blue-400">
              Start <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center mt-12">
      <button class="bg-white border-2 border-blue-500 text-blue-600 px-8 py-3 rounded-xl font-bold hover:bg-blue-50 transition-colors shadow-md hover:shadow-lg inline-flex items-center group dark:bg-gray-800 dark:border-blue-400 dark:text-blue-400 dark:hover:bg-gray-700">
        <span>View All Tutorials</span>
        <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
      </button>
    </div>
  </section>

  <!-- Coding Tutorials Section -->
  <section id="coding-tutorials" class="container mx-auto px-4 py-16 relative overflow-hidden">
    <!-- Animated background elements -->
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
      <div class="absolute top-20 left-10 w-16 h-16 rounded-full bg-blue-500/10 blur-xl animate-float"></div>
      <div class="absolute bottom-1/4 right-1/4 w-24 h-24 rounded-full bg-purple-500/10 blur-xl animate-float" style="animation-delay: 2s;"></div>
    </div>

    <div class="text-center mb-16 animate-fade-in relative z-10">
      <span class="inline-block bg-blue-500/10 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm mb-6 text-blue-300 border border-blue-400/30 animate-pulse">
        <i class="fas fa-code mr-1"></i> HANDS-ON LEARNING
      </span>
      <h3 class="text-4xl md:text-5xl font-bold mb-6 leading-tight title-font">
        Interactive <span class="gradient-text">Coding Tutorials</span>
      </h3>
      <p class="text-xl md:text-2xl mb-10 opacity-90 max-w-3xl mx-auto dark:text-gray-300">
        Learn by doing with our immersive coding experience. Type, run, and see results instantly!
      </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 relative z-10">
      <!-- Tutorial Sidebar - Futuristic Glass Panel -->
      <div class="lg:col-span-1">
        <div class="bg-white/5 backdrop-blur-md rounded-2xl shadow-xl overflow-hidden border border-gray-800/50 dark:border-gray-700/30 holographic-effect">
          <div class="p-6 border-b border-gray-800/30 dark:border-gray-700/20">
            <h4 class="text-xl font-bold text-white flex items-center">
              <i class="fas fa-map mr-3 text-blue-400"></i> Tutorial Paths
            </h4>
          </div>

          <div class="p-4 space-y-2">
            <div class="sidebar-item active group">
              <div class="flex items-center justify-between p-3 rounded-lg bg-gradient-to-r from-blue-600/20 to-blue-600/10 border border-blue-500/20">
                <span class="font-medium text-white">Getting Started with JavaScript</span>
                <span class="challenge-badge bg-blue-600/80 text-blue-100">5 Challenges</span>
              </div>
              <div class="absolute inset-0 -z-10 bg-blue-600/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>

            <div class="sidebar-item group">
              <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-800/30 dark:hover:bg-gray-700/30 transition-colors border border-transparent hover:border-gray-700/20">
                <span class="font-medium text-gray-300 group-hover:text-white">Python for Beginners</span>
                <span class="challenge-badge bg-green-600/80 text-green-100">7 Challenges</span>
              </div>
            </div>

            <div class="sidebar-item group">
              <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-800/30 dark:hover:bg-gray-700/30 transition-colors border border-transparent hover:border-gray-700/20">
                <span class="font-medium text-gray-300 group-hover:text-white">Web Development</span>
                <span class="challenge-badge bg-purple-600/80 text-purple-100">8 Challenges</span>
              </div>
            </div>

            <div class="sidebar-item group">
              <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-800/30 dark:hover:bg-gray-700/30 transition-colors border border-transparent hover:border-gray-700/20">
                <span class="font-medium text-gray-300 group-hover:text-white">Blockchain Basics</span>
                <span class="challenge-badge bg-yellow-600/80 text-yellow-100">4 Challenges</span>
              </div>
            </div>

            <div class="sidebar-item group">
              <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-800/30 dark:hover:bg-gray-700/30 transition-colors border border-transparent hover:border-gray-700/20">
                <span class="font-medium text-gray-300 group-hover:text-white">Machine Learning</span>
                <span class="challenge-badge bg-red-600/80 text-red-100">6 Challenges</span>
              </div>
            </div>
          </div>

          <div class="p-6 border-t border-gray-800/30 dark:border-gray-700/20">
            <h4 class="text-xl font-bold text-white flex items-center mb-4">
              <i class="fas fa-bolt mr-3 text-purple-400"></i> Quick Challenges
            </h4>
            <div class="space-y-2">
              <div class="sidebar-item group">
                <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-800/30 dark:hover:bg-gray-700/30 transition-colors">
                  <span class="font-medium text-gray-300 group-hover:text-white">FizzBuzz</span>
                  <span class="difficulty-badge difficulty-beginner">Beginner</span>
                </div>
              </div>

              <div class="sidebar-item group">
                <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-800/30 dark:hover:bg-gray-700/30 transition-colors">
                  <span class="font-medium text-gray-300 group-hover:text-white">Palindrome Checker</span>
                  <span class="difficulty-badge difficulty-beginner">Beginner</span>
                </div>
              </div>

              <div class="sidebar-item group">
                <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-800/30 dark:hover:bg-gray-700/30 transition-colors">
                  <span class="font-medium text-gray-300 group-hover:text-white">Caesar Cipher</span>
                  <span class="difficulty-badge difficulty-intermediate">Intermediate</span>
                </div>
              </div>

              <div class="sidebar-item group">
                <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-800/30 dark:hover:bg-gray-700/30 transition-colors">
                  <span class="font-medium text-gray-300 group-hover:text-white">Binary Search</span>
                  <span class="difficulty-badge difficulty-intermediate">Intermediate</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tutorial Content - Futuristic Terminal Style -->
      <div class="lg:col-span-3">
        <div class="bg-gray-900/80 backdrop-blur-md rounded-2xl shadow-xl overflow-hidden border border-gray-800/50 dark:border-gray-700/30">
          <div class="p-6 border-b border-gray-800/30 dark:border-gray-700/20">
            <div class="flex items-center justify-between">
              <div>
                <h4 class="text-2xl font-bold text-white flex items-center">
                  <i class="fas fa-terminal mr-3 text-blue-400 animate-pulse"></i>
                  <span>Getting Started with JavaScript</span>
                </h4>
                <div class="flex items-center mt-2">
                  <span class="text-sm text-blue-300 mr-3">
                    <i class="fas fa-map-marker-alt mr-1"></i> Tutorial 1 of 5
                  </span>
                  <span class="difficulty-badge difficulty-beginner">
                    <i class="fas fa-star mr-1"></i> Beginner
                  </span>
                </div>
              </div>
              <div class="flex items-center space-x-2">
                <button class="px-3 py-1 rounded-full bg-blue-600/20 text-blue-300 border border-blue-500/30 hover:bg-blue-600/30 transition-colors text-sm">
                  <i class="fas fa-bookmark mr-1"></i> Save
                </button>
                <button class="px-3 py-1 rounded-full bg-purple-600/20 text-purple-300 border border-purple-500/30 hover:bg-purple-600/30 transition-colors text-sm">
                  <i class="fas fa-share-alt mr-1"></i> Share
                </button>
              </div>
            </div>

            <div class="tutorial-progress mt-4">
              <div class="h-1.5 w-full bg-gray-800 rounded-full overflow-hidden">
                <div class="progress-bar h-full bg-gradient-to-r from-blue-500 to-blue-600" style="width: 20%"></div>
              </div>
              <div class="text-xs text-gray-400 mt-1 text-right">20% completed</div>
            </div>
          </div>

          <div class="p-6">
            <div class="tutorial-step mb-8">
              <div class="flex items-start mb-6">
                <div class="bg-blue-600/10 border border-blue-500/20 rounded-lg p-3 mr-4">
                  <span class="text-blue-400 font-bold text-2xl">1</span>
                </div>
                <div>
                  <h5 class="text-xl font-bold text-white mb-2">Variables and Data Types</h5>
                  <p class="text-gray-300">
                    JavaScript variables are containers for storing data values. In this tutorial, you'll learn how to declare variables and work with different data types.
                  </p>
                </div>
              </div>

              <!-- Futuristic Code Editor -->
              <div class="code-editor-container mb-6 glow-effect hover:glow-effect-lg transition-all duration-300">
                <div class="editor-header bg-gray-800 border-b border-gray-700/50">
                  <div class="flex items-center">
                    <div class="flex space-x-2 mr-4">
                      <span class="w-3 h-3 rounded-full bg-red-500"></span>
                      <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                      <span class="w-3 h-3 rounded-full bg-green-500"></span>
                    </div>
                    <span class="text-gray-300 font-mono text-sm">script.js</span>
                  </div>
                  <div class="editor-actions">
                    <button class="run-button glow-blue" onclick="runCode()">
                      <i class="fas fa-play mr-2"></i> Run Code
                      <span class="ml-2 text-xs opacity-80">(Ctrl+Enter)</span>
                    </button>
                  </div>
                </div>
                <textarea id="codeEditor">// Declaring variables
let message = "Hello, World!";
const PI = 3.14159;
var count = 10;

// Different data types
let isActive = true; // boolean
let price = 19.99; // number
let name = "Alice"; // string
let fruits = ["apple", "banana", "orange"]; // array
let person = { firstName: "John", age: 30 }; // object

// Try declaring your own variables below:
console.log(message);</textarea>
              </div>

              <div class="output-container bg-gray-800 rounded-lg border border-gray-700/50" id="output">
                <div class="output-header bg-gray-800/80 border-b border-gray-700/50 px-4 py-2 text-gray-300 text-sm font-mono">
                  <i class="fas fa-chevron-right text-blue-400 mr-2"></i> Output
                </div>
                <div class="p-4 text-gray-200 font-mono text-sm min-h-[100px]">
                  <!-- Output will appear here -->
                </div>
              </div>

              <div class="bg-blue-900/20 rounded-xl p-4 mt-6 border border-blue-800/30">
                <div class="flex">
                  <div class="mr-3 text-blue-400 text-xl">
                    <i class="fas fa-lightbulb"></i>
                  </div>
                  <div>
                    <h6 class="font-semibold text-blue-300 mb-1">Pro Tip</h6>
                    <p class="text-blue-200 text-sm">
                      Use <code class="bg-blue-900/50 px-1.5 py-0.5 rounded">let</code> for variables that will change, and <code class="bg-blue-900/50 px-1.5 py-0.5 rounded">const</code> for variables that won't change. Avoid using <code class="bg-blue-900/50 px-1.5 py-0.5 rounded">var</code> in modern JavaScript.
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Challenge Section -->
            <div class="tutorial-step">
              <div class="flex items-start mb-6">
                <div class="bg-purple-600/10 border border-purple-500/20 rounded-lg p-3 mr-4">
                  <span class="text-purple-400 font-bold text-2xl">2</span>
                </div>
                <div>
                  <h5 class="text-xl font-bold text-white mb-2">Challenge: Variable Practice</h5>
                  <p class="text-gray-300">
                    Now it's your turn! Complete the following tasks by declaring variables in the editor:
                  </p>
                </div>
              </div>

              <div class="bg-gray-800/50 rounded-xl p-5 mb-6 border border-gray-700/30">
                <ol class="list-decimal pl-5 space-y-3 text-gray-300">
                  <li class="pl-2">Declare a constant called <code class="bg-gray-700/80 px-1.5 py-0.5 rounded border border-gray-600/50">TAX_RATE</code> with value 0.07</li>
                  <li class="pl-2">Declare a variable called <code class="bg-gray-700/80 px-1.5 py-0.5 rounded border border-gray-600/50">price</code> with value 25</li>
                  <li class="pl-2">Calculate the total price with tax and store it in a variable called <code class="bg-gray-700/80 px-1.5 py-0.5 rounded border border-gray-600/50">total</code></li>
                  <li class="pl-2">Create a string variable called <code class="bg-gray-700/80 px-1.5 py-0.5 rounded border border-gray-600/50">receipt</code> that combines text and variables like: "Total with tax: $[total]"</li>
                </ol>
              </div>

              <div class="code-editor-container mb-6 glow-effect hover:glow-effect-lg transition-all duration-300">
                <div class="editor-header bg-gray-800 border-b border-gray-700/50">
                  <div class="flex items-center">
                    <div class="flex space-x-2 mr-4">
                      <span class="w-3 h-3 rounded-full bg-red-500"></span>
                      <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                      <span class="w-3 h-3 rounded-full bg-green-500"></span>
                    </div>
                    <span class="text-gray-300 font-mono text-sm">challenge.js</span>
                  </div>
                  <div class="editor-actions">
                    <button class="run-button glow-blue mr-2" onclick="runChallenge()">
                      <i class="fas fa-play mr-2"></i> Run Code
                    </button>
                    <button class="run-button glow-green" onclick="checkSolution()">
                      <i class="fas fa-check mr-2"></i> Check Solution
                    </button>
                  </div>
                </div>
                <textarea id="challengeEditor">// Complete the challenge here</textarea>
              </div>

              <div class="output-container bg-gray-800 rounded-lg border border-gray-700/50" id="challengeOutput">
                <div class="output-header bg-gray-800/80 border-b border-gray-700/50 px-4 py-2 text-gray-300 text-sm font-mono">
                  <i class="fas fa-chevron-right text-purple-400 mr-2"></i> Challenge Results
                </div>
                <div class="p-4 text-gray-200 font-mono text-sm min-h-[100px]">
                  <!-- Challenge output will appear here -->
                </div>
              </div>
            </div>
          </div>

          <!-- Navigation -->
          <div class="p-6 border-t border-gray-800/30 dark:border-gray-700/20">
            <div class="flex justify-between">
              <button class="px-5 py-2.5 rounded-lg bg-gray-800 hover:bg-gray-700/80 text-gray-300 hover:text-white transition-colors border border-gray-700/50 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Previous Lesson
              </button>
              <button class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white transition-all shadow-lg glow flex items-center">
                Next Challenge <i class="fas fa-arrow-right ml-2"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- AI Assistant -->
  <div class="ai-assistant">
    <div class="ai-assistant-chat">
      <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4">
        <div class="flex items-center">
          <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-3">
            <i class="fas fa-robot"></i>
          </div>
          <div>
            <h4 class="font-bold">NexTech AI Assistant</h4>
            <p class="text-xs opacity-80">Ask me anything about technology</p>
          </div>
          <button class="ml-auto text-white/70 hover:text-white">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="p-4 h-80 overflow-y-auto">
        <div class="flex mb-4">
          <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3 dark:bg-blue-900/30">
            <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
          </div>
          <div class="bg-gray-100 rounded-lg p-3 max-w-xs dark:bg-gray-700">
            <p class="text-sm dark:text-gray-300">What's the latest in quantum computing?</p>
          </div>
        </div>
        <div class="flex justify-end mb-4">
          <div class="bg-blue-600 text-white rounded-lg p-3 max-w-xs">
            <p class="text-sm">The latest breakthrough in quantum computing is IBM's 433-qubit Osprey processor, announced in November 2022. This represents a significant step toward practical quantum advantage.</p>
          </div>
          <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center ml-3">
            <i class="fas fa-robot text-white"></i>
          </div>
        </div>
        <div class="text-center text-xs text-gray-500 my-4 dark:text-gray-400">
          <span>Today</span>
        </div>
      </div>
      <div class="border-t p-4 dark:border-gray-700">
        <div class="relative">
          <input type="text" placeholder="Ask about any tech topic..."
            class="w-full px-4 py-3 rounded-full bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-12 dark:bg-gray-700 dark:text-white">
          <button class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-blue-600 dark:hover:text-blue-400">
            <i class="fas fa-paper-plane"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="ai-assistant-button tooltip">
      <i class="fas fa-robot text-2xl text-white"></i>
      <span class="tooltip-text">AI Assistant</span>
    </div>
  </div>

  <!-- Futuristic Footer -->
  <footer class="bg-gray-900 text-gray-300 pt-16 pb-8">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
        <div>
          <div class="flex items-center space-x-3 mb-6">
            <div class="holographic-effect rounded-full p-2 glow">
              <i class="fas fa-brain text-2xl text-blue-400"></i>
            </div>
            <h2 class="text-2xl font-bold text-white title-font">Nex<span class="gradient-text">Tech</span></h2>
          </div>
          <p class="mb-6">Exploring the frontier of technology and innovation to shape a better future.</p>
          <div class="flex space-x-4">
            <a href="#" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-blue-600 flex items-center justify-center text-gray-300 hover:text-white transition-colors glow">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-blue-700 flex items-center justify-center text-gray-300 hover:text-white transition-colors glow">
              <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-pink-600 flex items-center justify-center text-gray-300 hover:text-white transition-colors glow">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-red-600 flex items-center justify-center text-gray-300 hover:text-white transition-colors glow">
              <i class="fab fa-youtube"></i>
            </a>
          </div>
        </div>
        <div>
          <h4 class="text-lg font-semibold text-white mb-6">Explore</h4>
          <ul class="space-y-3">
            <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center">
                <i class="fas fa-chevron-right text-xs mr-2 text-blue-400"></i> AI Research
              </a></li>
            <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center">
                <i class="fas fa-chevron-right text-xs mr-2 text-blue-400"></i> Web3 Development
              </a></li>
            <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center">
                <i class="fas fa-chevron-right text-xs mr-2 text-blue-400"></i> Quantum Computing
              </a></li>
            <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center">
                <i class="fas fa-chevron-right text-xs mr-2 text-blue-400"></i> Robotics
              </a></li>
            <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center">
                <i class="fas fa-chevron-right text-xs mr-2 text-blue-400"></i> Space Tech
              </a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-lg font-semibold text-white mb-6">Company</h4>
          <ul class="space-y-3">
            <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center">
                <i class="fas fa-chevron-right text-xs mr-2 text-blue-400"></i> About Us
              </a></li>
            <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center">
                <i class="fas fa-chevron-right text-xs mr-2 text-blue-400"></i> Our Team
              </a></li>
            <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center">
                <i class="fas fa-chevron-right text-xs mr-2 text-blue-400"></i> Careers
              </a></li>
            <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center">
                <i class="fas fa-chevron-right text-xs mr-2 text-blue-400"></i> Contact
              </a></li>
            <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center">
                <i class="fas fa-chevron-right text-xs mr-2 text-blue-400"></i> Partners
              </a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-lg font-semibold text-white mb-6">Newsletter</h4>
          <p class="mb-4">Subscribe to get the latest tech news and insights delivered to your inbox.</p>
          <form class="space-y-3">
            <input type="email" placeholder="Your email" class="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-blue-500">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors flex items-center justify-center">
              <i class="fas fa-paper-plane mr-2"></i> Subscribe
            </button>
          </form>
        </div>
      </div>

      <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
        <p>© 2023 NexTech. All rights reserved.</p>
        <div class="flex space-x-6 mt-4 md:mt-0">
          <a href="#" class="text-sm hover:text-blue-400 transition-colors">Privacy Policy</a>
          <a href="#" class="text-sm hover:text-blue-400 transition-colors">Terms of Service</a>
          <a href="#" class="text-sm hover:text-blue-400 transition-colors">Cookies</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Back to Top Button -->
  <button id="backToTop" class="fixed bottom-8 right-8 w-12 h-12 rounded-full bg-blue-600 text-white shadow-xl hover:bg-blue-700 transition-colors flex items-center justify-center opacity-0 invisible transition-all duration-300 z-30">
    <i class="fas fa-arrow-up"></i>
  </button>

  <script>
    // Loading screen animation
    window.addEventListener('load', function() {
      // Create particles
      const particlesContainer = document.querySelector('.particles');
      for (let i = 0; i < 20; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        particle.style.width = `${Math.random() * 5 + 2}px`;
        particle.style.height = particle.style.width;
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.animationDuration = `${Math.random() * 10 + 10}s`;
        particle.style.animationDelay = `${Math.random() * 5}s`;
        particlesContainer.appendChild(particle);
      }

      // Hide loading screen
      setTimeout(() => {
        const loading = document.getElementById('loading');
        loading.style.opacity = '0';
        setTimeout(() => {
          loading.style.display = 'none';
        }, 1000);
      }, 1500);
    });

    // Back to top button
    const backToTopButton = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
      if (window.pageYOffset > 300) {
        backToTopButton.style.opacity = '1';
        backToTopButton.style.visibility = 'visible';
      } else {
        backToTopButton.style.opacity = '0';
        backToTopButton.style.visibility = 'hidden';
      }
    });

    backToTopButton.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });

    // Marquee animation for news ticker
    const marquee = document.querySelector('.animate-marquee');
    if (marquee) {
      const marqueeContent = marquee.innerHTML;
      marquee.innerHTML = marqueeContent + marqueeContent;

      // Calculate duration based on content width
      const width = marquee.scrollWidth / 2;
      const duration = width / 50; // pixels per second
      marquee.style.animationDuration = `${duration}s`;
    }

    // Card hover effects
    document.querySelectorAll('.tech-card').forEach(card => {
      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const angleY = (x - centerX) / 20;
        const angleX = (centerY - y) / 20;

        card.querySelector('.tech-card-inner').style.transform = `rotateY(${angleY}deg) rotateX(${angleX}deg)`;
      });

      card.addEventListener('mouseleave', () => {
        card.querySelector('.tech-card-inner').style.transform = 'rotateY(0) rotateX(0)';
      });
    });

    // AI Assistant toggle
    const aiAssistant = document.querySelector('.ai-assistant');
    const aiAssistantButton = document.querySelector('.ai-assistant-button');

    aiAssistantButton.addEventListener('click', () => {
      aiAssistant.classList.toggle('active');
    });

    // Voice search
    const voiceSearch = document.getElementById('voiceSearch');
    const voiceStatus = document.getElementById('voiceStatus');

    if ('webkitSpeechRecognition' in window) {
      const recognition = new webkitSpeechRecognition();
      recognition.continuous = false;
      recognition.interimResults = false;

      voiceSearch.addEventListener('click', () => {
        recognition.start();
        voiceStatus.classList.remove('hidden');
      });

      recognition.onresult = (event) => {
        const transcript = event.results[0][0].transcript;
        document.querySelector('input[type="text"]').value = transcript;
        voiceStatus.classList.add('hidden');
        // Here you would typically trigger the search
        console.log('Searching for:', transcript);
      };

      recognition.onerror = (event) => {
        voiceStatus.classList.add('hidden');
        console.error('Voice recognition error', event.error);
      };
    } else {
      voiceSearch.style.display = 'none';
    }

    // Dark mode toggle
    const themeToggle = document.getElementById('themeToggle');

    themeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark');

      // Save preference to localStorage
      const isDark = document.body.classList.contains('dark');
      localStorage.setItem('darkMode', isDark);
    });

    // Check for saved theme preference
    if (localStorage.getItem('darkMode') === 'true') {
      document.body.classList.add('dark');
    }

    // 3D Tech Sphere
    function initTechSphere() {
      const canvas = document.getElementById('techSphere');
      const renderer = new THREE.WebGLRenderer({
        canvas,
        alpha: true,
        antialias: true
      });

      const scene = new THREE.Scene();
      const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
      camera.position.z = 5;

      // Add ambient light
      const ambientLight = new THREE.AmbientLight(0x404040);
      scene.add(ambientLight);

      // Add directional light
      const directionalLight = new THREE.DirectionalLight(0xffffff, 0.5);
      directionalLight.position.set(1, 1, 1);
      scene.add(directionalLight);

      // Create sphere geometry
      const geometry = new THREE.SphereGeometry(2, 32, 32);

      // Load tech texture
      const textureLoader = new THREE.TextureLoader();
      const texture = textureLoader.load('https://threejs.org/examples/textures/planets/earth_atmos_2048.jpg');

      // Create material with wireframe effect
      const material = new THREE.MeshPhongMaterial({
        map: texture,
        transparent: true,
        opacity: 0.7,
        wireframe: false,
        emissive: 0x1a3d7c,
        emissiveIntensity: 0.2,
        specular: 0x111111,
        shininess: 30
      });

      const sphere = new THREE.Mesh(geometry, material);
      scene.add(sphere);

      // Add orbit controls
      const controls = new THREE.OrbitControls(camera, renderer.domElement);
      controls.enableZoom = false;
      controls.enablePan = false;
      controls.autoRotate = true;
      controls.autoRotateSpeed = 0.5;

      // Handle window resize
      function onWindowResize() {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
      }

      window.addEventListener('resize', onWindowResize, false);

      // Animation loop
      function animate() {
        requestAnimationFrame(animate);
        controls.update();
        sphere.rotation.y += 0.002;
        renderer.render(scene, camera);
      }

      // Start animation
      animate();

      // Set initial size
      onWindowResize();
    }

    // Initialize 3D sphere when page loads
    initTechSphere();

    function runCode() {
  const code = document.getElementById('codeEditor').value;
  const outputDiv = document.querySelector('#output div:last-child');
  
  try {
    // Clear previous output
    outputDiv.innerHTML = '';
    
    // Capture console.log output
    const originalConsoleLog = console.log;
    let output = '';
    console.log = function(message) {
      output += message + '\n';
      originalConsoleLog.apply(console, arguments);
    };
    
    // Execute the code
    new Function(code)();
    
    // Restore console.log
    console.log = originalConsoleLog;
    
    // Display output
    outputDiv.textContent = output || 'Code executed successfully (no output)';
  } catch (error) {
    outputDiv.textContent = 'Error: ' + error.message;
    outputDiv.style.color = '#ef4444';
  }
}

function runChallenge() {
  // Similar to runCode but for challenge editor
  const code = document.getElementById('challengeEditor').value;
  const outputDiv = document.querySelector('#challengeOutput div:last-child');
  
  try {
    outputDiv.innerHTML = '';
    const originalConsoleLog = console.log;
    let output = '';
    console.log = function(message) {
      output += message + '\n';
      originalConsoleLog.apply(console, arguments);
    };
    
    new Function(code)();
    console.log = originalConsoleLog;
    outputDiv.textContent = output || 'Challenge code executed (no output)';
  } catch (error) {
    outputDiv.textContent = 'Error: ' + error.message;
    outputDiv.style.color = '#ef4444';
  }
}

function checkSolution() {
  // Add your solution checking logic here
  const outputDiv = document.querySelector('#challengeOutput div:last-child');
  outputDiv.textContent = 'Solution checking not yet implemented';
}
  </script>
</body>

</html>