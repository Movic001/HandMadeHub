// Mobile Menu Toggle
const mobileMenu = document.getElementById("mobile-menu");
const navLinks = document.getElementById("nav-links");

mobileMenu.addEventListener("click", () => {
  navLinks.classList.toggle("active");

  // Change hamburger icon
  const icon = mobileMenu.querySelector("i");
  if (navLinks.classList.contains("active")) {
    icon.classList.remove("fa-bars");
    icon.classList.add("fa-times");
  } else {
    icon.classList.remove("fa-times");
    icon.classList.add("fa-bars");
  }
});

// Close menu when clicking outside
document.addEventListener("click", (e) => {
  if (
    !mobileMenu.contains(e.target) &&
    !navLinks.contains(e.target) &&
    navLinks.classList.contains("active")
  ) {
    navLinks.classList.remove("active");
    const icon = mobileMenu.querySelector("i");
    icon.classList.remove("fa-times");
    icon.classList.add("fa-bars");
  }
});

// Password visibility toggle
function togglePasswordVisibility() {
  const passwordInput = document.getElementById("password");
  const toggleIcon = document.querySelector(".toggle-password i");

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    toggleIcon.classList.remove("fa-eye");
    toggleIcon.classList.add("fa-eye-slash");
  } else {
    passwordInput.type = "password";
    toggleIcon.classList.remove("fa-eye-slash");
    toggleIcon.classList.add("fa-eye");
  }
}

// Form validation
const form = document.querySelector(".login-form");

form.addEventListener("submit", (e) => {
  const email = document.getElementById("email");
  const password = document.getElementById("password");

  if (!email.value.includes("@")) {
    e.preventDefault();
    alert("Please enter a valid email address");
    email.focus();
  } else if (password.value.length < 6) {
    e.preventDefault();
    alert("Password must be at least 6 characters long");
    password.focus();
  }
});
