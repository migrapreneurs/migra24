document.addEventListener("DOMContentLoaded", function () {
  const iconContainer = document.querySelector(".icon-container");
  const mobileMenu = document.querySelector(".mobile-menu");

  mobileMenu.classList.toggle("hidden");
  
  // Toggle the icons on icon container click
  iconContainer.addEventListener("click", function () {
    console.log("toggle");
    const hamburgerIcon = document.querySelector(".hamburger-icon");
    const closeIcon = document.querySelector(".close-icon");

    hamburgerIcon.classList.toggle("hidden");
    closeIcon.classList.toggle("hidden");
    mobileMenu.classList.toggle("hidden");
  });
});
