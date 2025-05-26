<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth" data-theme="dark">
<head>
    <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="./font-awesome/css/all.css">
    <script src="tailwind.js"></script>
    <script>
      // Tailwind dark mode config
      tailwind.config = {
        darkMode: 'class',
        theme: {
          extend: {},
        }
      }
    </script>
</head>
<body class="bg-white text-black dark:bg-gray-900 dark:text-white eyecare:bg-[#fdf6e3] eyecare:text-[#586e75] transition duration-300">
<nav
  class="bg-gray-50 dark:bg-gray-900 shadow-md transition-colors duration-300 fixed w-full z-50"
>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      <!-- Logo -->
      <div class="flex items-center space-x-4">
        <a
          href="index.php"
          class="text-2xl font-extrabold text-red-600 tracking-wide"
          >Moviemeld</a
        >
      </div>

      <!-- Search -->
      <div
        id="search-container"
        class="hidden md:flex flex-1 mx-6 relative items-center"
      >
        <input
          type="search"
          placeholder="Search movies, genres..."
          class="w-full rounded-md px-3 py-2 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-600 transition-colors duration-300"
          aria-label="Search movies, genres"
        />
        <button
          id="search-clear"
          class="absolute right-2 text-gray-400 hover:text-red-600 transition hidden"
          aria-label="Clear search"
          title="Clear search"
        >
          <i class="fas fa-times"></i>
        </button>
      </div>

      <!-- Mobile search icon -->
      <button
        id="mobile-search-toggle"
        class="md:hidden text-red-600 p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-600 transition"
        aria-label="Toggle search"
        title="Toggle search"
      >
        <i class="fas fa-search fa-lg"></i>
      </button>

      <!-- User controls -->
      <div class="flex items-center space-x-4">
        <!-- Theme Toggle Dropdown -->
        <div class="relative">
          <button
            id="theme-toggle"
            aria-label="Toggle Theme"
            class="p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-600 transition-colors duration-300 flex items-center space-x-1 select-none"
          >
            <span id="theme-icon" class="text-red-600 text-lg">
              <i class="fas fa-sun"></i>
            </span>
            <span
              id="theme-label"
              class="text-gray-700 dark:text-gray-300 select-none hidden sm:inline"
            >
              Light
            </span>
            <i
              class="fas fa-chevron-down text-gray-600 dark:text-gray-400 ml-1 hidden sm:inline"
            ></i>
          </button>

          <!-- Dropdown -->
          <div
            id="theme-menu"
            class="hidden absolute right-0 mt-2 w-32 bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50"
          >
            <button
              data-theme="light"
              class="w-full text-left px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-red-600 hover:text-white transition"
            >
              <i class="fas fa-sun mr-2"></i> Light
            </button>
            <button
              data-theme="dark"
              class="w-full text-left px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-red-600 hover:text-white transition"
            >
              <i class="fas fa-moon mr-2"></i> Dark
            </button>
            <button
              data-theme="eyecare"
              class="w-full text-left px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-red-600 hover:text-white transition"
            >
              <i class="fas fa-eye mr-2"></i> Eyecare
            </button>
            <button
              data-theme="system"
              class="w-full text-left px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-red-600 hover:text-white transition"
            >
              <i class="fas fa-desktop mr-2"></i> System
            </button>
          </div>
        </div>

<?php if (isset($_SESSION['user'])): ?>
  <!-- Profile picture and dropdown -->
  <div class="relative group">
    <img
      src="<?= htmlspecialchars($_SESSION['user']['profile_pic'] ?? 'assets/img/default-profile.png') ?>"
      alt="Profile"
      class="h-10 w-10 rounded-full cursor-pointer border-2 border-red-600 object-cover shadow-md"
      title="<?= htmlspecialchars($_SESSION['user']['name'] ?? 'User') ?>"
    />
    <div
      class="absolute right-0 mt-2 w-44 bg-gray-50 dark:bg-gray-800 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity text-sm z-20 text-gray-900 dark:text-gray-100"
    >
      <p
        class="px-4 py-2 border-b border-gray-300 dark:border-gray-700 truncate"
        title="<?= htmlspecialchars($_SESSION['user']['name'] ?? 'User') ?>"
      >
        <?= htmlspecialchars($_SESSION['user']['name'] ?? 'User') ?>
      </p>
      <a
        href="logout.php"
        class="block px-4 py-2 hover:bg-red-600 hover:text-white rounded-b-md transition"
      >Logout</a>
    </div>
  </div>
