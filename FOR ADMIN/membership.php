<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Membership</title>
    <link rel="stylesheet" href="membership.css">
</head>

<body>
    <div class="membership-container">
        <h1>MEMBERSHIP</h1>

        <form id="membershipForm" enctype="multipart/form-data">
            <label for="name">NAME:</label>
            <input type="text" id="name" name="name" required>

            <label for="yearLevel">YEAR LEVEL:</label>
            <input type="text" id="yearLevel" name="yearLevel" required>

            <label for="section">SECTION:</label>
            <input type="text" id="section" name="section" required>

            <a href="#" class="payment-link">Available Payment Methods</a>
            <div class="upload-box">
                <p>UPLOAD PDF, PNG, JPG FILE</p>

                <input type="file" id="fileUpload" name="fileUpload" accept=".pdf, .png, .jpg, .jpeg">
                <label for="fileUpload" class="custom-upload-label">Choose File</label>
            </div>


        </form>

        <button class="back-btn" onclick="history.back()">←</button>
    </div>

    <script src="membership.js"></script>
</body>

</html>