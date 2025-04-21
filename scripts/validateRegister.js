function validateForm() {
    var fullName = document.getElementById("fullName").value;
    var defaultLocation = document.getElementById("defaultLocation").value;
    var phoneNumber = document.getElementById("phoneNumber").value;
    var email = document.getElementById("registerEmail").value;
    var password = document.getElementById("newPassword").value;
    var confirmPassword = document.getElementById("confirmPassword").value;

    // Validate form data
    if (fullName === "" || defaultLocation === "" || phoneNumber === "" || email === "" || password === "" || confirmPassword === "") {
      alert("All fields are required");
      return false;
    }

    if (!validateEmail(email)) {
      alert("Invalid email format");
      return false;
    }

    if (password.length < 8) {
      alert("Password must be at least 8 characters long");
      return false;
    }

    if (password !== confirmPassword) {
      alert("Passwords do not match");
      return false;
    }

    // Form data is valid, submit the form
    return true;
  }

  function validateEmail(email) {
    // Regular expression pattern for email validation
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
  }
