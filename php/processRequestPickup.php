<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['account_id'])) {
    $accountId = $_SESSION['account_id'];
} else {
    // User is not logged in, redirect to the login page
    header("Location: ../index.php");
    exit();
}

// Retrieve the form input values
$pickupAddress = $_POST['pickupAddress'];
$pickupLatitude = $_POST['pickup_latitude'];
$pickupLongitude = $_POST['pickup_longitude'];

$receiverName = $_POST['receiverName'];

$deliveryAddress = $_POST['deliveryAddress'];
$dropoffLatitude = $_POST['dropoff_latitudes'];
$dropoffLongitude = $_POST['dropoff_longitudes'];

$receiverPhone = $_POST['receiverPhone'];
$description = $_POST['description'];

try {
    // Insert the receiver details into the receiver_details table
    $sql = "INSERT INTO receiver_details (name, phone_no) VALUES (:name, :phone_no)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $receiverName, PDO::PARAM_STR);
    $stmt->bindParam(':phone_no', $receiverPhone, PDO::PARAM_STR);
    $stmt->execute();

    // Retrieve the receiver ID from the previous insert
    $receiverId = $pdo->lastInsertId();

    // Insert the request into the package_details table
    $sql = "INSERT INTO package_details 
        (account_id, receiver_id, delivery_status_id, description, pickup_latitude, pickup_longitude, dropoff_latitude, dropoff_longitude, created_on) 
        VALUES 
        (:account_id, :receiver_id, :delivery_status_id, :description, :pickup_latitude, :pickup_longitude, :dropoff_latitude, :dropoff_longitude, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':account_id', $accountId, PDO::PARAM_INT);
    $stmt->bindParam(':receiver_id', $receiverId, PDO::PARAM_INT);
    $stmt->bindValue(':delivery_status_id', 1, PDO::PARAM_INT);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':pickup_latitude', $pickupLatitude, PDO::PARAM_STR);
    $stmt->bindParam(':pickup_longitude', $pickupLongitude, PDO::PARAM_STR);
    $stmt->bindParam(':dropoff_latitude', $dropoffLatitude, PDO::PARAM_STR);
    $stmt->bindParam(':dropoff_longitude', $dropoffLongitude, PDO::PARAM_STR);
    $stmt->execute();

    // Get the auto-generated order code from the previous insert
    $orderCode = $pdo->lastInsertId(); 

    // Insert the pickup address into the address_details table
    $pickupAddressTypeId = 1; // Assuming 1 represents 'Pickup Address'
    $sql = "INSERT INTO address_details (order_code, address_type_id, address) 
            VALUES (:order_code, :address_type_id, :address)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':order_code', $orderCode, PDO::PARAM_INT);
    $stmt->bindParam(':address_type_id', $pickupAddressTypeId, PDO::PARAM_INT);
    $stmt->bindParam(':address', $pickupAddress, PDO::PARAM_STR);
    $stmt->execute();

    // Insert the delivery address into the address_details table
    $deliveryAddressTypeId = 2; // Assuming 2 represents 'Delivery Address'
    $sql = "INSERT INTO address_details (order_code, address_type_id, address) 
            VALUES (:order_code, :address_type_id, :address)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':order_code', $orderCode, PDO::PARAM_INT);
    $stmt->bindParam(':address_type_id', $deliveryAddressTypeId, PDO::PARAM_INT);
    $stmt->bindParam(':address', $deliveryAddress, PDO::PARAM_STR);
    $stmt->execute();

    // Redirect to a success page or display a success message
    header("Location: ../dashboard.php?successRequest=true");
    exit();

} catch (PDOException $e) {
    // Handle any potential errors
    echo "Error: " . $e->getMessage();
    exit();
}
?>
