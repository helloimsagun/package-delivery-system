<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['account_id'])) {
    // User is already logged in, redirect to the dashboard
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    // Check if the email and password are valid
    $stmt = $pdo->prepare("SELECT * FROM account_details WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && password_verify($password, $result['password'])) {
        $_SESSION['account_id'] = $result['account_id'];
        $_SESSION['email'] = $result['email'];

        // Redirect to the dashboard
        header("Location: ../dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password";
        
        // Redirect to the error page with error message
        header("Location: ../error.php?error=" . urlencode($error));
        exit();
    }
}
?>