<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['account_id'])) {
    $accountId = $_SESSION['account_id'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        // Retrieve the user's current password from the database
        $stmt = $pdo->prepare("SELECT password FROM account_details WHERE account_id = :accountId");
        $stmt->bindParam(':accountId', $accountId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashedPassword = $result['password'];

        // Verify the old password
        if (password_verify($oldPassword, $hashedPassword)) {
            // Validate the new password
            if (strlen($newPassword) < 8) {
                $error = "New password must be at least 8 characters long";
                // Redirect to the error page with error message
                header("Location: ../error.php?error=" . urlencode($error));
                exit();
            }

            if ($newPassword !== $confirmPassword) {
                $error = "New passwords do not match";
                // Redirect to the error page with error message
                header("Location: ../error.php?error=" . urlencode($error));
                exit();
            }

            // Hash the new password
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the user's password in the database
            $stmt = $pdo->prepare("UPDATE account_details SET password = :password WHERE account_id = :accountId");
            $stmt->bindParam(':password', $hashedNewPassword);
            $stmt->bindParam(':accountId', $accountId);
            $stmt->execute();

            // Redirect to the success page or the desired page after updating the password
            header("Location: ../dashboard.php?successPassword=true");
            exit();
        } else {
            $error = "Invalid old password";
            // Redirect to the error page with error message
            header("Location: ../error.php?error=" . urlencode($error));
            exit();
        }
    }
} else {
    // User is not logged in, redirect to the login page
    header("Location: ../index.php");
    exit();
}
?>
