// Function to validate the form
function validateForm() {
    var oldPassword = document.getElementById("oldPassword").value;
    var newPassword = document.getElementById("newPassword").value;
    var confirmPassword = document.getElementById("confirmPassword").value;

    // Validate old password
    if (oldPassword === "") {
        alert("Please enter your old password");
        return false;
    }

    // Validate new password
    if (newPassword === "") {
        alert("Please enter your new password");
        return false;
    }

    // Validate password length
    if (newPassword.length < 8) {
        alert("New password must be at least 8 characters long");
        return false;
    }

    // Validate password match
    if (newPassword !== confirmPassword) {
        alert("New passwords do not match");
        return false;
    }

    return true;
}
