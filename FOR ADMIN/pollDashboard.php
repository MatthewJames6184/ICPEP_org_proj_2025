<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f0f4f8;
        }

        nav {
            background: #004080;
            color: white;
            display: flex;
            padding: 10px 20px;
            gap: 15px;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-logo {
            margin-left: auto;
            height: 30px;
            /* small height */
            cursor: pointer;
        }

        nav a.nav-item {
            color: white;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        nav a.nav-item:hover,
        nav a.nav-item.active {
            background-color: #003366;
        }

        #contentFrame {
            width: 100%;
            height: calc(100vh - 52px);
            /* full viewport height minus nav height */
            border: none;
            background: white;
        }
    </style>
</head>

<body>

    <nav>
        <a href="#" class="nav-item active" data-section="poll.php">Poll</a>
        <a href="#" class="nav-item" data-section="membership.php">Membership</a>
        <a href="#" class="nav-item" data-section="announcement.php">Announcement</a>
        <a href="#" class="nav-item" data-section="/voting/voting_form.php">Election</a>
        <a href="#" class="nav-item" data-section="profile.php">Profile</a>
        <img src="icpep name.png" alt="Logo" class="nav-logo" />

    </nav>

    <iframe id="contentFrame" src="poll.php" title="Content Frame"></iframe>

    <script>
        const navItems = document.querySelectorAll('.nav-item');
        const iframe = document.getElementById('contentFrame');

        navItems.forEach(item => {
            item.addEventListener('click', e => {
                e.preventDefault();

                // Remove active class from all
                navItems.forEach(i => i.classList.remove('active'));

                // Add active class to clicked
                item.classList.add('active');

                // Load the selected PHP page into the iframe
                const page = item.getAttribute('data-section');
                iframe.src = page;
            });
        });
    </script>

</body>

</html>