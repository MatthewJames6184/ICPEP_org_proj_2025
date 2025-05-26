document.addEventListener('DOMContentLoaded', () => {
  const voteButtons = document.querySelectorAll('#vote-buttons button');
  const voteMessage = document.getElementById('vote-message');

  voteButtons.forEach(button => {
    button.addEventListener('click', () => {
      const voteOption = button.getAttribute('data-vote');

      voteMessage.textContent = 'Submitting your vote...';

      fetch('', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'vote_option=' + encodeURIComponent(voteOption)
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Refresh the page to show updated results
          window.location.reload();
        } else {
          voteMessage.textContent = data.message || 'Error submitting vote.';
        }
      })
      .catch(() => {
        voteMessage.textContent = 'Network or server error.';
        window.location.reload();
      });
    });
  });
});
