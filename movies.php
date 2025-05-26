<?php include 'navbar.php'; 
echo '<div style="height:50px"></div>';
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Watch Trending Movies & Discover Genres | MovieMeld</title>
<meta name="description" content="Explore the latest and trending movies with MovieMeld. Dive into your favorite genres, trailers, and fresh movie releases — all in one place." />
<meta name="keywords" content="MovieMeld, movies, latest movies, trending films, trailers, discover genres, loml, preciousadedokun, HD streaming" />
<meta name="author" content="MovieMeld" />
<link rel="canonical" href="https://lomlreal.preciousadedokun.com.ng/movies.php" />

<meta property="og:type" content="website" />
<meta property="og:url" content="https://lomlreal.preciousadedokun.com.ng/movies.php" />
<meta property="og:title" content="Watch Trending Movies & Discover Genres | MovieMeld" />
<meta property="og:description" content="Find trending movies and top genres instantly. Watch trailers and browse films only on MovieMeld!" />
<meta property="og:image" content="https://lomlreal.preciousadedokun.com.ng/logo.jpg" />

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="https://lomlreal.preciousadedokun.com.ng/movies.php" />
<meta name="twitter:title" content="Explore Trending Films with MovieMeld" />
<meta name="twitter:description" content="MovieMeld helps you find trending movies, explore genres, and stream trailers in one sleek experience." />
<meta name="twitter:image" content="https://lomlreal.preciousadedokun.com.ng/logo.jpg" />

<!-- Favicon -->
<link rel="icon" href="https://lomlreal.preciousadedokun.com.ng/logo.jpg" type="image/jpeg" />

<!-- Robots & Crawlers -->
<meta name="robots" content="index, follow" />
<meta name="theme-color" content="#0d0d0d" />
  <link href="bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="./font-awesome/css/all.css" />
  <script src="tailwind.js"></script>
  <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Movie",
  "name": "MovieMeld - Movies Page",
  "description": "Explore trending movies, genres, and trailers on MovieMeld. Watch what matters most to you.",
  "url": "https://lomlreal.preciousadedokun.com.ng/movies.php",
  "publisher": {
    "@type": "Organization",
    "name": "MovieMeld",
    "logo": {
      "@type": "ImageObject",
      "url": "https://lomlreal.preciousadedokun.com.ng/logo.jpg"
    }
  }
  "publisher": {
    "@type": "Person",
    "name": "Precious Adedokun",
    "logo": {
      "@type": "ImageObject",
      "url": "https://preciousadedokun.com.ng/images/ap.jpg"
    }
  }
}
</script>
  <script>
    // Tailwind dark mode config
    tailwind.config = {
      darkMode: 'class',
      theme: { extend: {} },
    };
  </script>
  <style>
    .loader {
      border: 4px solid #f3f3f3;
      border-top: 4px solid #8A2BE2;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      animation: spin 1s linear infinite;
      margin: auto;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body
  class="bg-white text-black dark:bg-[#0D0D0D] dark:text-white eyecare:bg-[#fff8dc] eyecare:text-[#586e75] transition-colors duration-300"
>
  <div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">All Movies</h1>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap gap-4 mb-6">
      <select
        id="genre"
        class="bg-gray-200 dark:bg-gray-800 eyecare:bg-[#eee8d5] text-black dark:text-white eyecare:text-[#586e75] px-4 py-2 rounded"
      >
        <option value="">Genre</option>
      </select>
      <select
        id="rating"
        class="bg-gray-200 dark:bg-gray-800 eyecare:bg-[#eee8d5] text-black dark:text-white eyecare:text-[#586e75] px-4 py-2 rounded"
      >
        <option value="">Rating</option>
        <option value="8">8+</option>
        <option value="6">6+</option>
        <option value="4">4+</option>
      </select>
      <input
        type="date"
        id="releaseDate"
        class="bg-gray-200 dark:bg-gray-800 eyecare:bg-[#eee8d5] text-black dark:text-white eyecare:text-[#586e75] px-4 py-2 rounded"
        placeholder="Select Release Date"
      />
    </div>

    <div id="movie-list" class="grid grid-cols-2 md:grid-cols-4 gap-6"></div>
    <div id="loader" class="loader mt-8 hidden"></div>
  </div>

  <script>
    (function () {
      const apiKey = 'your_api_key';
      let page = 1;
      let loading = false;
      const movieList = document.getElementById('movie-list');
      const loader = document.getElementById('loader');

      // Fetch Genres once
      async function fetchGenres() {
        try {
          const res = await fetch(
            `https://api.themoviedb.org/3/genre/movie/list?api_key=${apiKey}`
          );
          const data = await res.json();
          const genreSelect = document.getElementById('genre');
          data.genres.forEach((genre) => {
            const option = document.createElement('option');
            option.value = genre.id;
            option.textContent = genre.name;
            genreSelect.appendChild(option);
          });
        } catch (err) {
          console.error('Failed to fetch genres:', err);
        }
      }

      // Load movies with filters & pagination
      async function loadMovies(reset = false) {
        if (loading) return;
        loading = true;
        loader.classList.remove('hidden');

        if (reset) {
          page = 1;
          movieList.innerHTML = '';
        }

        const genre = document.getElementById('genre').value;
        const rating = document.getElementById('rating').value;
        const date = document.getElementById('releaseDate').value;

        let url = `https://api.themoviedb.org/3/discover/movie?api_key=${apiKey}&page=${page}`;

        if (genre) url += `&with_genres=${genre}`;
        if (rating) url += `&vote_average.gte=${rating}`;
        if (date) url += `&primary_release_date.gte=${date}`;

        try {
          const res = await fetch(url);
          if (!res.ok) throw new Error('Network response was not ok');
          const data = await res.json();

          data.results.forEach((movie) => {
            const card = document.createElement('a');
            card.href = `movie.php?id=${movie.id}`;
            card.className =
              'bg-gray-100 dark:bg-[#1c1c1c] eyecare:bg-[#fff8dc] rounded-xl overflow-hidden shadow hover:shadow-lg transition-transform hover:scale-105';
            card.innerHTML = `
              <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}" class="w-full h-64 object-cover" alt="${movie.title}">
              <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white eyecare:text-[#586e75] truncate">${movie.title}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 eyecare:text-[#657b83] mb-1">${movie.release_date || 'N/A'}</p>
                <div class="flex items-center text-yellow-500 gap-1">
                  <i class="fas fa-star"></i>
                  <span class="text-sm text-gray-800 dark:text-white eyecare:text-[#586e75]">${movie.vote_average.toFixed(1)}</span>
                </div>
              </div>`;
            movieList.appendChild(card);
          });

          page++;
        } catch (err) {
          console.error('Failed to load movies:', err);
        } finally {
          loader.classList.add('hidden');
          loading = false;
        }
      }

      // Infinite scroll event
      window.addEventListener('scroll', () => {
        if (
          window.innerHeight + window.scrollY >=
          document.body.offsetHeight - 100
        ) {
          loadMovies();
        }
      });

      // Filters change events
      ['genre', 'rating', 'releaseDate'].forEach((id) => {
        document.getElementById(id).addEventListener('change', () => {
          loadMovies(true);
        });
      });

      // Initialize on page load
      window.addEventListener('DOMContentLoaded', () => {
        fetchGenres();
        loadMovies();
      });
    })();
  </script>
</body>
</html>
<?php
include 'footer.php';
?>