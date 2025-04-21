<?php
require_once 'connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderCode = $_POST['order_code'];

    // Update the package status to "In Transit"
    $sql = "UPDATE package_details SET delivery_status_id = 3, date_received = NOW() WHERE order_code = :orderCode";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':orderCode', $orderCode);
    $stmt->execute();
    if ($stmt->execute()) {
        header('Location: ../dashboard.php?successPickedUp=true');
        exit;
    } else {
        // Handle the update failure
        $error = "Failed to mark as picked up.";
        header('Location: ../dashboard.php?error=' . $error);
        exit;
    }
}
?>