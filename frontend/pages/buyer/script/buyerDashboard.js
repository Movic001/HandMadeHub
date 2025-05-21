document.addEventListener("DOMContentLoaded", function () {
  // Tab Functionality
  const tabs = document.querySelectorAll(".tab");
  const tabContents = document.querySelectorAll(".tab-content");
  const navItems = document.querySelectorAll(".nav-item");

  function setActiveTab(tabId) {
    // Remove active class from all tabs and contents
    tabs.forEach((tab) => tab.classList.remove("active"));
    tabContents.forEach((content) => content.classList.remove("active"));
    navItems.forEach((item) => item.classList.remove("active"));

    // Add active class to selected tab and content
    const selectedTab = document.querySelector(`.tab[data-tab="${tabId}"]`);
    const selectedContent = document.getElementById(`${tabId}-content`);
    const selectedNavItem = document.querySelector(
      `.nav-item[data-tab="${tabId}"]`
    );

    if (selectedTab && selectedContent && selectedNavItem) {
      selectedTab.classList.add("active");
      selectedContent.classList.add("active");
      selectedNavItem.classList.add("active");
    }
  }

  // Add click event to tabs
  tabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      const tabId = this.getAttribute("data-tab");
      if (tabId) {
        setActiveTab(tabId);
      }
    });
  });

  // Add click event to sidebar nav items
  navItems.forEach((item) => {
    item.addEventListener("click", function () {
      const tabId = this.getAttribute("data-tab");
      if (tabId) {
        setActiveTab(tabId);

        // Close sidebar on mobile after clicking
        if (window.innerWidth <= 768) {
          sidebar.classList.remove("active");
        }
      }
    });
  });

  // Sidebar Toggle for Mobile
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.getElementById("sidebar");
  const mainContent = document.querySelector(".main-content");
  const footer = document.getElementById("footer");

  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener("click", function (e) {
      e.stopPropagation(); // Prevent document click from immediately closing
      sidebar.classList.toggle("active");

      // Update main content and footer margin when sidebar is toggled
      if (sidebar.classList.contains("active") && window.innerWidth <= 768) {
        mainContent.classList.add("expanded");
        if (footer) footer.classList.add("expanded");
      } else {
        mainContent.classList.remove("expanded");
        if (footer) footer.classList.remove("expanded");
      }
    });
  }

  // Handle window resize
  window.addEventListener("resize", function () {
    if (window.innerWidth > 768) {
      if (sidebar) sidebar.classList.remove("active");
      if (mainContent) mainContent.classList.remove("expanded");
      if (footer) footer.classList.remove("expanded");
    }
  });

  // Close sidebar when clicking outside on mobile
  document.addEventListener("click", function (event) {
    if (
      window.innerWidth <= 768 &&
      sidebar &&
      !sidebar.contains(event.target) &&
      sidebarToggle &&
      !sidebarToggle.contains(event.target) &&
      sidebar.classList.contains("active")
    ) {
      sidebar.classList.remove("active");
      if (mainContent) mainContent.classList.remove("expanded");
      if (footer) footer.classList.remove("expanded");
    }
  });

  // Action buttons functionality
  const actionButtons = document.querySelectorAll(".action-btn");
  if (actionButtons) {
    actionButtons.forEach((button) => {
      button.addEventListener("click", function (e) {
        e.preventDefault();
        // This would normally handle the button action
        // For demo purposes, we'll just add a clicked class
        this.classList.add("clicked");
        setTimeout(() => {
          this.classList.remove("clicked");
        }, 200);
      });
    });
  }

  // Search functionality
  const searchInput = document.querySelector(".search-bar input");
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      // This would normally filter the products
      // For demo purposes, we'll just focus on the input
      this.classList.add("active");
    });

    searchInput.addEventListener("blur", function () {
      this.classList.remove("active");
    });
  }

  // Filter dropdowns
  const filterSelects = document.querySelectorAll(".filter-dropdown select");
  if (filterSelects) {
    filterSelects.forEach((select) => {
      select.addEventListener("change", function () {
        // This would normally filter products
        // For demo purposes, just apply a class
        this.classList.add("selected");
      });
    });
  }

  // Initialize with default tab
  setActiveTab("dashboard");
});
