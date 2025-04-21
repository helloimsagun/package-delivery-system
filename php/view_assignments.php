<?php
require_once 'connection.php';
require_once 'location_based_assignment.php';

// Function to get pending requests
function getPendingRequests($pdo) {
    $pendingSql = "SELECT
                    pd.order_code,
                    pd.created_on,
                    pd.date_received,
                    pd.date_delivered,
                    pd.date_assigned,
                    ad1.account_id as sender_id,
                    ad1.name as sender_name,
                    rd.name AS receiver_name,
                    ad.address AS receiver_address,
                    ad2.address AS pickup_address,
                    rd.phone_no AS receiver_phone,
                    pd.description,
                    (SELECT ad.name FROM account_details ad WHERE pd.delivery_rider_id = ad.account_id) AS delivery_rider_name,
                    (SELECT ad.phone_no FROM account_details ad WHERE pd.delivery_rider_id = ad.account_id) AS delivery_rider_phone,
                    ds.status_name AS delivery_status,
                    pd.remarks
                FROM
                    package_details pd
                JOIN
                    account_details ad1 ON pd.account_id = ad1.account_id
                JOIN
                    receiver_details rd ON pd.receiver_id = rd.receiver_id
                JOIN
                    address_details ad ON pd.order_code = ad.order_code AND ad.address_type_id = 2
                JOIN
                    address_details ad2 ON pd.order_code = ad2.order_code AND ad2.address_type_id = 1
                JOIN
                    delivery_status ds ON pd.delivery_status_id = ds.status_id
                WHERE pd.delivery_status_id IN (1, 2)"; // Pending and waiting for pickup

    $pendingStmt = $pdo->query($pendingSql);
    return $pendingStmt->fetchAll(PDO::FETCH_ASSOC);
}

$message = '';

// Handle auto-assign request
if (isset($_POST['auto_assign'])) {
    $result = runAutoAssignment();
    $message = $result;
}

$pendingRequests = getPendingRequests($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Tasks</title>
    <link rel="stylesheet" href="../styles/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assign.js"></script>
</head>
<body>
    <h1>Assign Tasks</h1>
    
    <?php if (!empty($message)): ?>
    <div id="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <button id="autoAssignBtn">Auto Assign Riders</button>
    
    <h2>Pending Requests</h2>
    <table id="pendingRequestsTable" border="1">
        <thead>
            <tr>
                <th>Order Code</th>
                <th>Sender Name</th>
                <th>Pickup Address</th>
                <th>Receiver Name</th>
                <th>Receiver Phone</th>
                <th>Description</th>
                <th>Status</th>
                <th>Assigned Rider</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendingRequests as $request): ?>
                <tr>
                    <td><?php echo htmlspecialchars($request['order_code']); ?></td>
                    <td><?php echo htmlspecialchars($request['sender_name']); ?></td>
                    <td><?php echo htmlspecialchars($request['pickup_address']); ?></td>
                    <td><?php echo htmlspecialchars($request['receiver_name']); ?></td>
                    <td><?php echo htmlspecialchars($request['receiver_phone']); ?></td>
                    <td><?php echo htmlspecialchars($request['description']); ?></td>
                    <td><?php echo htmlspecialchars($request['delivery_status']); ?></td>
                    <td><?php echo htmlspecialchars($request['delivery_rider_name'] ?? 'Not assigned'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>