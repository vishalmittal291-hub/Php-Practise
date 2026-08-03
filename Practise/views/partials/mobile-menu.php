<!-- <script>
// Mobile menu toggle
const mobileMenuButton = document.getElementById("mobile-menu-button");
const mobileMenu = document.getElementById("mobile-menu");
const menuOpenIcon = document.getElementById("menu-open-icon");
const menuCloseIcon = document.getElementById("menu-close-icon");

mobileMenuButton.addEventListener("click", () => {
  mobileMenu.classList.toggle("hidden");
  menuOpenIcon.classList.toggle("hidden");
  menuCloseIcon.classList.toggle("hidden");
});

// User dropdown toggle
const userMenuButton = document.getElementById("user-menu-button");
const userMenu = document.getElementById("user-menu");

userMenuButton.addEventListener("click", () => {
  userMenu.classList.toggle("show");
});

// Close dropdown when clicking outside
document.addEventListener("click", (event) => {
  if (
    !userMenuButton.contains(event.target) &&
    !userMenu.contains(event.target)
  ) {
    userMenu.classList.remove("show");
  }
});
</script> -->