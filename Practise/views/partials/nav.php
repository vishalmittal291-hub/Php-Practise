<!-- Thin accent line across the very top, just for a bit of color. -->
<div class="h-1 bg-gradient-to-r from-indigo-500 via-teal-400 to-indigo-500"></div>

<nav class="bg-gray-900 border-b border-white/10">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">
      <div class="flex items-center gap-10">
        <a href="/" class="flex items-center">
          <svg class="h-6 w-6 text-indigo-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 15c2-3 4-3 6 0s4 3 6 0 4-3 6 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M3 9c2-3 4-3 6 0s4 3 6 0 4-3 6 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" opacity="0.5"/>
          </svg>
        </a>

        <div class="hidden sm:flex sm:gap-8">
          <a href="/" class="text-sm font-medium <?= urlIs('/') ? 'text-white' : 'text-gray-400 hover:text-white' ?>">Home</a>
          <a href="/about" class="text-sm font-medium <?= urlIs('/about') ? 'text-white' : 'text-gray-400 hover:text-white' ?>">About</a>
          <a href="/contact" class="text-sm font-medium <?= urlIs('/contact') ? 'text-white' : 'text-gray-400 hover:text-white' ?>">Contact</a>
          <a href="/notes" class="text-sm font-medium <?= urlIs('/notes') ? 'text-white' : 'text-gray-400 hover:text-white' ?>">Notes</a>
        </div>
      </div>

      <div class="flex items-center gap-4">
        <button type="button" class="text-gray-400 hover:text-white">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 0 0-4-5.7V5a2 2 0 1 0-4 0v.3A6 6 0 0 0 6 11v3.2a2 2 0 0 1-.6 1.4L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>

        <!-- Toggled by the script in partials/mobile-menu.php -->
        <div class="relative">
          <button id="profile-menu-button" type="button" class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-sm font-medium text-white">
            U
          </button>
          <div id="profile-menu" class="hidden absolute right-0 mt-2 w-40 rounded-md bg-gray-800 py-1 shadow-lg ring-1 ring-white/10">
            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5">Your profile</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5">Sign out</a>
          </div>
        </div>

        <!-- Toggled by the script in partials/mobile-menu.php -->
        <button id="mobile-menu-button" type="button" class="sm:hidden text-gray-400 hover:text-white">
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Slide-down panel for small screens, hidden until the button above toggles it. -->
  <div id="mobile-menu-panel" class="hidden sm:hidden border-t border-white/10 px-4 py-3 space-y-1">
    <a href="/" class="block text-sm font-medium <?= urlIs('/') ? 'text-white' : 'text-gray-400 hover:text-white' ?>">Home</a>
    <a href="/about" class="block text-sm font-medium <?= urlIs('/about') ? 'text-white' : 'text-gray-400 hover:text-white' ?>">About</a>
    <a href="/contact" class="block text-sm font-medium <?= urlIs('/contact') ? 'text-white' : 'text-gray-400 hover:text-white' ?>">Contact</a>
    <a href="/notes" class="block text-sm font-medium <?= urlIs('/notes') ? 'text-white' : 'text-gray-400 hover:text-white' ?>">Notes</a>
  </div>
</nav>

<div>
