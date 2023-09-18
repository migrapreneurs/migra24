document.addEventListener('DOMContentLoaded', function () {
  const cardListContainer = document.querySelector('.card-list-container');
  const cardList = document.querySelector('.card-list');
  let isDragging = false;
  let startPositionX = 0;
  let currentTranslateX = 0;
  let lastTranslateX = 0;

  document.addEventListener('mousedown', (e) => {
    if (e.target.closest('.card-list-container')) {
      isDragging = true;
      startPositionX = e.clientX;
      cardList.style.transition = 'none';
    }
  });

  document.addEventListener('mousemove', (e) => {
    if (isDragging) {
      const deltaX = e.clientX - startPositionX;
      currentTranslateX = lastTranslateX + deltaX;
      cardList.style.transform = `translateX(${currentTranslateX}px)`;
    }
  });

  document.addEventListener('mouseup', () => {
    if (isDragging) {
      isDragging = false;
      cardList.style.transition = 'transform 0.3s ease-in-out';

      // Simulate deceleration
      const momentum = 0.2;
      currentTranslateX += momentum * (currentTranslateX - lastTranslateX);

      // Ensure the list stays within bounds
      const cardListWidth = cardList.offsetWidth;
      const containerWidth = cardListContainer.offsetWidth;
      const maxTranslateX = containerWidth - cardListWidth;
      currentTranslateX = Math.max(maxTranslateX, Math.min(0, currentTranslateX));

      cardList.style.transform = `translateX(${currentTranslateX}px)`;
      lastTranslateX = currentTranslateX;
    }
  });

  document.addEventListener('mouseleave', () => {
    if (isDragging) {
      document.dispatchEvent(new MouseEvent('mouseup'));
    }
  });

  // Auto-scroll the card list
  const scrollSpeed = 0.5; // Adjust scroll speed
  function autoScroll() {
    if (!isDragging) {
      currentTranslateX -= scrollSpeed;
      cardList.style.transform = `translateX(${currentTranslateX}px)`;
      lastTranslateX = currentTranslateX;

      // Reset the position when reaching the end
      const cardListWidth = cardList.offsetWidth;
      const containerWidth = cardListContainer.offsetWidth;
      if (currentTranslateX <= containerWidth - cardListWidth) {
        currentTranslateX = 0;
      }
    }

    requestAnimationFrame(autoScroll);
  }

  requestAnimationFrame(autoScroll);

  // Add event listeners and interactive behavior here
});
