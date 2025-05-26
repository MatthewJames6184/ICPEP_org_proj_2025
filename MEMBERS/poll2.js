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
          // Refresh the page to show updated results
          window.location.reload();
        } else {
          voteMessage.textContent = data.message || 'Error submitting vote.';
          console.warn("Vote failed with message:", data.message); // ✅ Debug: error from server
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
