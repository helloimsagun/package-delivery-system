<?php
require_once 'connection.php';
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the order code and remarks from the form
    $orderCode = $_POST['order_code'];
    $remarks = $_POST['remarks'];

    // Update the delivery status and remarks in the package_details table
    $sql = "UPDATE package_details SET delivery_status_id = 5, remarks = :remarks WHERE order_code = :order_code";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':remarks', $remarks, PDO::PARAM_STR);
    $stmt->bindParam(':order_code', $orderCode, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        // Redirect to the page showing pickup requests
        header('Location: ../dashboard.php?successCancel=true');
        exit;
    } else {
        // Handle the update failure
        $error="Failed to assign delivery personnel.";
        header('Location: ../dashboard.php?error=' . $error);
        exit;
    }
}
?>
