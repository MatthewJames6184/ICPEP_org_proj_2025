document.getElementById("uploadBtn").addEventListener("click", function () {
    const fileInput = document.getElementById("fileUpload");
    if (!fileInput.files.length) {
        alert("Please select a file to upload.");
        return;
    }

    const formData = new FormData(document.getElementById("membershipForm"));

    fetch("uploadHandler.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert("Upload successful: " + result);
    })
    .catch(error => {
        console.error("Error uploading file:", error);
        alert("Upload failed.");
    });

    document.getElementById("fileUpload").addEventListener("change", function () {
    const label = document.querySelector(".custom-upload-label");
    const fileName = this.files[0] ? this.files[0].name : "Choose File";
    label.textContent = fileName;
});

});

document.getElementById('membershipForm').addEventListener('submit', function(e) {
    e.preventDefault(); // prevent default form submission

    const form = e.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert("You are verified!\n\n" + result);
        form.reset();
    })
    .catch(error => {
        alert("Upload failed. Please try again.");
        console.error(error);
    });
});

