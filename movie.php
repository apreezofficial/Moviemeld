<?php
$movieId = $_GET['id'] ?? '1098006'; // fallback ID
$apiKey = 'c1d5147f376f0b22cfc5166221d21c3b'; // your TMDB API key

$data = null;
$videoKey = null;
include 'navbar.php';
// Function to make cURL requests
function fetchFromTMDB($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable only for dev use
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Fetch movie details
$movieUrl = "https://api.themoviedb.org/3/movie/{$movieId}?api_key={$apiKey}&language=en-US";
$data = fetchFromTMDB($movieUrl);

// Fetch video data
$videoUrl = "https://api.themoviedb.org/3/movie/{$movieId}/videos?api_key={$apiKey}&language=en-US";
$videoData = fetchFromTMDB($videoUrl);

// Extract YouTube trailer key
if (!empty($videoData['results'])) {
    foreach ($videoData['results'] as $video) {
        if ($video['site'] === 'YouTube' && $video['type'] === 'Trailer') {
            $videoKey = $video['key'];
            break;
        }
    }
}
?>
<!DOCTYPE html>
<head>

<meta charset="UTF-8" />
<title><?php echo htmlspecialchars($data['title'] ?? 'Movie Details'); ?> | MovieMeld</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="<?php echo htmlspecialchars($data['overview'] ?? 'Explore full details of this movie on MovieMeld.'); ?>" />
<meta name="keywords" content="<?php echo htmlspecialchars($data['title'] ?? 'movie'); ?>, MovieMeld, latest movies, trending, trailers" />
<meta name="author" content="MovieMeld" />

<!-- Canonical Link -->
<link rel="canonical" href="https://lomlreal.preciousadedokun.com.ng/movies.php?id=<?php echo urlencode($data['id']); ?>" />

<!-- Open Graph Meta Tags -->
<meta property="og:type" content="video.movie" />
<meta property="og:url" content="https://lomlreal.preciousadedokun.com.ng/movies.php?id=<?php echo urlencode($data['id']); ?>" />
<meta property="og:title" content="<?php echo htmlspecialchars($data['title'] ?? 'Movie Details'); ?> | MovieMeld" />
<meta property="og:description" content="<?php echo htmlspecialchars($data['overview'] ?? 'Watch this movie on MovieMeld.'); ?>" />
<meta property="og:image" content="https://image.tmdb.org/t/p/w780<?php echo $data['backdrop_path'] ?? $data['poster_path'] ?? '/logo.jpg'; ?>" />

<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="https://lomlreal.preciousadedokun.com.ng/movies.php?id=<?php echo urlencode($data['id']); ?>" />
<meta name="twitter:title" content="<?php echo htmlspecialchars($data['title'] ?? 'Movie Details'); ?> | MovieMeld" />
<meta name="twitter:description" content="<?php echo htmlspecialchars($data['overview'] ?? 'Find out more about this movie on MovieMeld.'); ?>" />
<meta name="twitter:image" content="https://image.tmdb.org/t/p/w780<?php echo $data['backdrop_path'] ?? $data['poster_path'] ?? '/logo.jpg'; ?>" />

<!-- Favicon -->
<link rel="icon" href="/logo.jpg" type="image/jpeg" />

<!-- Theme Color -->
<meta name="theme-color" content="#0d0d0d" />
  <style>
    body.eyecare {
      background-color: #fdf6e3;
      color: #586e75;
    }
  </style>
</head>


  <?php if ($data): ?>
    <div class="relative w-full h-[85vh] overflow-hidden">
      <img src="https://image.tmdb.org/t/p/original<?php echo $data['backdrop_path'] ?? $data['poster_path']; ?>" 
           alt="<?php echo $data['title']; ?>" 
           class="w-full h-full object-cover brightness-[.4]">
           
      <div class="absolute inset-0 flex flex-col justify-end md:justify-center px-6 md:px-20 pb-12 bg-gradient-to-t from-black via-black/50 to-transparent">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4"><?php echo $data['title']; ?></h1>
        <p class="mb-4 max-w-2xl text-sm md:text-base text-gray-200 dark:text-gray-300 eyecare:text-[#657b83]"><?php echo $data['overview']; ?></p>
        <div class="flex items-center gap-3 mb-2">
          <span class="text-yellow-400 text-xl font-bold"><?php echo number_format($data['vote_average'], 1); ?>/10</span>
          <span class="text-gray-400 dark:text-gray-300 eyecare:text-[#586e75]">| <?php echo $data['release_date']; ?></span>
        </div>
        <div class="flex gap-4 mt-4">
          <a href="index.php" class="bg-red-600 hover:bg-red-700 text-white py-2 px-6 rounded-full transition">
            Back to Home
          </a>
          <button onclick="showPlayer()" class="bg-green-600 hover:bg-green-700 text-white py-2 px-6 rounded-full transition">
            Watch Now
          </button>
        </div>
      </div>
    </div>

    <!-- Video Popup -->
    <div id="playerPopup" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden z-50 flex items-center justify-center">
      <div class="bg-black rounded-xl overflow-hidden shadow-2xl relative w-[90%] max-w-3xl aspect-video">
<?php if ($videoKey): ?>
<iframe src="https://www.youtube.com/embed/<?php echo $videoKey; ?>" 
        frameborder="0" allowfullscreen 
        class="w-full h-full"></iframe>
<?php else: ?>
<div class="text-white p-4">Trailer not available.</div>
<?php endif; ?>
        <button onclick="hidePlayer()" class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded-full">
          Close
        </button>
      </div>
    </div>
  <?php else: ?>
    <div class="flex items-center justify-center h-screen">
      <p class="text-red-500 text-xl font-bold">Movie not found or failed to load.</p>
    </div>
  <?php endif; ?>

  <!-- JS for Theme + Player -->
  <script>
  
    function showPlayer() {
      document.getElementById('playerPopup').classList.remove('hidden');
    }

    function hidePlayer() {
      document.getElementById('playerPopup').classList.add('hidden');
    }
  </script>

