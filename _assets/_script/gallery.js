document.addEventListener("DOMContentLoaded", function () {
  // JavaScript for bullet navigation with smooth sliding and friction
  const gallery = document.querySelector('.gallery');
  const slides = document.querySelectorAll('.gallery-slide');
  const bulletsContainer = document.querySelector('.gallery-bullets');

  let currentIndex = 0;
  let isScrolling = false;
  let isDesktop = window.innerWidth > 767; // Check if the viewport is desktop-sized

  // Create bullet indicators
  slides.forEach((slide, index) => {
    const bullet = document.createElement('div');
    bullet.classList.add('gallery-bullet');
    bullet.addEventListener('click', () => goToSlide(index));
    bulletsContainer.appendChild(bullet);
  });

  // Set the first bullet as active
  bulletsContainer.children[currentIndex].classList.add('active');

  // Function to go to a specific slide
  function goToSlide(index) {
    if (!isScrolling && index >= 0 && index < slides.length) {
      isScrolling = true;
      const slideWidth = slides[0].offsetWidth; // Get the width of a single slide
      const scrollAmount = index * slideWidth; // Calculate the scroll amount
      gallery.scrollTo({
        left: scrollAmount,
        behavior: 'smooth',
      });
      bulletsContainer.children[currentIndex].classList.remove('active');
      currentIndex = index;
      bulletsContainer.children[currentIndex].classList.add('active');

      // Listen for the scroll animation to end
      setTimeout(() => {
        isScrolling = false;
      }, 500); // Adjust the time as needed for your desired friction effect
    }
  }


  // Optional: Auto-scroll to the next slide every 5 seconds (for desktop)
  if (isDesktop) {
    let intervalId = null;
    let isAutoScrolling = true; // Add a flag to control auto-scrolling

    const startAutoScroll = () => {
      intervalId = setInterval(() => {
        if (currentIndex < slides.length - 1 && isAutoScrolling) {
          goToSlide(currentIndex + 1);
        } else {
          goToSlide(0);
        }
      }, 5000);
    };

    const stopAutoScroll = () => {
      clearInterval(intervalId);
    };

    // Add a flag to check if the mouse is currently over the gallery
    let isMouseOverGallery = false;

    gallery.addEventListener('mouseover', () => {
      isAutoScrolling = true; // Pause auto-scrolling
      stopAutoScroll();
      isMouseOverGallery = true; // Set the flag to true when the mouse is over the gallery
    });

    gallery.addEventListener('mouseout', () => {
      isMouseOverGallery = false; // Set the flag to false when the mouse leaves the gallery
      startAutoScroll();
    });

    // Prevent the default action of scrolling down on desktop when auto-scrolling is active
    window.addEventListener('wheel', (e) => {
      if (isAutoScrolling && !isMouseOverGallery) {
        e.preventDefault();
      }
    });

    startAutoScroll();
  }


  // Mobile swipe control
  let touchStartX = 0;
  let touchEndX = 0;

  gallery.addEventListener('touchstart', (e) => {
    if (!isDesktop) {
      touchStartX = e.touches[0].clientX;
    }
  });

  gallery.addEventListener('touchmove', (e) => {
    if (!isDesktop) {
      e.preventDefault(); // Prevent page scroll
    }
  });

  gallery.addEventListener('touchend', (e) => {
    if (!isDesktop) {
      touchEndX = e.changedTouches[0].clientX;
      const swipeThreshold = 50;

      if (touchStartX - touchEndX > swipeThreshold) {
        // Swiped left, go to the next slide
        if (currentIndex < slides.length - 1) {
          goToSlide(currentIndex + 1);
        }
      } else if (touchEndX - touchStartX > swipeThreshold) {
        // Swiped right, go to the previous slide
        if (currentIndex > 0) {
          goToSlide(currentIndex - 1);
        }
      }
    }
  });
});
