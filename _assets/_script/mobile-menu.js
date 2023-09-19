document.addEventListener("DOMContentLoaded", function () {
  const iconContainer = document.querySelector(".icon-container");
  const mobileMenu = document.querySelector(".mobile-menu");

  mobileMenu.classList.toggle("hidden");


  // Toggle the icons on icon container click
  iconContainer.addEventListener("click", function () {
    const hamburgerIcon = document.querySelector(".hamburger-icon");
    const closeIcon = document.querySelector(".close-icon");

    hamburgerIcon.classList.toggle("hidden");
    closeIcon.classList.toggle("hidden");
    mobileMenu.classList.toggle("hidden");

  });

  // Add click event listeners to mobile menu links (directly targeting the <a> elements)
  const mobileLinks = document.querySelectorAll(".mobile-menu li a");

  mobileLinks.forEach(function (link) {
    link.addEventListener("click", function () {
      console.log("Link clicked!"); // Add this console.log statement
      mobileMenu.classList.toggle("hidden");
    });
  });
});
