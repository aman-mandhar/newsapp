<style>
    #map-wrapper, #map {
        min-height: 300px;
        height: 300px;
        width: 100%;
        border-radius: 10px;
        margin-bottom: 1rem;
    }
</style>

<div id="map-wrapper">
    <div id="map"></div>
</div>

<input type="hidden" id="location_lat" wire:model="location_lat">
<input type="hidden" id="location_lng" wire:model="location_lng">

@push('scripts')
<script>
    document.addEventListener("livewire:load", () => {
        initLeafletMap();
    });

    Livewire.hook('message.processed', () => {
        initLeafletMap();
    });

    function initLeafletMap() {
        console.log("Leaflet Map Initializing..."); // 👈 Add this line for debug

        const mapDiv = document.getElementById('map');
        const latInput = document.getElementById('location_lat');
        const lngInput = document.getElementById('location_lng');

        if (!mapDiv || !latInput || !lngInput) {
            console.warn("Map or input elements not found.");
            return;
        }

        if (mapDiv.dataset.initialized === "true") {
            console.log("Leaflet map already initialized.");
            return;
        }

        mapDiv.dataset.initialized = "true";

        const defaultLat = parseFloat(latInput.value) || 30.7333;
        const defaultLng = parseFloat(lngInput.value) || 76.7794;

        const map = L.map(mapDiv).setView([defaultLat, defaultLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        marker.on('dragend', function (e) {
            const pos = e.target.getLatLng();
            latInput.value = pos.lat;
            lngInput.value = pos.lng;

            Livewire.dispatch('input', { name: 'location_lat', value: pos.lat });
            Livewire.dispatch('input', { name: 'location_lng', value: pos.lng });
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((pos) => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;

                map.setView([lat, lng], 15);
                marker.setLatLng([lat, lng]);

                latInput.value = lat;
                lngInput.value = lng;

                Livewire.dispatch('input', { name: 'location_lat', value: lat });
                Livewire.dispatch('input', { name: 'location_lng', value: lng });
            });
        }
    }
</script>
@endpush

