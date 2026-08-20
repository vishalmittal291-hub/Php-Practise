<!--
    Wires up the two toggles from nav.php: the hamburger button (mobile
    nav panel) and the avatar button (profile dropdown).

    README note: this <script> used to be commented out, which is why
    neither button did anything — it's active now.
-->
<script>
  const mobileMenuButton = document.getElementById('mobile-menu-button');
  const mobileMenuPanel = document.getElementById('mobile-menu-panel');
  const profileMenuButton = document.getElementById('profile-menu-button');
  const profileMenu = document.getElementById('profile-menu');

  mobileMenuButton?.addEventListener('click', () => {
    mobileMenuPanel.classList.toggle('hidden');
  });

  profileMenuButton?.addEventListener('click', () => {
    profileMenu.classList.toggle('hidden');
  });

  // Clicking anywhere else closes the profile dropdown.
  document.addEventListener('click', (event) => {
    if (!profileMenuButton.contains(event.target) && !profileMenu.contains(event.target)) {
      profileMenu.classList.add('hidden');
    }
  });
</script>
