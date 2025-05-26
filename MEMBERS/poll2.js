document.addEventListener('DOMContentLoaded', () => {
  const voteButtons = document.querySelectorAll('#vote-buttons button');
  const voteMessage = document.getElementById('vote-message');

  voteButtons.forEach(button => {
    button.addEventListener('click', () => {
      const voteOption = button.getAttribute('data-vote');

      console.log("User clicked:", voteOption); // ✅ Debug: which button was clicked

      voteMessage.textContent = 'Submitting your vote...';

      fetch('', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'vote_option=' + encodeURIComponent(voteOption)
      })
        .then(response => {
          console.log("Raw fetch response:", response); // ✅ Debug: response object

          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          console.log("Parsed response data:", data); // ✅ Debug: JSON response

          if (data.success) {
            const container = document.querySelector('.container');

            const resultHTML = `
    <h1>Do you like this poll system?</h1>
    <p class="voted-msg">Thank you for voting!</p>
    <div class="results-bar">F
      <div class="yes-result" style="width: ${data.percent_yes}%">
        Yes (${data.votes.yes} votes)
      </div>
      <div class="no-result" style="width: ${data.percent_no}%">
        No (${data.votes.no} votes)
      </div>
    </div>
    <p>Total votes: ${data.total_votes}</p>
  `;

            container.innerHTML = resultHTML;
          } else {
            voteMessage.textContent = data.message || 'Error submitting vote.';
            console.warn("Vote failed with message:", data.message);
          }


        })
        .catch(error => {
          console.error("Fetch error:", error); // ✅ Debug: network or server error
          voteMessage.textContent = 'Network or server error.';
          window.location.reload();
        });
    });
  });
});
