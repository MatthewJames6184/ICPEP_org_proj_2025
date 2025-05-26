document.getElementById('votingForm').addEventListener('submit', function (e) {
    // Check if the user has already voted using cookies
    if (hasUser Voted()) { 
        alert("You have already voted.");
        e.preventDefault(); // Prevent form submission
        return;
    }

    const groups = {};
    let valid = true;

    // Collect selected candidates by group
    document.querySelectorAll('.multi-choice').forEach(input => {
        const group = input.dataset.group;
        if (!groups[group]) groups[group] = [];
        if (input.checked) groups[group].push(input);
    });

    // Validate selections for each group
    Object.keys(groups).forEach(group => {
        const selected = groups[group];
        const abstainSelected = selected.some(i => i.value === 'abstain');
        const otherSelected = selected.filter(i => i.value !== 'abstain');

        if (selected.length === 0) {
            alert(`Please select up to 2 candidates or Abstain for ${group}.`);
            valid = false;
        } else if (abstainSelected && otherSelected.length > 0) {
            alert(`You cannot select candidates and Abstain at the same time in ${group}.`);
            valid = false;
        } else if (otherSelected.length > 2) {
            alert(`You can only select up to 2 candidates for ${group}.`);
            valid = false;
        }
    });

    // If all validations pass, set the vote cookie and submit the form
    if (valid) {
        setVoteCookie(); // Set a cookie to indicate the user has voted
        submitVote(); // Submit the form data to the server
    } else {
        e.preventDefault(); // Prevent form submission if validation fails
    }
});

// Function to check if the user has already voted using cookies
function hasUser Voted() {
    return document.cookie.split(';').some((item) => item.trim().startsWith('hasVoted='));
}

// Function to set a cookie when the user votes
function setVoteCookie() {
    const expires = new Date();
    expires.setFullYear(expires.getFullYear() + 1); // Cookie expires in 1 year
    document.cookie = `hasVoted=true; expires=${expires.toUTCString()}; path=/`;
}

// Function to submit the vote data to the server
function submitVote() {
    const formData = new FormData(document.getElementById('votingForm'));
    fetch('submit_vote.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Your vote has been recorded.");
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error submitting vote:', error);
    });
}

// Function to fetch and display vote results
function fetchVotes() {
    console.log("Fetching votes...");
    fetch('get_votes.php')
        .then(response => response.text())
        .then(html => {
            console.log("Response received");
            document.getElementById('voteResults').innerHTML = html;
        })
        .catch(error => {
            document.getElementById('voteResults').innerHTML = '<p>Error loading vote count.</p>';
            console.error('Fetch error:', error);
        });
}

// Set an interval to fetch votes every 5 seconds
setInterval(fetchVotes, 5000);
fetchVotes();
