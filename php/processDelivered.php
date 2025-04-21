<?php
require_once 'connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderCode = $_POST['order_code'];

    // Update the package status to "Delivered"
    $sql = "UPDATE package_details SET delivery_status_id = 4, date_delivered =NOW() WHERE order_code = :orderCode";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':orderCode', $orderCode);
    $stmt->execute();
    if ($stmt->execute()) {
        header('Location: ../dashboard.php?successDelivered=true');
        exit;
    } else {
        // Handle the update failure
        $error = "Failed to mark as delivered.";
        header('Location: ../dashboard.php?error=' . $error);
        exit;
    }
}
?>