// Include Leaflet CSS and JS in your HTML file:
// <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
// <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

function initializeMap(
  containerId,
  defaultCenter = [27.7172, 85.324],
  defaultZoom = 15
) {
  console.log("Initializing map...");
  const mapContainer = document.getElementById(containerId);
  if (!mapContainer) {
    console.error(`Map container with id "${containerId}" not found`);
    return null;
  }

  // Ensure the map container has a height
  mapContainer.style.height = '400px';

  const map = L.map(containerId).setView(defaultCenter, defaultZoom);

  L.tileLayer('https://api.maptiler.com/maps/openstreetmap/{z}/{x}/{y}.jpg?key=JJevdl8MYwZXp0bZ00Vm', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  console.log("Map initialized");

  let userMarker = null;
  let pickupMarker = null;
  let dropoffMarker = null;

  function updateCoordinates(lat, lng, markerType) {
    console.log(`Updating ${markerType} coordinates: ${lat}, ${lng}`);
    if (markerType === "pickup") {
      document.getElementById("pickup_latitude").value = lat;
      document.getElementById("pickup_longitude").value = lng;
    } else if (markerType === "dropoff") {
      document.getElementById("dropoff_latitudes").value = lat;
      document.getElementById("dropoff_longitudes").value = lng;
    }
  }

  function updateAddress(lat, lng, markerType) {
    console.log(`Updating address for ${markerType}`);
    const url = `https://api.maptiler.com/geocoding/${lng},${lat}.json?key=JJevdl8MYwZXp0bZ00Vm`;
    fetch(url)
      .then(response => response.json())
      .then(data => {
        if (data.features && data.features.length > 0) {
          const address = data.features[0].place_name;
          console.log(`New address: ${address}`);
          if (markerType === "pickup") {
            document.getElementById("pickupAddress").value = address;
          } else if (markerType === "dropoff") {
            document.getElementById("deliveryAddress").value = address;
          }
        }
      })
      .catch(error => console.error('Error:', error));
  }

  function placeMarker(lat, lng, markerType) {
    console.log(`Placing ${markerType} marker at ${lat}, ${lng}`);
    let marker = L.marker([lat, lng], {
      draggable: true,
      icon: L.icon({
        iconUrl: markerType === "pickup" ? 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png' : 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
      })
    }).addTo(map);

    updateCoordinates(lat, lng, markerType);
    updateAddress(lat, lng, markerType);

    marker.on("dragend", function () {
      const latlng = marker.getLatLng();
      console.log(`${markerType} marker dragged to ${latlng.lat}, ${latlng.lng}`);
      updateCoordinates(latlng.lat, latlng.lng, markerType);
      updateAddress(latlng.lat, latlng.lng, markerType);
    });

    return marker;
  }

  function placeUserMarker(latlng) {
    console.log(`Placing user marker at ${latlng}`);
    if (userMarker) {
      userMarker.setLatLng(latlng);
    } else {
      userMarker = L.marker(latlng, {
        icon: L.icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
          shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
          iconSize: [25, 41],
          iconAnchor: [12, 41],
          popupAnchor: [1, -34],
          shadowSize: [41, 41]
        })
      }).addTo(map);
    }
    map.setView(latlng, 15);
  }

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const userLatlng = [position.coords.latitude, position.coords.longitude];
        console.log(`User location: ${userLatlng}`);
        placeUserMarker(userLatlng);
      },
      () => {
        console.error("Unable to retrieve your location.");
        placeUserMarker(defaultCenter);
      }
    );
  } else {
    console.error("Geolocation is not supported by this browser.");
    placeUserMarker(defaultCenter);
  }

  const pickupAddressInput = document.getElementById("pickupAddress");
  const deliveryAddressInput = document.getElementById("deliveryAddress");

  if (pickupAddressInput) {
    pickupAddressInput.addEventListener("change", function () {
      console.log("Pickup address changed");
      const address = this.value;
      geocodeAddress(address, function (lat, lng) {
        if (pickupMarker) {
          pickupMarker.setLatLng([lat, lng]);
        } else {
          pickupMarker = placeMarker(lat, lng, "pickup");
        }
        map.setView([lat, lng], 15);
      });
    });
  } else {
    console.error("Pickup address input not found");
  }

  if (deliveryAddressInput) {
    deliveryAddressInput.addEventListener("change", function () {
      console.log("Delivery address changed");
      const address = this.value;
      geocodeAddress(address, function (lat, lng) {
        if (dropoffMarker) {
          dropoffMarker.setLatLng([lat, lng]);
        } else {
          dropoffMarker = placeMarker(lat, lng, "dropoff");
        }
        map.setView([lat, lng], 15);
      });
    });
  } else {
    console.error("Delivery address input not found");
  }

  return map;
}

document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM fully loaded");
  const requestPickupModal = document.getElementById("requestPickupModal");
  if (requestPickupModal) {
    console.log("Request pickup modal found");
    $(requestPickupModal).on("shown.bs.modal", function () {
      console.log("Modal shown, initializing map");
      const map = initializeMap("map");
      if (map) {
        map.invalidateSize();
      } else {
        console.error("Failed to initialize map");
      }
    });
  } else {
    console.error("Request pickup modal not found");
  }
});

function geocodeAddress(address, callback) {
  console.log(`Geocoding address: ${address}`);
  const geocodeUrl = `https://api.maptiler.com/geocoding/${encodeURIComponent(
    address
  )}.json?key=JJevdl8MYwZXp0bZ00Vm`;

  fetch(geocodeUrl)
    .then((response) => response.json())
    .then((data) => {
      if (data.features && data.features.length > 0) {
        const [lng, lat] = data.features[0].center;
        console.log(`Geocoded coordinates: ${lat}, ${lng}`);
        callback(lat, lng);
      } else {
        console.error("Geocoding failed: Address not found.");
      }
    })
    .catch((error) => {
      console.error("Geocoding failed:", error);
    });
}