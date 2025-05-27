const sections = {
  poll: 'poll2.php',
  membership: 'membership2.php',
  announcement: 'announcement2.php',
  view: 'get_votes.php',
  profile: 'profile2.php',
};

function loadSection(section) {
  // Full page load to ensure PHP functionality works properly
  window.location.href = sections[section];
}

document.addEventListener('DOMContentLoaded', () => {
  const navItems = document.querySelectorAll('.nav-item');

  navItems.forEach(item => {
    item.addEventListener('click', (e) => {
      e.preventDefault();
      const section = item.getAttribute('data-section');
      loadSection(section);
    });
  });
});
