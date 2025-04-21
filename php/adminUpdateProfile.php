<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['account_id'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accountId = $_POST['account_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $location = $_POST['default_address'];

        // Update the user's profile details in the database
        $stmt = $pdo->prepare("UPDATE account_details SET name = :name, email = :email, phone_no = :phone, default_location = :location WHERE account_id = :accountId");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':accountId', $accountId);
        $stmt->execute();

        // Redirect to the success page or the desired page after updating the profile
        if (basename($_SERVER['HTTP_REFERER']) == "registered_users.php") {
        header("Location: ../registered_users.php?successAdminUpdate=true");
        exit();
        }elseif (basename($_SERVER['HTTP_REFERER']) == "delivery_personnel.php") {
        header("Location: ../delivery_personnel.php?successAdminUpdateDr=true");
        exit();
        }
    }
} else {
    // User is not logged in, redirect to the login page
    header("Location: ../index.php");
    exit();
}
