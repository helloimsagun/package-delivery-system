<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Orders</title>
    <link rel="stylesheet" href="../styles/dashboard.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="../styles/map.css">
</head>
<body>
    <div>
        <button type="button" class="btn btn-secondary" onclick="goToDashboard()">Dashboard</button>
    </div>
    <h1>Pending Orders</h1>

    <!-- Div to display order details -->
    <div id="order-details">
        <p>Loading orders...</p>
    </div>

    <div class="map-container">
        <div id="map"></div>
    </div>

    <!-- Link external JS file -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script src="main.js"></script> <!-- Your separate JS file -->
    
    <script>
        function goToDashboard() {
        window.location.href = '../dashboard.php'; // Update this URL to your actual dashboard page
    }
</script>
</body>
</html>
