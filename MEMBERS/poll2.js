document.addEventListener('DOMContentLoaded', () => {
  const voteButtons = document.querySelectorAll('#vote-buttons button');
  const voteMessage = document.getElementById('vote-message');
  const container = document.querySelector('.container');

  voteButtons.forEach(button => {
    button.addEventListener('click', () => {
      const voteOption = button.getAttribute('data-vote');
      voteMessage.textContent = 'Submitting your vote...';

      fetch('poll2.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'vote_option=' + encodeURIComponent(voteOption)
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          container.innerHTML = `
            <h1>Do you like this poll system?</h1>
            <p class="voted-msg">Thank you for voting!</p>
            <div class="results-bar">
              <div class="yes-result" style="width: ${data.percent_yes}%">Yes (${data.votes.yes} votes)</div>
              <div class="no-result" style="width: ${data.percent_no}%">No (${data.votes.no} votes)</div>
            </div>
            <p>Total votes: ${data.total_votes}</p>
          `;
        } else {
          voteMessage.textContent = data.message || 'Error submitting vote.';
        }
      })
      .catch(() => {
        voteMessage.textContent = 'Network or server error.';
      });
    });
  });
});
