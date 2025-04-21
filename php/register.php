<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['account_id'])) {
    // User is already logged in, redirect to the dashboard
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $defaultLocation = $_POST['defaultLocation'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['registerEmail'];
    $password = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate form data
    if (empty($fullName) || empty($defaultLocation) || empty($phoneNumber) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required";
        // Redirect to the error page with error message
        header("Location: ../error.php?error=" . urlencode($error));
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
        // Redirect to the error page with error message
        header("Location: ../error.php?error=" . urlencode($error));
        exit();
    }

    if (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long";
        // Redirect to the error page with error message
        header("Location: ../error.php?error=" . urlencode($error));
        exit();
    }

    if ($password !== $confirmPassword) {
        $error = "Passwords do not match";
        // Redirect to the error page with error message
        header("Location: ../error.php?error=" . urlencode($error));
        exit();
    }


    // Check if the email is already registered
    $stmt = $pdo->prepare("SELECT * FROM account_details WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $error = "Email is already registered";
        // Redirect to the error page with error message
        header("Location: ../error.php?error=" . urlencode($error));
        exit();
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match";
        // Redirect to the error page with error message
        header("Location: ../error.php?error=" . urlencode($error));
        exit();
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $stmt = $pdo->prepare("INSERT INTO account_details (name, email, password, phone_no, default_location,type_id,created_on) VALUES (:name, :email, :password, :phone, :location,1,NOW())");
        $stmt->bindParam(':name', $fullName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':phone', $phoneNumber);
        $stmt->bindParam(':location', $defaultLocation);
        $stmt->execute();

        $_SESSION['account_id'] = $pdo->lastInsertId();
        $_SESSION['email'] = $email;

        // Redirect to the dashboard
        header("Location: ../dashboard.php");
        exit();
    }
}
?>