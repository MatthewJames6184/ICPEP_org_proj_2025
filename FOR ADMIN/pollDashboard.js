const sections = {
  poll: 'poll.php',
  membership: 'membership.php',
  announcement: 'announcement.php',
  election: 'election.php',
  profile: 'profile.php',
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
