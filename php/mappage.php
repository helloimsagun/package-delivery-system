<?php
session_start();
include 'connection.php';

$order_data = null;
$error_message = '';
$accountId = isset($_SESSION['account_id']) ? $_SESSION['account_id'] : null;

if (isset($_POST['order_code'])) {
    $order_code = $_POST['order_code'];

    if ($accountId === null) {
        $error_message = 'User not logged in.';
    } else {
        $sql = "SELECT
                    pd.order_code,
                    pd.created_on,
                    pd.date_assigned,
                    pd.delivery_status_id,
                    ad1.account_id as sender_id,
                    ad1.name as sender_name,
                    rd.name AS receiver_name,
                    ad.address AS receiver_address,
                    ad2.address AS pickup_address,
                    rd.phone_no AS receiver_phone,
                    pd.pickup_latitude,
                    pd.pickup_longitude,
                    pd.dropoff_latitude,
                    pd.dropoff_longitude, 
                    pd.description
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
                WHERE
                    pd.delivery_rider_id = :accountId
                    AND
                    pd.order_code = :order_code
                    AND
                    pd.delivery_status_id IN (2, 3)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':accountId', $accountId, PDO::PARAM_INT);
        $stmt->bindParam(':order_code', $order_code, PDO::PARAM_STR);
        $stmt->execute();

        $order_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order_data) {
            $error_message = 'No packages found for the provided order code or you are not authorized to view this order.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="../styles/dashboard.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="../styles/map.css">
</head>
<body>
    <div>
        <button type="button" class="btn btn-secondary" onclick="goToDashboard()">Dashboard</button>
    </div>
   
    <div style="text-align: center;">
        <h1>Order Details</h1>
        <form method="POST" action="">
            <div class="order-input">
                <label for="order-code">Enter Order Code:</label>
                <input type="text" id="order-code" name="order_code" placeholder="Enter order code" required>
                <button type="submit">View Order</button>
            </div>
        </form>
    </div>

    <div id="order-details">
        <?php if ($order_data): ?>
            <div class="order-box" style="margin:20px">
                <p><strong>Order No.</strong> <?php echo htmlspecialchars($order_data['order_code']); ?></p>
                <p><strong>Receiver:</strong> <?php echo htmlspecialchars($order_data['receiver_name']); ?></p>
                <p><strong>Receiver Phone:</strong> <?php echo htmlspecialchars($order_data['receiver_phone']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($order_data['description']); ?></p>

                <!-- Mark as Picked Up Form -->
                <?php if ($order_data['delivery_status_id'] == 2): ?>
                    <form action="processPickedUp.php" method="POST">
                        <input type="hidden" name="order_code" value="<?php echo htmlspecialchars($order_data['order_code']); ?>">
                        <button type="submit" class="btn btn-primary">Mark as Picked Up</button>
                    </form>
                <?php elseif ($order_data['delivery_status_id'] == 3): ?>
                    <!-- Mark as Delivered Form -->
                    <form action="processDelivered.php" method="POST">
                        <input type="hidden" name="order_code" value="<?php echo htmlspecialchars($order_data['order_code']); ?>">
                        <button type="submit" class="btn btn-success">Mark as Delivered</button>
                    </form>
                <?php endif; ?>

                <div class="map-container">
                    <div id="map"></div>
                </div>
            </div>
        <?php elseif (!empty($error_message)): ?>
            <p id="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/@turf/turf/turf.min.js"></script></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js'></script>

    <script src="dijkstra.js"></script>
    <script src="main.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if ($order_data && isset($order_data['pickup_latitude']) && isset($order_data['pickup_longitude'])): ?>
            initMap(
                <?php echo json_encode($order_data['pickup_latitude']); ?>,
                <?php echo json_encode($order_data['pickup_longitude']); ?>,
                <?php echo json_encode($order_data['dropoff_latitude']); ?>,
                <?php echo json_encode($order_data['dropoff_longitude']); ?>,
                <?php echo json_encode($order_data['sender_name']); ?>,
                <?php echo json_encode($order_data['receiver_name']); ?>,
                <?php echo json_encode($order_data['pickup_address']); ?>,
                <?php echo json_encode($order_data['receiver_address']); ?>,
                <?php echo json_encode($order_data['delivery_status_id']); ?>
            );
        <?php else: ?>
            console.error("Map data not available.");
        <?php endif; ?>
    });

        function goToDashboard() {
            window.location.href = '../dashboard.php'; 
        }
    </script>
</body>
</html>
