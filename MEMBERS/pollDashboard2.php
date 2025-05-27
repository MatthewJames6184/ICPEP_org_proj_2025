<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>LycanCore Dashboard</title>
    <link rel="icon" href="/images/logo.png" />
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        nav {
            background: #004080;
            color: white;
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            padding: 10px 10px;
            gap: 10px;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav::-webkit-scrollbar {
            display: none;
        }

        .nav-logo {
            margin-left: auto;
            height: 30px;
            cursor: pointer;
            flex-shrink: 0;
        }

        nav a.nav-item {
            color: white;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }

        nav a.nav-item:hover,
        nav a.nav-item.active {
            background-color: #003366;
        }

        #contentFrame {
            width: 100%;
            height: calc(100vh - 52px);
            border: none;
            background: white;
        }

        @media (max-width: 600px) {
            nav {
                gap: 8px;
                padding: 8px;
            }

            nav a.nav-item {
                font-size: 14px;
                padding: 6px 10px;
            }

            .nav-logo {
                height: 25px;
            }

            #contentFrame {
                height: calc(100vh - 50px);
            }
        }

        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
</head>

<body>

    <nav>
        <a href="#" class="nav-item active" data-section="poll2.php">Poll</a>
        <a href="#" class="nav-item" data-section="membership2.php" id="membershipLink">Membership</a>
        <a href="#" class="nav-item" data-section="announcement2.php">Announcement</a>
        <a href="voting_form.php" class="nav-item" data-section="voting_form.php" id="electionLink">Election</a>
        <a href="#" class="nav-item" data-section="get_votes.php">View Votes</a>
        <a href="#" class="nav-item" data-section="profile2.php">Profile</a>
        <img src="icpep name.png" alt="Logo" class="nav-logo" />
    </nav>

    <iframe id="contentFrame" src="poll2.php" title="Content Frame"></iframe>

    <script>
        const navItems = document.querySelectorAll('.nav-item');
        const iframe = document.getElementById('contentFrame');
        const electionLink = document.getElementById('electionLink');
        const membershipLink = document.getElementById('membershipLink');

        // Disable links on page load if already clicked
        if (sessionStorage.getItem('electionClicked')) {
            electionLink.classList.add('disabled');
        }
        if (sessionStorage.getItem('membershipClicked')) {
            membershipLink.classList.add('disabled');
        }

        navItems.forEach(item => {
            item.addEventListener('click', e => {
                e.preventDefault();

                // If clicked item is disabled, do nothing
                if (item.classList.contains('disabled')) return;

                // For election and membership links, show confirmation alert
                if (item === electionLink || item === membershipLink) {
                    const confirmed = window.confirm('Are you sure? You can only access this tab this once!');
                    if (!confirmed) {
                        return;
                    }
                }

                // Remove active class from all
                navItems.forEach(i => i.classList.remove('active'));

                // Add active class to clicked
                item.classList.add('active');

                // Load the selected PHP page into the iframe
                const page = item.getAttribute('data-section');
                iframe.src = page;

                // Record clicks for election and membership and disable
                if (item === electionLink) {
                    sessionStorage.setItem('electionClicked', 'true');
                    electionLink.classList.add('disabled');
                }
                if (item === membershipLink) {
                    sessionStorage.setItem('membershipClicked', 'true');
                    membershipLink.classList.add('disabled');
                }
            });
        });
    </script>

</body>

</html>