<?php else: ?>
        <!-- Single Login/Signup Button -->
        <a
          href="login.php"
          class="px-4 py-2 rounded-md border border-red-600 text-red-600 hover:bg-red-600 hover:text-white transition flex items-center space-x-2"
        >
          <i class="fas fa-user-circle"></i>
          <span>Signin</span>
        </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
<!-- Loader -->
<div id="search-loader" class="absolute top-2 right-4 hidden">
  <i class="fas fa-spinner fa-spin text-red-500 text-xl animate-spin"></i>
</div>

<!-- Mobile Search Container -->
<div id="mobile-search-container"
  class="hidden px-4 pb-4 md:hidden bg-gray-50 dark:bg-gray-900 eyecare:bg-[#fdf6e3] transition duration-300 relative z-50">
  <input
    type="search"
    id="mobile-search-input"
    placeholder="Search movies, genres..."
    class="w-full rounded-lg px-4 py-2 bg-white dark:bg-gray-800 eyecare:bg-[#eee8d5] text-gray-900 dark:text-white eyecare:text-[#586e75] placeholder-gray-500 focus:outline-none focus:ring focus:ring-red-500 transition duration-300 shadow-sm"
    aria-label="Search movies"
    autocomplete="off"
  />
  <ul id="mobile-suggestions"
    class="absolute top-full left-0 w-full mt-2 bg-white dark:bg-[#121212] eyecare:bg-[#fff8dc] shadow-xl rounded-lg overflow-y-auto max-h-72 hidden border border-gray-200 dark:border-gray-700 eyecare:border-[#d8d8b8] z-50">
    <!-- Suggestions populate here -->
  </ul>
</div>

<!-- Font Awesome for loader -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
  const input = document.getElementById('mobile-search-input');
  const suggestionsBox = document.getElementById('mobile-suggestions');
  const loader = document.getElementById('search-loader');
  const apiKey = 'c1d5147f376f0b22cfc5166221d21c3b';
  let controller;
  let debounceTimer;

  input.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
      performSearch(input.value.trim());
    }, 200); // Adjust for speed
  });

  async function performSearch(query) {
    if (query.length < 1) {
      suggestionsBox.classList.add('hidden');
      suggestionsBox.innerHTML = '';
      return;
    }

    // Cancel previous request
    if (controller) controller.abort();
    controller = new AbortController();

    // Show loader
    loader.classList.remove('hidden');

    try {
      const res = await fetch(`https://api.themoviedb.org/3/search/movie?api_key=${apiKey}&query=${encodeURIComponent(query)}`, {
        signal: controller.signal
      });
      const data = await res.json();

      suggestionsBox.innerHTML = '';
      if (data.results.length > 0) {
        data.results.slice(0, 7).forEach(movie => {
          const poster = movie.poster_path
            ? `https://image.tmdb.org/t/p/w92${movie.poster_path}`
            : 'https://via.placeholder.com/50x75?text=?';

          const li = document.createElement('li');
          li.innerHTML = `
            <a href="movie.php?id=${movie.id}" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 eyecare:hover:bg-[#fef6d2] transition-colors duration-200">
              <img src="${poster}" alt="${movie.title}" class="w-10 h-14 object-cover rounded-md mr-4 shadow-sm" />
              <span class="text-sm text-gray-800 dark:text-white eyecare:text-[#586e75] font-medium">${movie.title}</span>
            </a>
          `;
          suggestionsBox.appendChild(li);
        });
        suggestionsBox.classList.remove('hidden');
      } else {
        suggestionsBox.classList.add('hidden');
      }
    } catch (err) {
      if (err.name !== 'AbortError') {
        console.error('Search error:', err);
      }
    } finally {
      loader.classList.add('hidden'); // Hide loader
    }
  }

  // Close suggestions if clicking outside
  document.addEventListener('click', (e) => {
    if (!input.contains(e.target) && !suggestionsBox.contains(e.target)) {
      suggestionsBox.classList.add('hidden');
    }
  });
