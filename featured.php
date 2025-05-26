<!-- Trending Movies Section -->
<section class="relative w-full py-16 px-6 md:px-12 bg-white dark:bg-[#0D0D0D] eyecare:bg-[#fdf6e3] transition-colors duration-500">
  <div class="max-w-screen-xl mx-auto">
    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white eyecare:text-[#586e75] mb-10 text-center">
      Trending Now on <span class="text-red-600 dark:text-[#FF6B00]">MovieMeld</span>
    </h2>

    <!-- Movie Slider -->
    <div id="movie-slider" class="flex overflow-x-auto gap-6 pb-4 scroll-smooth snap-x snap-mandatory">
      <!-- JS will inject movie cards here -->
    </div>

    <!-- View All Button -->
    <div class="text-center mt-10">
      <a href="movies.php" class="inline-block bg-red-600 dark:bg-[#FF6B00] hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition-all duration-300">
        View Full Movies List
      </a>
    </div>
  </div>
</section>
<!-- Script to Fetch Movies -->
<script>
  const movieSlider = document.getElementById('movie-slider');

  async function fetchTrendingMovies() {
    const apiKey = 'c1d5147f376f0b22cfc5166221d21c3b';
    const res = await fetch(`https://api.themoviedb.org/3/trending/movie/day?api_key=${apiKey}`);
    const data = await res.json();

    movieSlider.innerHTML = ''; // Clear old content

    data.results.slice(0, 10).forEach(movie => {
      const movieCard = document.createElement('a');
      movieCard.href = `movie.php?id=${movie.id}`;
      movieCard.className = `
        snap-start min-w-[250px] max-w-[250px] rounded-xl overflow-hidden bg-gray-100
        dark:bg-[#1c1c1c] eyecare:bg-[#fff8dc] shadow-md hover:shadow-xl transition-all duration-300
        flex-shrink-0 hover:scale-105
      `;

      movieCard.innerHTML = `
        <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}" alt="${movie.title}" class="w-full h-72 object-cover">
        <div class="p-4">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white eyecare:text-[#586e75] mb-2" id="loadin">
            ${movie.title}
          </h3>
          <p class="text-sm text-gray-600 dark:text-gray-300 eyecare:text-[#657b83] mb-2">
            ${movie.release_date}
          </p>
          <div class="flex items-center gap-2 text-yellow-500">
            <i class="fas fa-star"></i>
            <span class="text-sm text-gray-800 dark:text-white eyecare:text-[#586e75]">
              ${movie.vote_average.toFixed(1)} / 10
            </span>
          </div>
        </div>
      `;

      movieSlider.appendChild(movieCard);
    });
  }

  fetchTrendingMovies();
</script>
<style>
  /* Hide scrollbar but allow scrolling */
  .scrollbar-hide::-webkit-scrollbar {
    display: none;
  }
  .scrollbar-hide {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
  }
</style>