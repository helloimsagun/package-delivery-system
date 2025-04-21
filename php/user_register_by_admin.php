<?php
session_start();
require_once 'connection.php';
if (isset($_SESSION['account_id'])) {
    // Retrieve the submitted form data
    $name = $_POST['name'];
    $defaultAddress = $_POST['default_location'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $vehicleType = $_POST['vehicle_type'];  
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM account_details WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $error = "Email is already registered";
        // Redirect to the error page with error message
        header("Location: ../error.php?error=" . urlencode($error));
        exit();
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (basename($_SERVER['HTTP_REFERER']) == "registered_users.php") {
            $sql = "INSERT INTO account_details (name, default_location, phone_no, email,type_id,password,created_on) VALUES (:name, :defaultAddress, :phone, :email,1,:password,NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':defaultAddress', $defaultAddress);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            $accountId = $pdo->lastInsertId();

            if ($stmt) {
                header("Location: ../registered_users.php?successRegister=true");
                exit();
            } else {
                $error = "Failed to register user.";
                header("Location: ../error.php?error=" . urlencode($error));
                exit();
            }
        } elseif (basename($_SERVER['HTTP_REFERER']) == "delivery_personnel.php") {
            $sql = "INSERT INTO account_details (name, default_location, phone_no, email,type_id,password,created_on) VALUES (:name, :defaultAddress, :phone, :email,3,:password,NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':defaultAddress', $defaultAddress);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            $accountId = $pdo->lastInsertId(); // Get the last inserted account ID

            // Insert vehicle details for the delivery rider
            $sql = "INSERT INTO vehicle_types (account_id, vehicle_type) VALUES (:account_id, :vehicle_type)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':account_id', $accountId);
            $stmt->bindParam(':vehicle_type', $vehicleType);
            $stmt->execute();


            if ($stmt) {
                header("Location: ../delivery_personnel.php?successRegisterDr=true");
                exit();
            } else {
                $error = "Failed to register user.";
                header("Location: ../error.php?error=" . urlencode($error));
                exit();
            }
        }
    }
} else {
    // User is not logged in, redirect to the login page
    header("Location: ../index.php");
    exit();
}
