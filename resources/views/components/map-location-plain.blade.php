@php
    // Defaults for old usage (register page)
    $mapId    = $mapId ?? 'map';
    $wrapperId = $wrapperId ?? 'map-wrapper';

    $latName  = $latName ?? 'location_lat';
    $lngName  = $lngName ?? 'location_lng';

    $latId    = $latId ?? 'location_lat';
    $lngId    = $lngId ?? 'location_lng';

    $height   = $height ?? 300;

    // Defaults
    $defaultLat = $defaultLat ?? 30.7333;
    $defaultLng = $defaultLng ?? 76.7794;

    $readonly = $readonly ?? false;     // ✅ new
    $showLocate = $showLocate ?? false; // ✅ new (review page me false)
@endphp

<style>
    #{{ $wrapperId }}, #{{ $mapId }} {
        min-height: {{ (int)$height }}px;
        height: {{ (int)$height }}px;
        width: 100%;
        border-radius: 10px;
        margin-bottom: 1rem;
    }
</style>

<div id="{{ $wrapperId }}">
    <div id="{{ $mapId }}"></div>
</div>

{{-- Hidden Fields (name + id configurable) --}}
<input type="hidden" name="{{ $latName }}" id="{{ $latId }}" value="{{ old($latName, old('latitude', $latValue ?? '')) }}">
<input type="hidden" name="{{ $lngName }}" id="{{ $lngId }}" value="{{ old($lngName, old('longitude', $lngValue ?? '')) }}">

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    initPlainLeafletMap_{{ preg_replace('/[^a-zA-Z0-9_]/', '_', $mapId) }}();
});

function initPlainLeafletMap_{{ preg_replace('/[^a-zA-Z0-9_]/', '_', $mapId) }}() {
    const mapDiv = document.getElementById(@json($mapId));
    const latInput = document.getElementById(@json($latId));
    const lngInput = document.getElementById(@json($lngId));

    if (!mapDiv || !latInput || !lngInput) return;

    if (mapDiv.dataset.initialized === "true") return;
    mapDiv.dataset.initialized = "true";

    const defaultLat = parseFloat(latInput.value) || {{ (float)$defaultLat }};
    const defaultLng = parseFloat(lngInput.value) || {{ (float)$defaultLng }};

    const map = L.map(mapDiv).setView([defaultLat, defaultLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const marker = L.marker([defaultLat, defaultLng], { draggable: !@json($readonly) }).addTo(map);
    marker.bindTooltip(@json($readonly ? "Business Location (read-only)" : "Drag me to your exact location")).openTooltip();

    function sync(lat, lng){
        latInput.value = lat;
        lngInput.value = lng;
    }

    marker.on('dragend', function (e) {
            const pos = e.target.getLatLng();
            sync(pos.lat, pos.lng);
    });
    

    if (!@json($readonly)) {
        map.on('click', function(e){
            marker.setLatLng(e.latlng);
            sync(e.latlng.lat, e.latlng.lng);
        });
    }

    // Optional: auto locate
        navigator.geolocation.getCurrentPosition((pos) => {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;

            map.setView([lat, lng], 15);
            marker.setLatLng([lat, lng]);
            sync(lat, lng);
        });
    
}
</script>
@endpush
