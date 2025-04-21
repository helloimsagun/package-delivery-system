<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['account_id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accountId = $_POST['account_id'];

        // Delete the user from the database
        $stmt = $pdo->prepare("DELETE FROM account_details WHERE account_id = :accountId");
        $stmt->bindParam(':accountId', $accountId);
        $stmt->execute();

        // Redirect to the success page or the desired page after deleting the user
        if (basename($_SERVER['HTTP_REFERER']) == "registered_users.php") {
            header("Location: ../registered_users.php?successDelete=true");
        } elseif (basename($_SERVER['HTTP_REFERER']) == "delivery_personnel.php") {
            header("Location: ../delivery_personnel.php?successDeleteDr=true");
        }
        exit();
    } else {
        // Redirect to the dashboard or the desired page if the request method is not POST
        header("Location: ../dashboard.php");
        exit();
    }
} else {
    // User is not logged in, redirect to the login page
    header("Location: ../index.php");
    exit();
}
