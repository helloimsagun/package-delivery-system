<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['account_id'])) {
    $accountId = $_SESSION['account_id'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $location = $_POST['location'];

        // Update the user's profile details in the database
        $stmt = $pdo->prepare("UPDATE account_details SET name = :name, email = :email, phone_no = :phone, default_location = :location WHERE account_id = :accountId");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':accountId', $accountId);
        $stmt->execute();

        // Redirect to the success page or the desired page after updating the profile
        header("Location: ../dashboard.php?successProfile=true");
        exit();
    }
} else {
    // User is not logged in, redirect to the login page
    header("Location: ../index.php");
    exit();
}
?>
