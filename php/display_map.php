<?php
// Connection setup
require_once 'connection.php';

$orderCode = 11; // Example order code

try {
    // Fetch pickup and dropoff coordinates from the package_details table
    $sql = "SELECT pickup_latitude AS latitude, pickup_longitude AS longitude, 'pickup' AS location_type
            FROM package_details
            WHERE order_code = :order_code
            UNION
            SELECT dropoff_latitude AS latitude, dropoff_longitude AS longitude, 'dropoff' AS location_type
            FROM package_details
            WHERE order_code = :order_code";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':order_code', $orderCode, PDO::PARAM_INT);
    $stmt->execute();
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($locations)) {
        echo "No locations found for this order.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Location Map</title>
    <link href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" rel="stylesheet" />
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        #map {
            height: 500px;
            width: 80%;
            max-width: 100%;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .button-container {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<!-- Button Container -->
<div class="button-container">
    <a href="dashboard.php" class="btn btn-secondary">Go Back to Dashboard</a>
    <button id="findPathBtn" class="btn">Find Shortest Path</button>
</div>

<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
// Initialize the map with Leaflet
const map = L.map('map').setView([27.7172, 85.3240], 10); // Default center and zoom

// Add OpenStreetMap tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Fetch coordinates from PHP
const locations = <?php echo json_encode($locations); ?>;

let pickupLocation = null;
let dropoffLocation = null;
let userLocation = null;

// Assign locations from PHP data and place markers
locations.forEach(location => {
    const marker = L.marker([location.latitude, location.longitude])
        .addTo(map)
        .bindPopup(location.location_type.charAt(0).toUpperCase() + location.location_type.slice(1) + " Location");

    if (location.location_type === 'pickup') {
        pickupLocation = [location.latitude, location.longitude];
        marker.openPopup();
    } else if (location.location_type === 'dropoff') {
        dropoffLocation = [location.latitude, location.longitude];
    }
});

// Function to handle pathfinding between custom markers
function findShortestPath(start, end, callback) {
    const url = `https://api.openrouteservice.org/v2/directions/driving-car?api_key=5b3ce3597851110001cf624812d3db8d1e56f85990f2b6c2f81cd915&start=${start[1]},${start[0]}&end=${end[1]},${end[0]}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.routes && data.routes.length > 0) {
                const coordinates = data.routes[0].geometry.coordinates;
                const latLngs = coordinates.map(coord => [coord[1], coord[0]]); // Reverse lat and lng

                const polyline = L.polyline(latLngs, { color: 'blue' }).addTo(map);
                map.fitBounds(polyline.getBounds());

                if (callback) callback();
            } else {
                alert('No route found.');
            }
        })
        .catch(err => {
            console.error('Error fetching route:', err);
        });
}

// Show user's current location
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        (position) => {
            userLocation = [position.coords.latitude, position.coords.longitude];
            
            const userMarker = L.marker(userLocation, { icon: L.icon({ iconUrl: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png' }) })
                .addTo(map)
                .bindPopup("Your Location")
                .openPopup();

            map.setView(userLocation, 12); // Zoom in to user's location
        },
        () => {
            alert('Could not retrieve your location.');
        }
    );
}

// Event listener for the "Find Shortest Path" button
document.getElementById('findPathBtn').addEventListener('click', function() {
    if (userLocation && pickupLocation && dropoffLocation) {
        // First, find the path from userLocation to pickupLocation
        findShortestPath(userLocation, pickupLocation, function() {
            // Once the first path is drawn, find the path from pickupLocation to dropoffLocation
            findShortestPath(pickupLocation, dropoffLocation);
        });
    } else {
        alert("User location, pickup, and dropoff locations must be set.");
    }
});
</script>

</body>
</html>
