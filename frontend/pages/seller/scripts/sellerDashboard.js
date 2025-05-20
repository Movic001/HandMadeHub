document.addEventListener("DOMContentLoaded", function () {
  // Elements
  const sidebar = document.getElementById("sidebar");
  const mainContent = document.getElementById("mainContent");
  const toggleSidebar = document.getElementById("toggleSidebar");
  const mobileToggle = document.getElementById("mobileToggle");
  const overlay = document.getElementById("overlay");
  const menuLinks = document.querySelectorAll(".menu-link");
  const logoutBtn = document.getElementById("logoutBtn");
  const actionCards = document.querySelectorAll(".action-card");

  // Toggle sidebar (desktop)
  toggleSidebar.addEventListener("click", function () {
    sidebar.classList.toggle("collapsed");
    mainContent.classList.toggle("expanded");

    // Change icon
    const icon = toggleSidebar.querySelector("i");
    if (sidebar.classList.contains("collapsed")) {
      icon.classList.remove("fa-chevron-left");
      icon.classList.add("fa-chevron-right");
    } else {
      icon.classList.remove("fa-chevron-right");
      icon.classList.add("fa-chevron-left");
    }
  });

  // Toggle sidebar (mobile)
  mobileToggle.addEventListener("click", function () {
    sidebar.classList.toggle("mobile-visible");
    overlay.classList.toggle("active");
  });

  // Close sidebar when clicking overlay
  overlay.addEventListener("click", function () {
    sidebar.classList.remove("mobile-visible");
    overlay.classList.remove("active");
  });

  // Navigation
  menuLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();

      // Remove active class from all links
      menuLinks.forEach((item) => item.classList.remove("active"));

      // Add active class to clicked link
      this.classList.add("active");

      // Get section to show
      const sectionId = this.getAttribute("data-section");

      // Hide all sections
      document.querySelectorAll(".content-section").forEach((section) => {
        section.classList.remove("active");
      });

      // Show selected section
      document.getElementById(sectionId).classList.add("active");

      // Close mobile sidebar
      if (window.innerWidth < 768) {
        sidebar.classList.remove("mobile-visible");
        overlay.classList.remove("active");
      }
    });
  });

  // Quick action cards
  actionCards.forEach((card) => {
    card.addEventListener("click", function () {
      const sectionId = this.getAttribute("data-section");

      // Trigger click on corresponding menu link
      document.querySelector(`.menu-link[data-section="${sectionId}"]`).click();
    });
  });

  // Logout button
  logoutBtn.addEventListener("click", function () {
    // Simulate logout (in a real app, this would redirect to logout endpoint)
    alert("Logging out...");
    window.location.href = "login.html";
  });

  // Responsive adjustments
  function handleResize() {
    if (window.innerWidth < 768) {
      sidebar.classList.remove("collapsed");
      sidebar.classList.remove("expanded");
      mainContent.classList.remove("expanded");
      mainContent.classList.remove("pushed");
      mobileToggle.style.display = "flex";
    } else {
      mobileToggle.style.display = "none";
      sidebar.classList.remove("mobile-visible");
      overlay.classList.remove("active");
    }
  }

  // Initial call and event listener for resize
  handleResize();
  window.addEventListener("resize", handleResize);
});
