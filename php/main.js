var map;
var routeLayer;
var userMarker;
var pickupMarker;
var dropoffMarker;
var pickupCoords;
var dropoffCoords;
var lastLat, lastLng;
var worker;
var graphCreated = false;
var isWithinPickupRange = false;
var deliveryStatus;

function initMap(
  pickup_latitude,
  pickup_longitude,
  dropoff_latitude,
  dropoff_longitude,
  sender_name,
  receiver_name,
  pickup_address,
  receiver_address,
  delivery_status_id
) {
  deliveryStatus = parseInt(delivery_status_id);
  pickupCoords = [pickup_latitude, pickup_longitude];
  dropoffCoords = [dropoff_latitude, dropoff_longitude];

  map = L.map("map").setView(pickupCoords, 13);

  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
  }).addTo(map);

  var pickupIcon = L.icon({
    iconUrl: "pickup-icon.svg",
    iconSize: [50, 50],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32],
  });

  var destIcon = L.icon({
    iconUrl: "destination-icon.svg",
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32],
  });

  // Only add pickup marker if delivery status is 2 (not picked up yet)
  if (deliveryStatus === 2) {
    pickupMarker = L.marker(pickupCoords, { icon: pickupIcon })
      .addTo(map)
      .bindPopup("<strong>Pickup Location</strong><br>Sender: " + sender_name + "<br>Address: " + pickup_address)
      .openPopup();
  }

  dropoffMarker = L.marker(dropoffCoords, { icon: destIcon })
    .addTo(map)
    .bindPopup("<strong>Dropoff Location</strong><br>Receiver: " + receiver_name + "<br>Address: " + receiver_address);

  worker = new Worker('dijkstra-worker.js');
  
  worker.onmessage = function(e) {
    if (e.data.command === 'graphCreated') {
      console.log("Graph created in worker");
      graphCreated = true;
      if (userMarker) {
        console.log("Attempting to show route after graph creation");
        showRoute(userMarker.getLatLng(), deliveryStatus === 2 ? pickupCoords : dropoffCoords);
      }
    } else if (e.data.command === 'pathFound') {
      console.log("Path found:", e.data.path);
      console.log("Coordinates:", e.data.coordinates);
      renderRoute(e.data.path, e.data.coordinates);
    } else if (e.data.command === 'pathNotFound') {
      console.error("No path found between the given points");
    }
  };

  fetchWaypoints();

  var userLat = 27.70849304;
  var userLng = 85.33244305;
  userMarker = L.marker([userLat, userLng], { icon: createIcon("user-icon.svg") })
    .addTo(map)
    .bindPopup("<strong>YOU</strong>")
    .openPopup();

  console.log("User marker created at:", userLat, userLng);

  if (graphCreated) {
    console.log("Graph already created, showing initial route");
    showRoute({lat: userLat, lng: userLng}, deliveryStatus === 2 ? pickupCoords : dropoffCoords);
  } else {
    console.log("Graph not yet created, will show route once it's ready");
  }

  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(onLocationSuccess, onLocationError);
  } else {
    console.error("Geolocation is not supported by this browser.");
  }

  
  var pickupButton = document.querySelector('button[type="submit"].btn-primary');
  if (pickupButton) {
    pickupButton.addEventListener('click', onPickupButtonClick);
  }
}

function onPickupButtonClick(event) {
  if (deliveryStatus === 2 && !isWithinPickupRange) {
    event.preventDefault();
    alert("You haven't reached the pickup location yet. Please get closer to mark as picked up.");
  } else {
    // Allow the form submission to proceed
    deliveryStatus = 3; // Update delivery status to "Picked Up"
    if (pickupMarker) {
      map.removeLayer(pickupMarker); // Remove pickup marker
    }
    showRoute(userMarker.getLatLng(), dropoffCoords); // Show route to dropoff location
  }
}

function onLocationSuccess(position) {
  var userLat = position.coords.latitude;
  var userLng = position.coords.longitude;

  console.log("New user location:", userLat, userLng);

  var distanceMoved = calculateDistance(userLat, userLng, lastLat, lastLng);
  if (distanceMoved > 0.01) { // 10 meters
    lastLat = userLat;
    lastLng = userLng;

    if (userMarker) {
      userMarker.setLatLng([userLat, userLng]);
    } else {
      userMarker = L.marker([userLat, userLng], { icon: createIcon("user-icon.svg") })
        .addTo(map)
        .bindPopup("<strong>YOU</strong>")
        .openPopup();
    }

    console.log("Updating route based on new location");
    showRoute({lat: userLat, lng: userLng}, deliveryStatus === 2 ? pickupCoords : dropoffCoords);

    if (deliveryStatus === 2) {
      var distanceToPickup = calculateDistance(userLat, userLng, pickupCoords[0], pickupCoords[1]);
      console.log("Distance to pickup:", distanceToPickup, "km");

      isWithinPickupRange = distanceToPickup <= 0.01; // 10 meters
      updatePickupButton();

      if (isWithinPickupRange) {
        console.log("Within pickup range");
      }
    }
  }
}

function onLocationError(error) {
  console.error("Geolocation error:", error.message);
}

function createIcon(iconUrl) {
  return L.icon({
    iconUrl: iconUrl,
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32],
  });
}

function showRoute(start, end) {
  if (!graphCreated) {
    console.log("Graph not initialized yet, waiting...");
    setTimeout(function() { showRoute(start, end); }, 1000);
    return;
  }

  console.log("Requesting path from worker");
  worker.postMessage({
    command: 'findPath',
    start: [start.lat, start.lng],
    end: end
  });
}

function renderRoute(path, coordinates) {
  if (path.length === 0 || coordinates.length === 0) {
    console.error("No path found between the given points");
    return;
  }

  console.log("Rendering route with", coordinates.length, "points");

  if (routeLayer) {
    map.removeLayer(routeLayer);
  }

  routeLayer = L.polyline(coordinates, { color: 'blue' }).addTo(map);
  map.fitBounds(routeLayer.getBounds());
  console.log("Route rendered on map");
}

function calculateDistance(lat1, lon1, lat2, lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2 - lat1);
  var dLon = deg2rad(lon2 - lon1);
  var a =
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    Math.sin(dLon/2) * Math.sin(dLon/2);
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  var d = R * c; // Distance in km
  return d;
}

function deg2rad(deg) {
  return deg * (Math.PI/180);
}

function updatePickupButton() {
  var pickupButton = document.querySelector('button[type="submit"].btn-primary');
  if (pickupButton && deliveryStatus === 2) {
    pickupButton.disabled = !isWithinPickupRange;
    pickupButton.title = isWithinPickupRange ? "Mark as Picked Up" : "You must be within 10 meters of the pickup location to mark as picked up";
  }
}

function fetchWaypoints() {
  console.log("Fetching waypoints.json...");
  fetch('waypoints.json')
    .then(function(response) { return response.json(); })
    .then(function(data) {
      console.log("Waypoints data fetched successfully");
      worker.postMessage({ command: 'createGraph', waypoints: data });
    })
    .catch(function(error) {
      console.error("Error fetching or parsing waypoints.json:", error);
    });
}

// Call this function when the page loads
document.addEventListener('DOMContentLoaded', function() {
  updatePickupButton();
});