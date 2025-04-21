<?php
if (!isset($_SESSION['account_id'])) {
    // User is not logged in, redirect to the login page
    header("Location: index.php");
    exit();
}

$accountId = $_SESSION['account_id'];

// Fetch the user's type from the database
$stmt = $pdo->prepare("SELECT type_id,name,email,phone_no,default_location FROM account_details WHERE account_id = :accountId");
$stmt->bindParam(':accountId', $accountId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$userType = $user['type_id'];
?>