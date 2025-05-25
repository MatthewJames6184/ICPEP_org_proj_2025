document.getElementById('votingForm').addEventListener('submit', function (e) {
    const groups = {};
    let valid = true;

    document.querySelectorAll('.multi-choice').forEach(input => {
        const group = input.dataset.group;
        if (!groups[group]) groups[group] = [];
        if (input.checked) groups[group].push(input);
    });

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

    if (!valid) e.preventDefault();
});
function fetchVotes() {
    console.log("Fetching votes..."); // NEW
    fetch('get_votes.php')
        .then(response => response.text())
        .then(html => {
            console.log("Response received"); // NEW
            document.getElementById('voteResults').innerHTML = html;
        })
        .catch(error => {
            document.getElementById('voteResults').innerHTML = '<p>Error loading vote count.</p>';
            console.error('Fetch error:', error);
        });
}

setInterval(fetchVotes, 5000);
fetchVotes();