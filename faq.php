<section class="max-w-4xl mx-auto px-6 py-12">
  <h2 class="text-3xl font-bold text-center mb-10 text-gray-900 dark:text-gray-100 eyecare:text-[#586e75]">
    Frequently Asked Questions
  </h2>
  <div class="space-y-4">
    <!-- FAQ Item 1 -->
    <div class="border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm">
      <button aria-expanded="false" class="w-full flex justify-between items-center px-6 py-4 bg-gray-100 dark:bg-gray-800 eyecare:bg-[#f6f1e7] focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
        <span class="font-semibold text-gray-900 dark:text-gray-100 eyecare:text-[#586e75] text-left">How do I watch a movie?</span>
        <svg class="w-6 h-6 text-gray-700 dark:text-gray-300 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div class="px-6 overflow-hidden max-h-0 transition-max-height duration-500 bg-white dark:bg-[#1f1f1f] eyecare:bg-[#fef9e7] text-gray-700 dark:text-gray-300 eyecare:text-[#586e75]">
        <p class="py-4">
          Simply browse or search for your movie, then click "Watch Now" to start streaming.
        </p>
      </div>
    </div>

    <!-- FAQ Item 2 -->
    <div class="border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm">
      <button aria-expanded="false" class="w-full flex justify-between items-center px-6 py-4 bg-gray-100 dark:bg-gray-800 eyecare:bg-[#f6f1e7] focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
        <span class="font-semibold text-gray-900 dark:text-gray-100 eyecare:text-[#586e75] text-left">Is it free to use?</span>
        <svg class="w-6 h-6 text-gray-700 dark:text-gray-300 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div class="px-6 overflow-hidden max-h-0 transition-max-height duration-500 bg-white dark:bg-[#1f1f1f] eyecare:bg-[#fef9e7] text-gray-700 dark:text-gray-300 eyecare:text-[#586e75]">
        <p class="py-4">
          Yes! Streaming movies on our platform is completely free.
        </p>
      </div>
    </div>

    <!-- FAQ Item 3 -->
    <div class="border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm">
      <button aria-expanded="false" class="w-full flex justify-between items-center px-6 py-4 bg-gray-100 dark:bg-gray-800 eyecare:bg-[#f6f1e7] focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
        <span class="font-semibold text-gray-900 dark:text-gray-100 eyecare:text-[#586e75] text-left">Can I watch on mobile?</span>
        <svg class="w-6 h-6 text-gray-700 dark:text-gray-300 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div class="px-6 overflow-hidden max-h-0 transition-max-height duration-500 bg-white dark:bg-[#1f1f1f] eyecare:bg-[#fef9e7] text-gray-700 dark:text-gray-300 eyecare:text-[#586e75]">
        <p class="py-4">
          Absolutely! Our site is fully responsive and works great on phones and tablets.
        </p>
      </div>
    </div>
  </div>
</section>

<script>
  const faqButtons = document.querySelectorAll('section button');

  faqButtons.forEach(button => {
    button.addEventListener('click', () => {
      const isExpanded = button.getAttribute('aria-expanded') === 'true';

      // Close all
      faqButtons.forEach(btn => {
        btn.setAttribute('aria-expanded', 'false');
        btn.querySelector('svg').style.transform = 'rotate(0deg)';
        btn.nextElementSibling.style.maxHeight = null;
      });

      // If not previously expanded, open this one
      if (!isExpanded) {
        button.setAttribute('aria-expanded', 'true');
        button.querySelector('svg').style.transform = 'rotate(180deg)';
        const content = button.nextElementSibling;
        content.style.maxHeight = content.scrollHeight + 'px';
      }
    });
  });

  // Optional: open first FAQ by default
  window.addEventListener('load', () => {
    if(faqButtons.length) {
      faqButtons[0].click();
    }
  });
</script>