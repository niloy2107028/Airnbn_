let mapToken1 = mapToken;

// Check if mapbox token is valid
if (!mapToken1 || mapToken1 === "your-mapbox-access-token") {
    console.error(
        "⚠️ Invalid Mapbox token! Please get a token from https://account.mapbox.com/access-tokens/"
    );
    document.getElementById("map").innerHTML =
        '<div style="padding: 20px; background: #fff3cd; border: 1px solid #ffc107; border-radius: 4px; text-align: center;"><h4>📍 Map Unavailable</h4><p>Mapbox access token is not configured.</p><p>Get a free token at <a href="https://account.mapbox.com/access-tokens/" target="_blank">Mapbox.com</a> and add it to your .env file as MAPBOX_ACCESS_TOKEN</p></div>';
} else {
    mapboxgl.accessToken = mapToken1;

    // Get coordinates from listing
    const coordinates = listing.geometry?.coordinates ||
        listing.geometry_coordinates || [0, 0];

    // Validate coordinates
    if (!Array.isArray(coordinates) || coordinates.length !== 2) {
        console.error("Invalid coordinates:", coordinates);
        document.getElementById("map").innerHTML =
            '<div style="padding: 20px; background: #fff3cd; border: 1px solid #ffc107; border-radius: 4px; text-align: center;"><h4>📍 Location Data Missing</h4><p>Coordinates are not available for this listing.</p></div>';
    } else {
        const map = new mapboxgl.Map({
            container: "map", // container ID
            style: "mapbox://styles/mapbox/streets-v12",
            center: coordinates, // starting position [lng, lat]
            zoom: 9, // starting zoom
        });

        const marker = new mapboxgl.Marker({ color: "red" })
            .setLngLat(coordinates)
            .setPopup(
                new mapboxgl.Popup({ offset: 35 })
                    .setHTML(`<h4>${listing.title}</h4>
    <p>Exact location will be provided after booking</p>`)
            )
            .addTo(map);
    }
}
