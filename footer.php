<footer class="bg-gray-900 text-gray-300 py-12 px-6 md:px-16">
  <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10">
    <!-- About MovieMeld -->
    <div>
      <h3 class="text-2xl font-bold mb-4 text-white" id="loadin">MovieMeld</h3>
      <p class="text-sm mb-6 leading-relaxed">
        Discover the latest and greatest movies, reviews, trailers, and exclusive content. Join MovieMeld to connect with fellow movie lovers!
      </p>
      <div class="flex space-x-5 text-gray-400">
        <a href="#" aria-label="Facebook" class="hover:text-blue-600 transition">
          <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M22 12c0-5.522-4.477-10-10-10S2 6.478 2 12c0 4.991 3.657 9.128 8.438 9.877v-6.987h-2.54v-2.89h2.54v-2.207c0-2.507 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.772-1.63 1.562v1.88h2.773l-.443 2.89h-2.33v6.988C18.343 21.127 22 16.99 22 12z"/></svg>
        </a>
        <a href="#" aria-label="Twitter" class="hover:text-sky-400 transition">
          <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.5.58-2.28.69a3.97 3.97 0 001.75-2.19 7.9 7.9 0 01-2.52.96 3.94 3.94 0 00-6.7 3.59 11.17 11.17 0 01-8.11-4.1 3.93 3.93 0 001.22 5.25 3.9 3.9 0 01-1.78-.5v.05a3.93 3.93 0 003.16 3.86 3.92 3.92 0 01-1.77.07 3.94 3.94 0 003.68 2.72 7.9 7.9 0 01-4.88 1.68c-.32 0-.63-.02-.94-.06a11.12 11.12 0 006.03 1.76c7.23 0 11.2-6 11.2-11.19 0-.17-.01-.35-.02-.52A7.94 7.94 0 0022.46 6z"/></svg>
        </a>
        <a href="#" aria-label="Instagram" class="hover:text-pink-600 transition">
          <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm8.5 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm-4.5 2a5 5 0 100 10 5 5 0 000-10zm0 8a3 3 0 110-6 3 3 0 010 6z"/></svg>
        </a>
      </div>
    </div>

    <!-- Movie Categories -->
    <div>
      <h4 class="text-xl font-semibold mb-4 text-white" id="loadin">Categories</h4>
      <ul class="space-y-3 text-sm">
        <li><a href="#" class="hover:text-red-500 transition">Action</a></li>
        <li><a href="#" class="hover:text-red-500 transition">Drama</a></li>
        <li><a href="#" class="hover:text-red-500 transition">Comedy</a></li>
        <li><a href="#" class="hover:text-red-500 transition">Horror</a></li>
        <li><a href="#" class="hover:text-red-500 transition">Sci-Fi</a></li>
        <li><a href="#" class="hover:text-red-500 transition">Romance</a></li>
      </ul>
    </div>

    <!-- Help & Support -->
    <div>
      <h4 class="text-xl font-semibold mb-4 text-white" id="loadin">Help & Support</h4>
      <ul class="space-y-3 text-sm">
        <li><a href="#" class="hover:text-red-500 transition">FAQ</a></li>
        <li><a href="#" class="hover:text-red-500 transition">Account Settings</a></li>
        <li><a href="#" class="hover:text-red-500 transition">Privacy Policy</a></li>
        <li><a href="#" class="hover:text-red-500 transition">Terms of Use</a></li>
        <li><a href="#" class="hover:text-red-500 transition">Contact Support</a></li>
      </ul>
    </div>

    <!-- Newsletter -->
    <div>
      <h4 class="text-xl font-semibold mb-4 text-white" id="loadin">Newsletter</h4>
      <p class="text-sm mb-4 leading-relaxed">
        Subscribe to get the latest movie updates and exclusive offers.
      </p>
      <form action="#" method="POST" class="flex flex-col space-y-3">
        <input 
          type="email" 
          name="email" 
          placeholder="Your email address" 
          required 
          class="px-4 py-2 rounded border border-gray-700 bg-gray-800 text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-600 transition"
        />
        <button 
          type="submit" 
          class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded transition"
        >
          Subscribe
        </button>
      </form>
    </div>
  </div>

  <div class="border-t border-gray-700 mt-12 pt-6 text-center text-xs text-gray-500 select-none">
    &copy; <?php echo date('Y'); ?> MovieMeld. All rights reserved.
  </div>
</footer>
<script>
  //clone this script from my portfokio page just to give a typewriter effect on scroll
document.addEventListener("DOMContentLoaded", () => {
  const elements = document.querySelectorAll('#loadin');

  elements.forEach(el => {
    const originalText = el.textContent.trim();
    el.textContent = "";

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          el.classList.add("visible");
          let i = 0;

          function typeLetter() {
            if (i < originalText.length) {
              el.textContent += originalText[i];
              i++;
              setTimeout(typeLetter, 35); // speed per letter
            }
          }

          typeLetter();
          obs.unobserve(el); // Only run once per element
        }
      });
    });

    observer.observe(el);
  });
});
</script>