</script>
</nav>

</body>
<script>
  // Theme toggle dropdown toggle
  const themeToggleBtn = document.getElementById('theme-toggle');
  const themeMenu = document.getElementById('theme-menu');
  const themeLabel = document.getElementById('theme-label');
  const themeIcon = document.getElementById('theme-icon');

  themeToggleBtn.addEventListener('click', () => {
    themeMenu.classList.toggle('hidden');
  });

  // Close dropdown if clicked outside
  window.addEventListener('click', (e) => {
    if (
      !themeToggleBtn.contains(e.target) &&
      !themeMenu.contains(e.target)
    ) {
      themeMenu.classList.add('hidden');
    }
  });

  // Apply theme
  function applyTheme(theme) {
    const html = document.documentElement;

    // Remove all custom theme classes first
    html.classList.remove('dark', 'eyecare');

    switch (theme) {
      case 'dark':
        html.classList.add('dark');
        themeIcon.innerHTML = '<i class="fas fa-moon"></i>';
        themeLabel.textContent = 'Dark';
        break;
      case 'eyecare':
        html.classList.add('eyecare');
        themeIcon.innerHTML = '<i class="fas fa-eye"></i>';
        themeLabel.textContent = 'Eyecare';
        break;
      case 'system':
        // Follow system preference
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
          html.classList.add('dark');
          themeIcon.innerHTML = '<i class="fas fa-moon"></i>';
          themeLabel.textContent = 'System (Dark)';
        } else {
          themeIcon.innerHTML = '<i class="fas fa-sun"></i>';
          themeLabel.textContent = 'System (Light)';
        }
        break;
      default:
        // light
        themeIcon.innerHTML = '<i class="fas fa-sun"></i>';
        themeLabel.textContent = 'Light';
        break;
    }

    localStorage.setItem('theme', theme);
  }

  // Load theme from localStorage or system default
  function loadTheme() {
    const savedTheme = localStorage.getItem('theme') || 'system';
    applyTheme(savedTheme);
  }

  // Theme menu buttons click
  document.querySelectorAll('#theme-menu button').forEach((btn) => {
    btn.addEventListener('click', () => {
      const selectedTheme = btn.getAttribute('data-theme');
      applyTheme(selectedTheme);
      themeMenu.classList.add('hidden');
    });
  });

  loadTheme();

  // Eyecare mode styles (add in JS for demo or add to your Tailwind config/custom CSS)
  const style = document.createElement('style');
  style.innerHTML = `
  .eyecare {
    background-color: #fdf6e3 !important;
    color: #586e75 !important;
  }

  .eyecare * {
    background-color: transparent !important;
    color: #586e75 !important;
  }

  .dark {
    background-color: #121212 !important;
    color: #f0f0f0 !important;
  }

  .dark a { color: #bb86fc; }

  .eyecare a { color: #2aa198; }

  .dark input, .dark textarea, .dark select,
  .eyecare input, .eyecare textarea, .eyecare select {
    background-color: #1e1e1e !important;
    color: #f0f0f0 !important;
    border-color: #555 !important;
  }

  .eyecare input, .eyecare textarea, .eyecare select {
    background-color: #fff8dc !important;
    color: #586e75 !important;
    border-color: #93a1a1 !important;
  }
`;
  document.head.appendChild(style);

  // Mobile search toggle
  const mobileSearchToggle = document.getElementById('mobile-search-toggle');
  const mobileSearchContainer = document.getElementById('mobile-search-container');

  mobileSearchToggle.addEventListener('click', () => {
    mobileSearchContainer.classList.toggle('hidden');
  });

  // Clear search button functionality (desktop)
  const searchInput = document.querySelector('#search-container input[type="search"]');
  const searchClearBtn = document.getElementById('search-clear');

  searchInput.addEventListener('input', () => {
    searchClearBtn.classList.toggle('hidden', searchInput.value.trim() === '');
  });

  searchClearBtn.addEventListener('click', () => {
    searchInput.value = '';
    searchClearBtn.classList.add('hidden');
    searchInput.focus();
  });
</script>
</html>