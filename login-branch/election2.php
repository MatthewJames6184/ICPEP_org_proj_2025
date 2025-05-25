<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Election of Officers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }
        h1, h2 {
            color: #004080;
        }
        .position {
            margin-bottom: 30px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 15px;
        }
        .poll {
            margin-top: 10px;
        }
        canvas {
            margin: 10px;
        }
        .add-form {
            margin-top: 30px;
            padding: 20px;
            background: #eef3fa;
            border-radius: 10px;
        }
        .add-form input {
            margin: 5px;
        }
        button {
            background-color: #004080;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>ELECTION OF OFFICERS</h1>

    <?php
    // Placeholder: Load positions and candidates from database (future)
    // Example:
    // $positions = loadPositionsFromDatabase();
    ?>

    <form id="electionForm" method="POST" action="submit.php">
        <div id="positionsContainer"></div>
        <button type="submit">Submit Vote</button>
    </form>

    <div class="add-form">
        <h2>Add New Position</h2>
        <input type="text" id="newPosition" placeholder="Position Title" required>
        <select id="chooseNumber">
            <option value="1">Choose 1</option>
            <option value="2">Choose 2</option>
        </select>
        <input type="text" id="candidates" placeholder="Candidates (comma separated)" required>
        <button type="button" onclick="addPosition()">Add Position</button>
    </div>

    <h2>Real-Time Polls</h2>
    <div id="pollResults" class="poll"></div>
</div>

<script>
const positions = [
    { title: "PRESIDENT", choose: 1, candidates: ["Anderson, Marie L.", "Torres, Kelvin D."] },
    { title: "VICE PRESIDENT INTERNAL", choose: 1, candidates: ["Anderson, Marie L.", "Torres, Kelvin D."] },
    { title: "QUIZZER", choose: 2, candidates: ["Anderson, Marie L.", "Torres, Kelvin D."] }
];

function renderForm() {
    const container = document.getElementById("positionsContainer");
    const polls = document.getElementById("pollResults");
    container.innerHTML = '';
    polls.innerHTML = '';

    positions.forEach((pos, posIndex) => {
        const div = document.createElement("div");
        div.className = "position";
        div.innerHTML = `<h2>${pos.title} (choose ${pos.choose})</h2>`;
        
        pos.candidates.forEach((candidate, i) => {
            const inputType = pos.choose > 1 ? "checkbox" : "radio";
            const name = pos.title.toLowerCase().replace(/ /g, "_");
            const input = `<label><input type="${inputType}" name="${name}${inputType === 'checkbox' ? '[]' : ''}" value="${candidate}" onchange="updatePoll(${posIndex}, '${candidate}')"> ${candidate}</label><br>`;
            div.innerHTML += input;
        });

        container.appendChild(div);

        // Poll Canvas
        const canvas = document.createElement("canvas");
        canvas.width = 100;
        canvas.height = 100;
        canvas.id = `poll_${posIndex}`;
        polls.appendChild(canvas);
        drawPoll(canvas.id, 0, pos.title);
    });
}

function addPosition() {
    const title = document.getElementById("newPosition").value;
    const choose = parseInt(document.getElementById("chooseNumber").value);
    const candidateList = document.getElementById("candidates").value.split(",").map(c => c.trim());

    if (title && candidateList.length > 0) {
        positions.push({ title, choose, candidates: candidateList });
        renderForm();
        document.getElementById("newPosition").value = "";
        document.getElementById("candidates").value = "";
    }
}

const votes = {};

function updatePoll(posIndex, candidate) {
    const key = `pos_${posIndex}`;
    if (!votes[key]) votes[key] = {};
    if (!votes[key][candidate]) votes[key][candidate] = 0;
    votes[key][candidate] += 1;

    const totalVotes = Object.values(votes[key]).reduce((a, b) => a + b, 0);
    const topVote = Math.max(...Object.values(votes[key]));
    const percentage = totalVotes > 0 ? Math.round((topVote / totalVotes) * 100) : 0;

    drawPoll(`poll_${posIndex}`, percentage, positions[posIndex].title);
}

function drawPoll(id, percentage, title) {
    const canvas = document.getElementById(id);
    const ctx = canvas.getContext("2d");
    ctx.clearRect(0, 0, 100, 100);

    ctx.beginPath();
    ctx.arc(50, 50, 40, 0, 2 * Math.PI);
    ctx.strokeStyle = "#ddd";
    ctx.lineWidth = 10;
    ctx.stroke();

    ctx.beginPath();
    ctx.arc(50, 50, 40, -0.5 * Math.PI, (percentage / 100) * 2 * Math.PI - 0.5 * Math.PI);
    ctx.strokeStyle = "#004080";
    ctx.lineWidth = 10;
    ctx.stroke();

    ctx.fillStyle = "#004080";
    ctx.font = "14px Arial";
    ctx.textAlign = "center";
    ctx.fillText(`${percentage}%`, 50, 55);
}

document.getElementById("electionForm").addEventListener("submit", function (e) {
    // Placeholder: This form would submit to submit.php in production
    // It could be used to insert votes into the database.
    alert("Votes submitted (placeholder only)");
    e.preventDefault();
});

renderForm();
</script>
</body>
</html>
