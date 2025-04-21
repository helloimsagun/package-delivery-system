document.addEventListener('DOMContentLoaded', function () {
    $('#mapModal').on('shown.bs.modal', function () {
        const map = L.map('map').setView([27.7172, 85.3240], 15);

        L.tileLayer('https://api.maptiler.com/maps/openstreetmap/{z}/{x}/{y}.jpg?key=JJevdl8MYwZXp0bZ00Vm', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Fetch coordinates from PHP
        const locations = JSON.parse(document.getElementById('map-data').innerText);

        // Place markers on the map
        locations.forEach(location => {
            const markerColor = location.location_type === 'pickup' ? 'blue' : 'green';
            const marker = L.marker([location.latitude, location.longitude], {
                icon: L.icon({
                    iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-${markerColor}.png`,
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                })
            }).addTo(map);

            if (location.location_type === 'pickup') {
                map.setView([location.latitude, location.longitude], 15);
            }
        });

        // Show user's current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLatLng = [position.coords.latitude, position.coords.longitude];
                    L.marker(userLatLng, {
                        icon: L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        })
                    }).addTo(map);
                },
                () => {
                    console.error("Unable to retrieve your location.");
                }
            );
        } else {
            console.error("Geolocation is not supported by this browser.");
        }

        // Ensure proper rendering of the map
        setTimeout(() => {
            map.invalidateSize();
        }, 100);
    });
});