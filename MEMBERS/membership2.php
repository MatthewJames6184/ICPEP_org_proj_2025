<?php
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/';
    $allowedTypes = ['pdf', 'png', 'jpg', 'jpeg'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (
        isset($_FILES['fileUpload']) &&
        isset($_POST['name']) &&
        isset($_POST['yearLevel']) &&
        isset($_POST['section'])
    ) {
        $file = $_FILES['fileUpload'];
        $name = htmlspecialchars(trim($_POST['name']));
        $yearLevel = htmlspecialchars(trim($_POST['yearLevel']));
        $section = htmlspecialchars(trim($_POST['section']));

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $message = "Error uploading file.";
        } elseif ($file['size'] > $maxSize) {
            $message = "File size exceeds limit (5MB).";
        } else {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedTypes)) {
                $message = "Invalid file type. Allowed: PDF, PNG, JPG, JPEG.";
            } else {
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $newFileName = uniqid('file_', true) . '.' . $ext;
                $destination = $uploadDir . $newFileName;

                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $message = "Upload successful! Name: $name, Year Level: $yearLevel, Section: $section";
                } else {
                    $message = "Failed to save uploaded file.";
                }
            }
        }
    } else {
        $message = "Please fill in all fields and select a file.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Membership</title>
    <link rel="stylesheet" href="membership2.css">
     <style>
        .file-preview a {
            display: inline-block;
            margin-top: 10px;
            color: #004080;
            text-decoration: underline;
            font-weight: bold;
            font-size: 14px;
        }

        .file-preview iframe,
        .file-preview img {
            display: block;
            margin-top: 10px;
            max-width: 100%;
            height: auto;
            border: 1px solid #ccc;
        }
    </style>
</head>

<!--Josef code start here-->
<body class="home-page">
       <div class="blob-outer-container">
    <div class="blob-inner-container">
     <div class="blob"></div>
    </div>
    </div>
<!--ends here-->
    <div class="membership-container">
        <h1>MEMBERSHIP</h1>

  <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        
        <form id="membershipForm" enctype="multipart/form-data" action="upload.php">
            <label for="name">NAME:</label>
            <input type="text" id="name" name="name" required>

            <label for="yearLevel">YEAR LEVEL:</label>
            <input type="text" id="yearLevel" name="yearLevel" required>

            <label for="section">SECTION:</label>
            <input type="text" id="section" name="section" required>


            <div class="upload-box">
                <p>UPLOAD PDF, PNG, JPG FILE</p>

                <input type="file" id="fileUpload" name="fileUpload" accept=".pdf, .png, .jpg, .jpeg">
                <label for="fileUpload" class="custom-upload-label">Choose File</label>
                <div id="filePreview" class="file-preview"></div>
            </div>
        <button type="submit" class="submit-btn">Submit</button>

        </form>
    </div>

     <script>
        document.getElementById("fileUpload").addEventListener("change", function () {
            const label = document.querySelector(".custom-upload-label");
            const preview = document.getElementById("filePreview");
            const file = this.files[0];

            label.textContent = file ? file.name : "Choose File";
            preview.innerHTML = "";

            if (file) {
                const fileType = file.type;
                const reader = new FileReader();

                // Create a clickable file name link
                const fileLink = document.createElement("a");
                fileLink.textContent = file.name;
                fileLink.style.display = "block";
                fileLink.style.marginTop = "10px";
                fileLink.style.color = "#004080";
                fileLink.style.textDecoration = "underline";
                fileLink.target = "_blank";

                if (fileType.startsWith("image/")) {
                    reader.onload = function (e) {
                        fileLink.href = e.target.result;
                        preview.appendChild(fileLink);

                        const img = document.createElement("img");
                        img.src = e.target.result;
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else if (fileType === "application/pdf") {
                    const blob = new Blob([file], { type: fileType });
                    const url = URL.createObjectURL(blob);
                    fileLink.href = url;
                    preview.appendChild(fileLink);

                    const iframe = document.createElement("iframe");
                    iframe.src = url;
                    iframe.width = "100%";
                    iframe.height = "300";
                    preview.appendChild(iframe);
                } else {
                    fileLink.href = "#";
                    fileLink.onclick = function (e) {
                        e.preventDefault();
                        alert("Preview not available for this file type.");
                    };
                    preview.appendChild(fileLink);
                }
            }
        });
    </script>
</body>

</html>